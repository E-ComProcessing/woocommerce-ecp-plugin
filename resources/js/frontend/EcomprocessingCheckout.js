/**
 * Copyright (C) 2018-2024 E-Comprocessing Ltd.
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * @author      E-Comprocessing Ltd.
 * @copyright   2018-2024 E-Comprocessing Ltd.
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2 (GPL-2.0)
 * @package     resources/js/frontend/EcomprocessingCheckout
 */

import {__} from '@wordpress/i18n';
import {decodeEntities} from '@wordpress/html-entities';
import {getSetting} from '@woocommerce/settings';
import ModalBlock from './ModalBlock';
import React, {useEffect} from 'react';

const checkoutSettings = getSetting('ecomprocessing-checkout-blocks_data', {});
const METHOD_NAME      = 'ecomprocessing_checkout';

let EcomprocessingBlocksCheckout = {};

if (Object.keys(checkoutSettings).length) {
    const defaultLabel = __('Ecomprocessing checkout', 'woocommerce-ecomprocessing');
    const label        = decodeEntities(checkoutSettings.title) || defaultLabel;

    const Label = (props) => {
        const {PaymentMethodLabel} = props.components;

        return <PaymentMethodLabel text={label} />;
    };

    const Description = (props) => {
        const {eventRegistration, emitResponse}        = props;
        const {onPaymentProcessing, onCheckoutSuccess} = eventRegistration;

        useEffect(() => {
            if (checkoutSettings.iframe_processing !== 'yes') {
                return;
            }

            const handleCheckoutSuccess = (props) => {
                const parentDiv   = document.querySelector('.ecp-threeds-modal');
                const iframe      = document.querySelector('.ecp-threeds-iframe');
                const redirectUrl = props.processingResponse.paymentDetails.blocks_redirect;

                parentDiv.style.display = 'block';
                iframe.style.display    = 'block';
                iframe.src              = redirectUrl;
            };
            const unsubscribe = onCheckoutSuccess(handleCheckoutSuccess);

            return () => {
                unsubscribe();
            };
        }, [onCheckoutSuccess, checkoutSettings.iframe_processing]);

        useEffect(() => {
            const unsubscribe = onPaymentProcessing(
                async () => {
                    const paymentMethodData = {
                        [`${METHOD_NAME}_blocks_order`]: true
                    };

                    return {
                        type: emitResponse.responseTypes.SUCCESS,
                        meta: {
                            paymentMethodData,
                        },
                    };
                }
            );

            return () => {
                unsubscribe();
            };
        }, [emitResponse.responseTypes.ERROR, emitResponse.responseTypes.SUCCESS, onPaymentProcessing]);

        return (
            <>
            <p>{decodeEntities(checkoutSettings.description || '')}</p>
        <ModalBlock />
        </>
    );
    };

    EcomprocessingBlocksCheckout = {
        name: "ecomprocessing_checkout",
        label: <Label />,
        content: <Description />,
        edit: <Description />,
        canMakePayment: () => true,
        ariaLabel: label,
        supports: {
        features: checkoutSettings.supports
    },
};
}

export default EcomprocessingBlocksCheckout;
