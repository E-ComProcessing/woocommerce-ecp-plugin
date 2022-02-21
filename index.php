<?php
/*
 * Plugin Name: WooCommerce E-Comprocessing Payment Gateway Client
 * Plugin URI: https://wordpress.org/plugins/ecomprocessing-payment-page-for-woocommerce/
 * Description: Extend WooCommerce's Checkout options with E-Comprocessing's Genesis Gateway
 * Text Domain: woocommerce-ecomprocessing
 * Author: E-Comprocessing
 * Author URI: https://e-comprocessing.com/
 * Version: 1.12.3
 * Requires at least: 4.0
 * Tested up to: 5.9
 * WC requires at least: 3.0.0
 * WC tested up to: 6.1.1
 * WCS tested up to: 4.0.1
 * License: GPL-2.0
 * License URI: http://opensource.org/licenses/gpl-2.0.php
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/* there is no need to load the plugin if woocommerce is not active */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	if ( ! function_exists( 'woocommerce_ecomprocessing_init' ) ) {
		function woocommerce_EComprocessing_init() {
			if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
				return;
			}

			$translation = load_plugin_textdomain(
				'woocommerce-ecomprocessing',
				false,
				basename( __DIR__ ) . DIRECTORY_SEPARATOR . 'languages'
			);

			if ( ! $translation ) {
				error_log( 'Unable to load language file for locale: ' . get_locale() );
			}

			include dirname( __FILE__ ) . '/libraries/genesis/vendor/autoload.php';

			include dirname( __FILE__ ) . '/includes/wc_ecomprocessing_checkout.php';

			include dirname( __FILE__ ) . '/includes/wc_ecomprocessing_direct.php';

			/**
			 * Add the ecomprocessing Gateway to WooCommerce's
			 * list of installed gateways
			 *
			 * @param $methods Array of existing Payment Gateways
			 *
			 * @return array $methods Appended Payment Gateway
			 */
			if ( ! function_exists( 'woocommerce_add_ecomprocessing_gateway' ) ) {
				function woocommerce_add_EComprocessing_gateway( $methods ) {
					array_push( $methods, 'WC_EComprocessing_Checkout' );
					array_push( $methods, 'WC_EComprocessing_Direct' );

					return $methods;
				}
			}

			add_filter( 'woocommerce_payment_gateways', 'woocommerce_add_ecomprocessing_gateway' );
		}
	}

	add_action( 'plugins_loaded', 'woocommerce_ecomprocessing_init', 0 );

}
