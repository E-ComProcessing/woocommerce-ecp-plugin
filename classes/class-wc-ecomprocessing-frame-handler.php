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
 * @package     classes\class-wc-ecomprocessing-frame-handler
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Ecomprocessing 3DS v2 Return url via iframe handler
 *
 * @class WC_Ecomprocessing_Frame_Handler
 */
class WC_Ecomprocessing_Frame_Handler {
	/**
	 * Parse QUERY_STRING and load it into the parent window
	 *
	 * @SuppressWarnings(PHPMD.Superglobals)
	 * @suppressWarnings(PHPMD.ExitExpression)
	 * @return void
	 */
	public static function frame_handler() {
		// TODO: Fix Superglobals
		// TODO: Fix exit expression
		if ( ! empty( $_SERVER['QUERY_STRING'] ) ) {
			$sanitized_url = self::sanitize_url( wp_unslash( $_SERVER['QUERY_STRING'] ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

			echo "<script>parent.location.href = '" . esc_url_raw( $sanitized_url ) . "';</script>";

			exit;
		}

		wp_die( 'Missing data!' );
	}

	/**
	 * Check if the domain of the redirected url points shop's domain url
	 *
	 * @param string $redirect_url Redirect Url.
	 *
	 * @return string
	 */
	private static function sanitize_url( $redirect_url ) {
		$shop_url             = wc_get_page_permalink( 'shop' );
		$decoded_redirect_url = urldecode( $redirect_url );
		$redirect_domain      = wp_parse_url( $decoded_redirect_url, PHP_URL_HOST );
		$shop_domain          = wp_parse_url( $shop_url, PHP_URL_HOST );

		return ( $redirect_domain === $shop_domain ) ? $decoded_redirect_url : $shop_url;
	}
}
