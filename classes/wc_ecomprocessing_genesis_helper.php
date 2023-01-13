<?php
/*
 * Copyright (C) 2018 E-Comprocessing Ltd.
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
 * @copyright   2018 E-Comprocessing Ltd.
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU General Public License, version 2 (GPL-2.0)
 */

use Genesis\API\Constants\Transaction\States;
use Genesis\API\Constants\Transaction\Types;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * Class wc_ecomprocessing_genesis_helper
 */
class WC_ecomprocessing_Genesis_Helper {

	/**
	 * Builds full Request Class Name by Transaction Type
	 *
	 * @param string $transaction_type
	 * @return string
	 */
	public static function get_transaction_type_request_class_name( $transaction_type ) {
		return Types::getFinancialRequestClassForTrxType( $transaction_type );
	}

	/**
	 * Constructs a Gateway Request Instance depending on the selected Txn Type
	 *
	 * @param string $transactionType
	 * @return \Genesis\Genesis
	 * @throws \Genesis\Exceptions\InvalidMethod
	 */
	public static function getGatewayRequestByTxnType( $transactionType ) {
		$apiRequestClassName = static::get_transaction_type_request_class_name(	$transactionType );

		return new \Genesis\Genesis( $apiRequestClassName );
	}

	/**
	 * @param \stdClass $reconcile
	 * @return \stdClass
	 */
	public static function getReconcilePaymentTransaction( $reconcile ) {
		return isset( $reconcile->payment_transaction )
				? $reconcile->payment_transaction
				: $reconcile;
	}

	/**
	 * @param \stdClass $response
	 * @return States
	 */
	public static function getGatewayStatusInstance( $response ) {
		return new States( $response->status );
	}

	/**
	 * @param bool $isRecurring
	 * @return string
	 */
	public static function getPaymentTransactionUsage( $isRecurring ) {
		return sprintf(
			$isRecurring ? '%s Recurring Transaction' : '%s Payment Transaction',
			get_bloginfo( 'name' )
		);
	}

	/**
	 * Makes a check if all the requirements of Genesis Lib are verified
	 *
	 * @return true|WP_Error (True -> verified; WP_Error -> Exception Message)
	 */
	public static function checkGenesisRequirementsVerified() {
		try {
			\Genesis\Utils\Requirements::verify();

			return true;
		} catch ( \Exception $exception ) {
			return WC_ecomprocessing_Helper::getWPError( $exception );
		}
	}

	/**
	 * Retrieves the consumer's user id
	 *
	 * @return int
	 */
	public static function getCurrentUserId() {
		return get_current_user_id();
	}

	/**
	 * @param int $length
	 * @return string
	 */
	public static function getCurrentUserIdHash( $length = 20 ) {
		$userId = self::getCurrentUserId();

		$userHash = $userId > 0 ? sha1( $userId ) : WC_ecomprocessing_Method::generateTransactionId();

		return substr( $userHash, 0, $length );
	}

	/**
	 * Get the total Refunded sum from the Genesis WPF Reconcile Response object
	 *
	 * @param $gateway_response
	 *
	 * @return float
	 */
	public static function get_total_refund_from_wpf_reconcile( $gateway_response ) {
		$sum                  = 0.0;
		$payment_transactions = self::getReconcilePaymentTransaction( $gateway_response );

		foreach ( $payment_transactions as $payment_transaction ) {
			if ( States::APPROVED === $payment_transaction->status &&
			     Types::isRefund( $payment_transaction->transaction_type )
			) {
				$sum += $payment_transaction->amount;
			}
		}

		return $sum;
	}

	/**
	 * @param stdClass $reconcile
	 *
	 * @return bool
	 */
	public static function has_payment( $reconcile ) {
		return isset( $reconcile->payment_transaction );
	}
}
