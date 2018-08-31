<?php
/*
 * Plugin Name: WooCommerce E-ComProcessing Payment Gateway Client
 * Description: Extend WooCommerce's Checkout options with E-ComProcessing's Genesis Gateway
 * Text Domain: woocommerce-ecomprocessing
 * Author: E-ComProcessing
 * Version: 1.8.3
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/* there is no need to load the plugin if woocommerce is not active */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

    if (!function_exists('woocommerce_ecomprocessing_init')) {
        function woocommerce_EComProcessing_init()
        {
            if (!class_exists('WC_Payment_Gateway')) {
                return;
            }

            $translation = load_plugin_textdomain(
                'woocommerce-ecomprocessing', false, basename(__DIR__) . DIRECTORY_SEPARATOR . 'languages');

            if (!$translation) {
                error_log('Unable to load language file for locale: ' . get_locale());
            }

            include dirname(__FILE__) . '/libraries/genesis/vendor/autoload.php';

            include dirname(__FILE__) . '/includes/wc_ecomprocessing_checkout.php';

            include dirname(__FILE__) . '/includes/wc_ecomprocessing_direct.php';

            /**
             * Add the EComProcessing Gateway to WooCommerce's
             * list of installed gateways
             *
             * @param $methods Array of existing Payment Gateways
             *
             * @return array $methods Appended Payment Gateway
             */
            if (!function_exists('woocommerce_add_ecomprocessing_gateway')) {
                function woocommerce_add_EComProcessing_gateway($methods)
                {
                    array_push($methods, 'WC_ecomprocessing_Checkout');
                    array_push($methods, 'WC_ecomprocessing_Direct');

                    return $methods;
                }
            }

            add_filter('woocommerce_payment_gateways', 'woocommerce_add_ecomprocessing_gateway');
        }
    }

    add_action('plugins_loaded', 'woocommerce_ecomprocessing_init', 0);

}
