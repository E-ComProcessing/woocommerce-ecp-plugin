<?php
/*
Plugin Name: WooCommerce E-Comprocessing Payment Gateway Client
Description: Extends WooCommerce's Checkout with E-Comprocessing's Gateway
Version: 1.1.0
*/

if ( !function_exists('woocommerce_ecomprocessing_init') ):
	function woocommerce_ecomprocessing_init()
	{
	    if ( !class_exists( 'WC_Payment_Gateway' ) ) return;

		// Load text Domain
	    load_plugin_textdomain('woocommerce_ecomprocessing', false, 'languages');

		// Get Genesis class
		include dirname( __FILE__ ) . '/includes/WC_EComProcessing_Checkout.php';

		/**
		 * Add the EComProcessing Gateway to WooCommerce's
		 * list of installed gateways
		 *
		 * @param $methods Array of existing Payment Gateways
		 *
		 * @return array $methods Appended Payment Gateway
		 */
		if ( !function_exists('woocommerce_add_ecomprocessing_gateway') ):
		    function woocommerce_add_ecomprocessing_gateway($methods) {
			    array_push($methods, 'WC_EComProcessing_Checkout');
		        return $methods;
		    }
		endif;

	    add_filter('woocommerce_payment_gateways', 'woocommerce_add_ecomprocessing_gateway' );
	}
endif;
add_action('plugins_loaded', 'woocommerce_ecomprocessing_init', 0);
