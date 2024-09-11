<?php
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
 * @package     includes\blocks\class-wc-ecomprocessing-blocks-direct
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Ecomprocessing Blocks Direct module
 */
final class WC_Ecomprocessing_Blocks_Direct extends WC_Ecomprocessing_Blocks_Base {

	/**
	 * Payment method name/id/slug.
	 *
	 * @var string
	 */
	protected $name = WC_Ecomprocessing_Constants::ECOMPROCESSING_DIRECT_BLOCKS;

	/**
	 * Only settings required for the frontend
	 *
	 * @var array
	 */
	private $required_settings = array(
		WC_Ecomprocessing_Direct::SETTING_KEY_SHOW_CC_HOLDER,
	);

	/**
	 * Initializes the payment method type.
	 *
	 * @SuppressWarnings(PHPMD.MissingImport)
	 */
	public function initialize() {
		$options        = array(
			'draw_transaction_tree'          => false,
			'blocks_instantiate'             => true,
			'register_renewal_subscriptions' => false,
		);
		$this->gateway  = new WC_Ecomprocessing_Direct( $options );
		$this->supports = $this->gateway->supports;
		$this->settings = $this->get_filtered_plugin_settings(
			'woocommerce_ecomprocessing_direct_settings',
			$this->required_settings
		);
	}

	/**
	 * Returns an array of scripts/handles to be registered for this payment method.
	 * new WC_Payment_Gateway();
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
				'version'      => WC_Ecomprocessing_Helper::get_plugin_version(),
			);
		$script_url        = WC_Ecomprocessing_Constants::plugin_url() . $script_path;

		wp_register_script(
			'wc-ecomprocessing-payments-blocks-direct',
			$script_url,
			$script_asset['dependencies'],
			$script_asset['version'],
			true
		);

		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations(
				'wc-ecomprocessing-payments-blocks-direct',
				'woocommerce-ecomprocessing',
				WC_Ecomprocessing_Constants::plugin_abspath() . 'languages/'
			);
		}

		return array( 'wc-ecomprocessing-payments-blocks-direct' );
	}

	/**
	 * Returns an array of key=>value pairs of data made available to the payment methods script.
	 *
	 * @return array
	 */
	public function get_payment_method_data() {
		return array(
			'title'             => $this->settings['title'],
			'description'       => $this->settings['description'],
			'supports'          => array_filter( $this->gateway->supports, array( $this->gateway, 'supports' ) ),
			'show_cc_holder'    => $this->settings['show_cc_holder'],
			'iframe_processing' => $this->settings['iframe_processing'],
		);
	}
}
