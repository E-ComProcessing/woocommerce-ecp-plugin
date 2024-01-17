import { __ } from '@wordpress/i18n';
import { decodeEntities } from '@wordpress/html-entities';

const settings = wc_ecomprocessing_settings.settings || {};
const supports = wc_ecomprocessing_settings.supports || {};

const defaultLabel = __('ECOMPROCESSING checkout', 'woocommerce-ecomprocessing');
const label = decodeEntities(settings.title) || defaultLabel;

const Label = (props) => {
	const { PaymentMethodLabel } = props.components;
	return <PaymentMethodLabel text={label} />;
};

const Description = () => {
	return (
		<p>{decodeEntities(settings.description || '')}</p>
	);
};

const ECOMPROCESSINGBlocksCheckout = {
	name: "ecomprocessing_checkout",
	label: <Label />,
	content: <Description />,
	edit: <Description />,
	canMakePayment: () => true,
	ariaLabel: label,
	supports: {
		features: supports,
	},
};

export default ECOMPROCESSINGBlocksCheckout;
