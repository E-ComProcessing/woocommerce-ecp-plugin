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
 * @copyright   2018-2022 E-Comprocessing Ltd.
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2 (GPL-2.0)
 * @package     classes\class-wc-ecomprocessing-threeds-base
 */

use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Utils\Currency;
use Genesis\Utils\Threeds\V2 as ThreedsV2Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * Ecomprocessing 3DS v2 Base Class
 *
 * @class WC_Ecomprocessing_Threeds_Base
 */
class WC_Ecomprocessing_Threeds_Base {
	/**
	 * Get $order_id from url params and check if order with that number exists.
	 *
	 * @suppressWarnings(PHPMD.Superglobals)
	 * @return string|null
	 */
	public function load_order() {
		// TODO: Fix Nonce verification.
		// TODO: Fix superglobals
		// phpcs:ignore WordPress.Security.NonceVerification
		$order_id = sanitize_text_field( wp_unslash( $_GET['order_id'] ?? null ) );
		if ( ! $order_id ) {
			return null;
		}

		$order = wc_ecomprocessing_order_proxy()->get_order_by_id( $order_id );
		if ( ! WC_Ecomprocessing_Order_Helper::is_valid_order( $order ) ) {
			return null;
		}

		return $order_id;
	}

	/**
	 * Create valid signature
	 *
	 * @param object $response_obj Response object.
	 * @param string $unique_id Unique ID.
	 *
	 * @return string
	 */
	public function create_signature( $response_obj, $unique_id ) {
		$options      = get_option( 'woocommerce_' . WC_Ecomprocessing_Direct::get_method_code() . '_settings' );
		$customer_pwd = trim( $options[ WC_Ecomprocessing_Method_Base::SETTING_KEY_PASSWORD ] );
		$date_add     = $response_obj->date_add;
		$timestamp    = date_create_from_format( 'U', $date_add );

		return ThreedsV2Utils::generateSignature(
			$unique_id,
			Currency::amountToExponent( $response_obj->amount, $response_obj->currency ),
			$timestamp->format( DateTimeFormat::YYYY_MM_DD_H_I_S_ZULU ),
			$customer_pwd
		);
	}

	/**
	 * Create method_continue handler url
	 *
	 * @param string $url_params http request variables.
	 *
	 * @return string
	 */
	public function build_continue_url( $url_params ) {
		return $this->build_url( '-method_continue_handler', $url_params );
	}

	/**
	 * Create url to the status checker method
	 *
	 * @param string $url_params http request variables.
	 *
	 * @return string
	 */
	public function build_callback_checker_url( $url_params ) {
		return $this->build_url( '-status_checker', $url_params );
	}

	/**
	 * Sanitize GET/POST variables and add common variables
	 *
	 * @SuppressWarnings(PHPMD.MissingImport)
	 * @suppressWarnings(PHPMD.Superglobals)
	 * @return array|null
	 */
	protected function get_data_from_url() {
		// TODO: Fix Nonce verification.
		// TODO: Fix super globals
		// phpcs:ignore WordPress.Security.NonceVerification
		$unique_id_hash = sanitize_text_field( wp_unslash( $_GET['checksum'] ?? null ) );

		$threeds_base = new WC_Ecomprocessing_Threeds_Base();
		$order_id     = $threeds_base->load_order();
		$response_arr = get_post_meta( $order_id, WC_Ecomprocessing_Transactions_Tree::META_DATA_KEY_LIST, true );

		if ( ! $response_arr ) {
			return null;
		}

		$response_obj = reset( $response_arr );
		$unique_id    = $response_obj->unique_id;
		$signature    = $threeds_base->create_signature( $response_obj, $unique_id );

		if ( hash( 'sha256', $unique_id ) !== $unique_id_hash ) {
			return null;
		}

		$url_params              = http_build_query(
			array(
				'order_id' => $order_id,
				'checksum' => $unique_id_hash,
			)
		);
		$method_continue_handler = $threeds_base->build_continue_url( $url_params );
		$threeds_method_url      = ( property_exists( $response_obj, 'threeds_method_url' ) ) ? $response_obj->threeds_method_url : null;
		$status_checker_url      = $threeds_base->build_callback_checker_url( $url_params );

		return array(
			'method_continue_handler' => $method_continue_handler,
			'order_id'                => $order_id,
			'response_obj'            => $response_obj,
			'signature'               => $signature,
			'status_checker_url'      => $status_checker_url,
			'threeds_method_url'      => $threeds_method_url,
			'unique_id'               => $unique_id,
			'unique_id_hash'          => $unique_id_hash,
		);
	}

	/**
	 * Create API Request url and append specific request variables
	 *
	 * @param string $suffix Suffix.
	 * @param string $url_params http request variables.
	 *
	 * @return string
	 */
	private function build_url( $suffix, $url_params ) {
		return WC()->api_request_url( WC_Ecomprocessing_Threeds_Backend_Helper::class . $suffix ) . "?{$url_params}";
	}
}
