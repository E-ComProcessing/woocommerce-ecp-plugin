/*
 * Copyright (C) 2018-2023 E-Comprocessing Ltd.
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
 * @copyright   2018-2023 E-Comprocessing Ltd.
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2 (GPL-2.0)
 */

const ecpPopulateBrowserParams = {
	methodName: 'ecomprocessing_direct',
	fieldNames: [
		'java_enabled',
		'color_depth',
		'browser_language',
		'screen_height',
		'screen_width',
		'user_agent',
		'browser_timezone_zone_offset',
	],
	initParameters: function() {
		let fieldNames = this.fieldNames;

		try {
			// method deprecated
			fieldNames['java_enabled'] = navigator.javaEnabled();
		} catch (e) {
			fieldNames['java_enabled'] = false;
		}
		fieldNames['color_depth']      = screen.colorDepth;
		fieldNames['browser_language'] = navigator.language;
		fieldNames['screen_height']    = screen.height;
		fieldNames['screen_width']     = screen.width;
		fieldNames['user_agent']       = navigator.userAgent;

		let browserTime = new Date();
		fieldNames['browser_timezone_zone_offset'] = browserTime.getTimezoneOffset();
	},
	populateParameters: function(document) {
		this.fieldNames.forEach(
			function (fieldName) {
				let inputElement = document.querySelector('#' + this.methodName + '_' + fieldName);
				if (inputElement) {
					inputElement.setAttribute('value', this.fieldNames[fieldName]);
				}
			}, this
		)
	},
	execute: function (document) {
		this.initParameters();
		this.populateParameters(document);
	}
};

document.addEventListener('DOMContentLoaded', function () {
	ecpPopulateBrowserParams.execute(document);

	jQuery(function ($) {
		const paymentMethod                = 'ecomprocessing_direct'
		const checkoutForm                 = $('form.checkout');
		const threedsHelperControllerRegEx = /wc_ecomprocessing_threeds_form_helper/gi;

		checkoutForm.on('checkout_place_order_success', function(event, data) {
			if (
				! data.redirect.match(threedsHelperControllerRegEx) ||
				checkoutForm.find('input[name="payment_method"]:checked').val() !== paymentMethod
			) {
				return;
			}

			const parentDiv = document.querySelector('.ecp-threeds-modal');
			const iframe    = document.querySelector('.ecp-threeds-iframe');

			this.style.opacity = 0.6;

			try {
				fetch(data.redirect, {
					method: 'GET',
				})
					.then(function (response) {
						return response.text()
					})
					.then(function (html) {
						const doc = iframe.contentWindow.document;
						doc.open();
						doc.write(html);
						doc.close();
						parentDiv.style.display = 'block';
					})
				data.messages = '<div class="ecp-payment-notice">The payment is being processed</div>';
			} catch (e) {
				return true;
			}

			return false;
		})
	})
});
