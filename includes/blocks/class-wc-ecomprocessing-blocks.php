<?php
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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;

/**
 * Ecomprocessing Blocks module
 */
final class WC_Ecomprocessing_Blocks extends AbstractPaymentMethodType {

	/**
	 * Payment method name/id/slug.
	 *
	 * @var string
	 */
	protected $name = WC_Ecomprocessing_Constants::ECOMPROCESSING_CHECKOUT_BLOCKS;

	/**
	 * The gateway instance.
	 *
	 * @var WC_ecomprocessing_Checkout
	 */
	private $gateway;

	/**
	 * Only settings, needed for the frontend part
	 *
	 * @var array
	 */
	private $necessary_settings = array(
		'title',
		'description',
	);

	/**
	 * Initializes the payment method type.
	 */
	public function initialize() {
		$options        = array(
			'draw_transaction_tree' => false,
		);
		$this->settings = $this->get_only_necessary_settings();
		$this->gateway  = new WC_ecomprocessing_Checkout( $options );
		$this->supports = $this->gateway->supports;
	}

	/**
	 * Returns if this payment method should be active. If false, the scripts will not be enqueued.
	 *
	 * @return boolean
	 */
	public function is_active() {
		return $this->gateway->is_available();
	}

	/**
	 * new WC_Payment_Gateway();
	 *
	 * Returns an array of scripts/handles to be registered for this payment method.
	 *
	 * @return array
	 */
	public function get_payment_method_script_handles() {
		$script_path       = '/assets/js/frontend/blocks.js';
		$script_asset_path = WC_Ecomprocessing_Constants::plugin_abspath() . 'assets/js/frontend/blocks.asset.php';
		$script_asset      = file_exists( $script_asset_path )
			? require $script_asset_path
			: array(
				'dependencies' => array(),
				'version'      => WC_ecomprocessing_Helper::get_plugin_version(),
			);
		$script_url        = WC_Ecomprocessing_Constants::plugin_url() . $script_path;

		wp_register_script(
			'wc-ecomprocessing-payments-blocks',
			$script_url,
			$script_asset['dependencies'],
			$script_asset['version'],
			true
		);

		// Export plugin settings to the frontend script
		wp_localize_script(
			'wc-ecomprocessing-payments-blocks',
			'wc_ecomprocessing_settings',
			array(
				'settings' => $this->settings,
				'supports' => $this->supports,
			)
		);

		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations(
				'wc-ecomprocessing-payments-blocks',
				'woocommerce-ecomprocessing',
				WC_Ecomprocessing_Constants::plugin_abspath() . 'languages/'
			);
		}

		return array( 'wc-ecomprocessing-payments-blocks' );
	}

	/**
	 * Returns an array of key=>value pairs of data made available to the payment methods script.
	 *
	 * @return array
	 */
	public function get_payment_method_data() {
		return array(
			'title'       => $this->settings['title'],
			'description' => $this->settings['description'],
			'supports'    => array_filter( $this->gateway->supports, array( $this->gateway, 'supports' ) ),
		);
	}

	/**
	 * Get array with the necessary settings only
	 *
	 * @return array
	 */
	private function get_only_necessary_settings() {
		$all_settings       = get_option( 'woocommerce_ecomprocessing_checkout_settings', array() );
		$necessary_settings = array_flip( $this->necessary_settings );

		return array_intersect_key( $all_settings, $necessary_settings );
	}
}
