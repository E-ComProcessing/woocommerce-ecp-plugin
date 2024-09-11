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
 * @package     assets/javascript/payment_settings_business_attributes.js
 */

jQuery( document ).ready(
	function () {
		var query = jQuery(
			'[name="woocommerce_ecomprocessing_checkout_business_attributes_enabled"],' +
			'[name="woocommerce_ecomprocessing_direct_business_attributes_enabled"]'
		);

		var element = jQuery( query[0] );

		ecomprocessing_business_attributes_show_blocks( false );
		if ( element.is( ':checked' ) ) {
			ecomprocessing_business_attributes_show_blocks( true );
		}

		element.on(
			"change",
			function () {
				if ( this.checked ) {
					ecomprocessing_business_attributes_show_blocks( true );
				} else {
					ecomprocessing_business_attributes_show_blocks( false )
				}
			}
		);

		function ecomprocessing_business_attributes_show_blocks(show) {
			ecomprocessing_business_attributes_block(
				show,
				'[id="woocommerce_ecomprocessing_checkout_business_flight_attributes"],' +
				'[id="woocommerce_ecomprocessing_direct_business_flight_attributes"]'
			);
			ecomprocessing_business_attributes_block(
				show,
				'[id="woocommerce_ecomprocessing_checkout_business_furniture_attributes"],' +
				'[id="woocommerce_ecomprocessing_direct_business_furniture_attributes"]'
			);
			ecomprocessing_business_attributes_block(
				show,
				'[id="woocommerce_ecomprocessing_checkout_business_event_attributes"],' +
				'[id="woocommerce_ecomprocessing_direct_business_event_attributes"]'
			);
			ecomprocessing_business_attributes_block(
				show,
				'[id="woocommerce_ecomprocessing_checkout_business_hotel_and_estates_rentals_attributes"],' +
				'[id="woocommerce_ecomprocessing_direct_business_hotel_and_estates_rentals_attributes"]'
			);
			ecomprocessing_business_attributes_block(
				show,
				'[id="woocommerce_ecomprocessing_checkout_business_car_boat_plane_rentals_attributes"],' +
				'[id="woocommerce_ecomprocessing_direct_business_car_boat_plane_rentals_attributes"]'
			);
			ecomprocessing_business_attributes_block(
				show,
				'[id="woocommerce_ecomprocessing_checkout_business_car_boat_plane_rentals_attributes"],' +
				'[id="woocommerce_ecomprocessing_direct_business_car_boat_plane_rentals_attributes"]'
			);
			ecomprocessing_business_attributes_block(
				show,
				'[id="woocommerce_ecomprocessing_checkout_business_cruise_attributes"],' +
				'[id="woocommerce_ecomprocessing_direct_business_cruise_attributes"]'
			);
			ecomprocessing_business_attributes_block(
				show,
				'[id="woocommerce_ecomprocessing_checkout_business_travel_attributes"],' +
				'[id="woocommerce_ecomprocessing_direct_business_travel_attributes"]'
			);
		}

		function ecomprocessing_business_attributes_block(show, selector) {
			var query = jQuery( selector );

			if (query.length < 1) {
				return;
			}

			var title = jQuery( query[0] );
			title.hide();
			title.next().hide();
			if ( show ) {
				title.show();
				title.next().show();
			}
		}
	}
);
