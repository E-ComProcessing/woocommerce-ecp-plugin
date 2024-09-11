<?php
/**
 * Plugin Name: WooCommerce E-Comprocessing Payment Gateway Client
 * Plugin URI: https://wordpress.org/plugins/ecomprocessing-payment-page-for-woocommerce/
 * Description: Extend WooCommerce's Checkout options with ecomprocessing's Genesis Gateway
 * Text Domain: woocommerce-ecomprocessing
 * Author: ecomprocessing
 * Author URI: https://e-comprocessing.com/
 * Version: 1.16.1
 * Requires at least: 4.0
 * Tested up to: 6.6
 * WC requires at least: 3.0.0
 * WC tested up to: 9.1.4
 * WCS tested up to: 6.5.0
 * WCB tested up to: 11.7.0
 * License: GPL-2.0
 * License URI: http://opensource.org/licenses/gpl-2.0.php
 *
 * @package index.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/* there is no need to load the plugin if woocommerce is not active */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {

	if ( ! function_exists( 'woocommerce_ecomprocessing_init' ) ) {
		/**
		 * Init woocommerce ecomprocessing plugin.
		 */
		function woocommerce_ecomprocessing_init() {
			if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
				return;
			}

			$translation = load_plugin_textdomain(
				'woocommerce-ecomprocessing',
				false,
				basename( __DIR__ ) . DIRECTORY_SEPARATOR . 'languages'
			);

			if ( ! $translation ) {
				if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
					error_log( 'Unable to load language file for locale: ' . get_locale() ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
				}
			}

			include __DIR__ . '/libraries/genesis/vendor/autoload.php';
			include __DIR__ . '/includes/class-wc-ecomprocessing-checkout.php';
			include __DIR__ . '/includes/class-wc-ecomprocessing-direct.php';
			include __DIR__ . '/classes/class-wc-ecomprocessing-constants.php';

			include __DIR__ . '/classes/adapters/order/interface-wc-ecomprocessing-order-adapter-interface.php';
			include __DIR__ . '/classes/adapters/order/class-wc-ecomprocessing-posts-adapter.php';
			include __DIR__ . '/classes/adapters/order/class-wc-ecomprocessing-legacy-order-adapter.php';
			include __DIR__ . '/classes/adapters/order/class-wc-ecomprocessing-hpos-order-adapter.php';
			include __DIR__ . '/classes/adapters/order/class-wc-ecomprocessing-order-factory.php';
			include __DIR__ . '/classes/adapters/class-wc-ecomprocessing-order-proxy.php';

			/**
			 * Add the ecomprocessing Gateway to WooCommerce's
			 * list of installed gateways
			 *
			 * @param $methods Array of existing Payment Gateways
			 *
			 * @return array $methods Appended Payment Gateway
			 */
			if ( ! function_exists( 'woocommerce_add_ecomprocessing_gateway' ) ) {
				/**
				 * Add E-Comprocessing Payment Gateways
				 *
				 * @param array $methods An existing Payment Gateways.
				 *
				 * @return array
				 */
				function woocommerce_add_ecomprocessing_gateway( $methods ) {
					$methods[] = 'WC_Ecomprocessing_Checkout';
					$methods[] = 'WC_Ecomprocessing_Direct';

					return $methods;
				}
			}

			add_filter( 'woocommerce_payment_gateways', 'woocommerce_add_ecomprocessing_gateway' );
		}
	}

	/**
	 * Injects direct method browser parameters form helper and styles into the checkout page
	 *
	 * @SuppressWarnings(PHPMD.ShortVariable)
	 * @return void
	 */
	function ecp_add_css_and_js_to_checkout() {
		global $wp;

		$options                    = get_option( 'woocommerce_' . WC_Ecomprocessing_Checkout::get_method_code() . '_settings' );
		$checkout_iframe_processing = WC_Ecomprocessing_Helper::get_array_items_by_key(
			$options,
			WC_Ecomprocessing_Method_Base::SETTING_KEY_IFRAME_PROCESSING,
			false
		);

		$options_direct           = get_option( 'woocommerce_' . WC_Ecomprocessing_Direct::get_method_code() . '_settings' );
		$direct_iframe_processing = WC_Ecomprocessing_Helper::get_array_items_by_key(
			$options_direct,
			WC_Ecomprocessing_Method_Base::SETTING_KEY_IFRAME_PROCESSING,
			true
		);
		// TODO This line is result of refactoring, The original line is in code bellow.
		$version = WC_Ecomprocessing_Helper::get_plugin_version();

		if ( is_checkout() && empty( $wp->query_vars['order-pay'] ) && ! isset( $wp->query_vars['order-received'] ) ) {

			wp_enqueue_script(
				'ecp-direct-method-browser-params-helper',
				plugins_url( '/assets/javascript/direct-method-browser-params-helper.js', __FILE__ ),
				array(),
				$version,
				true
			);

			if ( WC_Ecomprocessing_Method_Base::SETTING_VALUE_YES === $direct_iframe_processing ) {
				wp_enqueue_script(
					'ecp-direct-method-form-helper',
					plugins_url( '/assets/javascript/direct-method-form-helper.js', __FILE__ ),
					array(),
					$version,
					true
				);
			}

			if ( WC_Ecomprocessing_Method_Base::SETTING_VALUE_YES === $checkout_iframe_processing ) {
				wp_enqueue_script(
					'ecp-checkout-method-form-helper',
					plugins_url( '/assets/javascript/checkout-method-form-helper.js', __FILE__ ),
					array(),
					$version,
					true
				);
			}
			wp_enqueue_style(
				'ecp-iframe-checkout',
				plugins_url( '/assets/css/iframe-checkout.css', __FILE__ ),
				array(),
				$version
			);
		}

		wp_enqueue_style(
			'ecp-threeds',
			plugins_url( '/assets/css/threeds.css', __FILE__ ),
			array(),
			$version
		);
	}

	/**
	 * Add hidden inputs to the Credit Card form
	 *
	 * @param array $fields Hidden fields to checkout.
	 *
	 * @return array
	 */
	function ecp_add_hidden_fields_to_checkout( $fields ) {
		$field_names = WC_Ecomprocessing_Direct::THREEDS_V2_BROWSER;

		array_walk(
			$field_names,
			function ( $field_name ) use ( &$fields ) {
				$fields['order'][ WC_Ecomprocessing_Direct::get_method_code() . '_' . $field_name ] = array(
					'type'    => 'hidden',
					'default' => null,
				);
			}
		);

		return $fields;
	}

	/**
	 * Add hidden iframe to the checkout page
	 *
	 * @return void
	 */
	function ecp_direct_threeds_iframe() {
		echo '<div class="ecp-threeds-modal"><iframe class="ecp-threeds-iframe" frameBorder="0" style="border: none;"></iframe></div>';
	}
	add_action( 'woocommerce_after_checkout_form', 'ecp_direct_threeds_iframe' );

	add_action(
		'before_woocommerce_init',
		function () {
			if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
				\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
			}
		}
	);

	add_action( 'plugins_loaded', 'woocommerce_ecomprocessing_init', 0 );
	add_action( 'wp_enqueue_scripts', 'ecp_add_css_and_js_to_checkout' );
	add_filter( 'woocommerce_checkout_fields', 'ecp_add_hidden_fields_to_checkout' );

	include __DIR__ . '/classes/class-wc-ecomprocessing-threeds-form-helper.php';
	include __DIR__ . '/classes/class-wc-ecomprocessing-threeds-backend-helper.php';
	include __DIR__ . '/classes/class-wc-ecomprocessing-frame-handler.php';

	$threeds_form_helper_class = strtolower( WC_Ecomprocessing_Threeds_Form_Helper::class );
	add_action( 'woocommerce_api_' . $threeds_form_helper_class, array( new WC_Ecomprocessing_Threeds_Form_Helper(), 'display_form_and_iframe' ) );

	$threeds_backend_helper_class = strtolower( WC_Ecomprocessing_Threeds_Backend_Helper::class );
	add_action( 'woocommerce_api_' . $threeds_backend_helper_class . '-method_continue_handler', array( new WC_Ecomprocessing_Threeds_Backend_Helper(), 'method_continue_handler' ) );
	add_action( 'woocommerce_api_' . $threeds_backend_helper_class . '-callback_handler', array( new WC_Ecomprocessing_Threeds_Backend_Helper(), 'callback_handler' ) );
	add_action( 'woocommerce_api_' . $threeds_backend_helper_class . '-status_checker', array( new WC_Ecomprocessing_Threeds_Backend_Helper(), 'status_checker' ) );
	add_action( 'woocommerce_api_' . strtolower( WC_Ecomprocessing_Frame_Handler::class ), array( new WC_Ecomprocessing_Frame_Handler(), 'frame_handler' ) );


	/**
	 * Add credit card input styles to the blocks checkout page
	 *
	 * @return void
	 */
	function ecp_add_credit_card_input_styles() {
		$block_name = 'genesisgateway/ecomprocessing_direct';
		$args       = array(
			'handle' => 'credit-card-input-styles',
			'src'    => plugins_url( '/assets/css/blocks/credit-card-inputs.css', __FILE__ ),
			'path'   => plugins_url( '/assets/css/blocks/credit-card-inputs.css', __FILE__ ),
			'ver'    => WC_Ecomprocessing_Helper::get_plugin_version(),
		);

		wp_enqueue_block_style( $block_name, $args );
	}
	add_action( 'after_setup_theme', 'ecp_add_credit_card_input_styles' );

	/**
	 * Registers WooCommerce Blocks integration
	 *
	 * @SuppressWarnings(PHPMD.MissingImport)
	 */
	function ecomprocessing_blocks_support() {
		if ( class_exists( 'Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType' ) ) {
			require_once 'includes/blocks/class-wc-ecomprocessing-blocks-base.php';
			require_once 'includes/blocks/class-wc-ecomprocessing-blocks-checkout.php';
			require_once 'includes/blocks/class-wc-ecomprocessing-blocks-direct.php';

			add_action(
				'woocommerce_blocks_payment_method_type_registration',
				function ( Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry $payment_method_registry ) {
					$payment_method_registry->register( new WC_Ecomprocessing_Blocks_Checkout() );
					$payment_method_registry->register( new WC_Ecomprocessing_Blocks_Direct() );
				}
			);
		}
	}

	/**
	 * Registers WooCommerce Blocks integration
	 */
	add_action( 'woocommerce_blocks_loaded', 'ecomprocessing_blocks_support' );

	if ( ! function_exists( 'wc_ecomprocessing_post_adapter' ) ) {
		/**
		 * @return WC_Ecomprocessing_Posts_Adapter|null
		 */
		function wc_ecomprocessing_post_adapter() {
			return WC_Ecomprocessing_Posts_Adapter::get_instance();
		}
	}

	if ( ! function_exists( 'wc_ecomprocessing_order_proxy' ) ) {
		/**
		 * @return WC_Ecomprocessing_Order_Proxy
		 */
		function wc_ecomprocessing_order_proxy() {
			return WC_Ecomprocessing_Order_Proxy::get_instance();
		}
	}
}
