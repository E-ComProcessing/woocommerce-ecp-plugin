<?php
/*
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NON-INFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
namespace Genesis\API\Constants\Transaction;

use Genesis\Utils\Common;

/**
 * Class Types
 *
 * Transaction types of a Genesis Transaction
 *
 * @package Genesis\API\Constants\Transaction
 */
class Types
{
    /**
     * Address Verification
     */
    const AVS = 'avs';

    /**
     * Account Verification
     */
    const ACCOUNT_VERIFICATION = 'account_verification';

    /**
     * A standard Authorization
     */
    const AUTHORIZE = 'authorize';

    /**
     * 3D-Secure Authorization
     */
    const AUTHORIZE_3D = 'authorize3d';

    /**
     * A standard Sale
     */
    const SALE = 'sale';

    /**
     * 3D-Secure Sale
     */
    const SALE_3D = 'sale3d';

    /**
     * Capture settles a transaction which has been authorized before.
     */
    const CAPTURE = 'capture';

    /**
     * Refunds allow to return already billed amounts to customers.
     */
    const REFUND = 'refund';

    /**
     * Void transactions undo previous transactions.
     */
    const VOID = 'void';

    /**
     * Credits (also known as Credit Fund Transfer a.k.a. CFT)
     */
    const CREDIT = 'credit';

    /**
     * Payouts transactions
     */
    const PAYOUT = 'payout';

    /**
     * A standard initial recurring
     */
    const INIT_RECURRING_SALE = 'init_recurring_sale';

    /**
     * 3D-based initial recurring
     */
    const INIT_RECURRING_SALE_3D = 'init_recurring_sale3d';

    /**
     * A RecurringSale transaction is a "repeated" transaction which follows and references an initial transaction
     */
    const RECURRING_SALE = 'recurring_sale';

    /**
     * Bank transfer, popular in Netherlands (via ABN)
     */
    const ABNIDEAL = 'abn_ideal';

    /**
     * Voucher-based payment
     */
    const CASHU = 'cashu';

    /**
     * Wallet-based payment
     */
    const EZEEWALLET = 'ezeewallet';

    /**
     * Neteller
     */
    const NETELLER = 'neteller';

    /**
     * POLi is Australia's most popular online real time debit payment system.
     */
    const POLI = 'poli';

    /**
     * WebMoney is a global settlement system and environment for online business activities.
     */
    const WEBMONEY = 'webmoney';

    /**
     * PayByVouchers via oBeP
     */
    const PAYBYVOUCHER_YEEPAY = 'paybyvoucher_yeepay';

    /**
     * PayByVouchers via Credit/Debit Cards
     */
    const PAYBYVOUCHER_SALE = 'paybyvoucher_sale';

    /**
     * Voucher-based payment
     */
    const PAYSAFECARD = 'paysafecard';

    /**
     * Supports payments via EPS, SafetyPay, TrustPay, ELV, Przelewy24, QIWI, and GiroPay
     */
    const PPRO = 'ppro';

    /**
     * Bank transfer payment, popular in Germany
     */
    const SOFORT = 'sofort';

    /**
     * Global payment system, that makes instant cross-border payments more secure, regulated by Danish and Swiss FSA
     */
    const INPAY = 'inpay';

    /**
     * P24 is an online banking payment, popular in Poland
     */
    const P24 = 'p24';

    /**
     * Trustly is a fast and secure oBeP-style alternative payment method. It is free of charge and
     * allows you to deposit money directly from your online bank account.
     */
    const TRUSTLY_SALE = 'trustly_sale';

    /**
     * Trustly is an oBeP-style alternative payment method that allows you to
     * withdraw money directly from your online bank account using your bank credentials.
     */
    const TRUSTLY_WITHDRAWAL = 'trustly_withdrawal';

    /**
     * PayPal Express Checkout is a fast, easy way for buyers to pay with PayPal.
     * Express Checkout eliminates one of the major causes of checkout abandonment by giving buyers
     * all the transaction details at once, including order details, shipping options, insurance choices, and tax totals
     */
    const PAYPAL_EXPRESS = 'paypal_express';

    /**
     * Sepa Direct Debit Payment, popular in Germany.
     * Single Euro Payments Area (SEPA) allows consumers to make cashless Euro payments to
     * any beneficiary located anywhere in the Euro area using only a single bank account
     */
    const SDD_SALE = 'sdd_sale';

    /**
     * Sepa Direct Debit Payout, popular in Germany.
     * Processed as a SEPA CreditTransfer and can be used for all kind of payout services
     * across the EU with 1 day settlement. Suitable for Gaming, Forex-Binaries, Affiliate Programs or Merchant payouts
     */
    const SCT_PAYOUT = 'sct_payout';

    /**
     * Sepa Direct Debit Refund Transaction.
     * Refunds allow to return already billed amounts to customers.
     */
    const SDD_REFUND = 'sdd_refund';

    /**
     * Sepa Direct Debit initial recurring
     */
    const SDD_INIT_RECURRING_SALE = 'sdd_init_recurring_sale';

    /**
     * Sepa Direct Debit RecurringSale transaction is a "repeated" transaction,
     * which follows and references an SDD initial transaction
     */
    const SDD_RECURRING_SALE = 'sdd_recurring_sale';

    /**
     * iDebit connects consumers to their online banking directly from checkout, enabling secure,
     * real-time payments without a credit card.
     * Using iDebit allows consumers to transfer funds to merchants without
     * revealing their personal banking information.
     * iDebit Payin is only asynchronous and uses eCheck.
     */
    const IDEBIT_PAYIN = 'idebit_payin';

    /**
     * iDebit connects consumers to their online banking directly from checkout, enabling secure,
     * real-time payments without a credit card.
     * Using iDebit allows consumers to transfer funds to merchants without
     * revealing their personal banking information.
     * iDebit Payout is only synchronous and uses eCheck.
     */
    const IDEBIT_PAYOUT = 'idebit_payout';

    /**
     * InstaDebit connects consumers to their online banking directly from checkout, enabling secure,
     * real- time payments without a credit card.
     * Using InstaDebit allows consumers to transfer funds to merchants without
     * revealing their personal banking information.
     * InstaDebit Payin is only asynchronous and uses online bank transfer.
     */
    const INSTA_DEBIT_PAYIN = 'insta_debit_payin';

    /**
     * InstaDebit connects consumers to their online banking directly from checkout, enabling secure,
     * real- time payments without a credit card.
     * Using InstaDebit allows consumers to transfer funds to merchants without
     * revealing their personal banking information.
     * InstaDebit Payout is only synchronous and uses online bank transfer.
     */
    const INSTA_DEBIT_PAYOUT = 'insta_debit_payout';

    /**
     * Citadel is an oBeP-style alternative payment method.
     * It offers merchants the ability to send/receive consumer payments via the use of bank transfer functionality
     * available from the consumer’s online banking website.
     *
     * Payins are only asynchronous. After initiating a transaction the transaction status is set to pending async and
     * the consumer is redirected to Citadel’s Instant Banking website.
     */
    const CITADEL_PAYIN = 'citadel_payin';

    /**
     * Citadel is an oBeP-style alternative payment method.
     * It offers merchants the ability to send/receive consumer payments via the use of bank transfer functionality
     * available from the consumer’s online banking website.
     *
     * The workflow for Payouts is synchronous, there is no redirect to the Citadel’s Instant Banking website.
     * There are different required fields per country, e.g. IBAN and SWIFT Code or Account Number and Branch Code
     */
    const CITADEL_PAYOUT = 'citadel_payout';

    /**
     * Earthport’s service supports payouts from e-commerce companies. The workflow is synchronous, there
     * is no redirect to the Earthport’s website. There are different required fields per country, e.g. IBAN
     * or Account Number.
     */
    const EARTHPORT = 'earthport';

    /**
     * Alipay is an oBeP-style alternative payment method that allows you to pay directly with your ebank account.
     * After initiating a transaction Alipay will redirect you to their page. There you will see a picture of a QR code,
     * which you will have to scan with your Alipay mobile application.
     */
    const ALIPAY = 'alipay';

    /**
     * WeChat Pay solution offers merchants access to the over 300 million WeChat users that have linked payment
     * to their WeChat account. The solution works on desktop and mobile via a QR code generation platform.
     */
    const WECHAT = 'wechat';

    /**
     * PaySec is an oBeP-style alternative payment method that allows you to pay directly with your ebank account.
     * After initiating a transaction PaySec will redirect you to their page. There you will find a list with
     * available banks to finish the payment.
     */
    const PAYSEC_PAYIN = 'paysec';

    /**
     * PaySec Payout is an oBeP-style alternative payment method that allows you to transfer money with your ebank
     * account.
     */
    const PAYSEC_PAYOUT = 'paysec_payout';

    /**
     * TCS Thecontainerstore transactions are made using gift cards provided by TCS The amount from a
     * Container Store Transactions is immediately billed to the customer’s gift card.
     * It can be reversed via a void transaction.
     */
    const TCS = 'container_store';

    /**
     * Fashioncheque transactions are made using gift card provided by Fashioncheque.
     *
     * Using a fashioncheque transaction, the amount is immediately billed to the customer’s gift card.
     * It can be reversed via a void transaction on the same day of the transaction.
     * They can also be refunded.
     */
    const FASHIONCHEQUE = 'fashioncheque';

    /**
     * Intersolve transactions are made using gift card provided by Intersolve
     * Using a intersolve transaction, the amount is immediately billed to the customer’s gift card.
     * It can be reversed via a void transaction.
     */
    const INTERSOLVE = 'intersolve';

    /**
     * With Klarna Authorize transactions, you can confirm that an order is successful.
     * After settling the transaction (e.g. shipping the goods), you should use klarna_capture transaction
     * type to capture the amount.
     * Klarna authorize transaction will automatically be cancelled after a certain time frame, most likely two weeks.
     */
    const KLARNA_AUTHORIZE = 'klarna_authorize';

    /**
     * Klarna capture settles a klarna_authorize transaction.
     * Do this when you are shipping goods, for example. A klarna_capture can only be used after an
     * klarna_authorize on the same transaction.
     * Therefore, the reference id of the klarna authorize transaction is mandatory.
     */
    const KLARNA_CAPTURE = 'klarna_capture';

    /**
     * Klarna Refunds allow to return already billed amounts to customers.
     * The amount can be fully or partially refunded. Klarna refunds can only be done on former klarna_capture(settled)
     * transactions.
     * Therefore, the reference id for the corresponding transaction is mandatory
     */
    const KLARNA_REFUND = 'klarna_refund';

    /**
     * @param $type
     *
     * @return bool|string
     */
    public static function getFinancialRequestClassForTrxType($type)
    {
        $map = [
            self::ABNIDEAL                => 'Alternatives\ABNiDEAL',
            self::CASHU                   => 'Alternatives\CashU',
            self::EARTHPORT               => 'Alternatives\Earthport',
            self::INPAY                   => 'Alternatives\INPay',
            self::P24                     => 'Alternatives\P24',
            self::PAYPAL_EXPRESS          => 'Alternatives\PaypalExpress',
            self::PAYSAFECARD             => 'Alternatives\Paysafecard',
            self::POLI                    => 'Alternatives\POLi',
            self::PPRO                    => 'Alternatives\PPRO',
            self::SOFORT                  => 'Alternatives\Sofort',
            self::TRUSTLY_SALE            => 'Alternatives\Trustly\Sale',
            self::TRUSTLY_WITHDRAWAL      => 'Alternatives\Trustly\Withdrawal',
            self::KLARNA_AUTHORIZE        => 'Alternatives\Klarna\Authorize',
            self::INIT_RECURRING_SALE     => 'Cards\Recurring\InitRecurringSale',
            self::INIT_RECURRING_SALE_3D  => 'Cards\Recurring\InitRecurringSale3D',
            self::RECURRING_SALE          => 'Cards\Recurring\RecurringSale',
            self::AUTHORIZE               => 'Cards\Authorize',
            self::AUTHORIZE_3D            => 'Cards\Authorize3D',
            self::CREDIT                  => 'Cards\Credit',
            self::PAYOUT                  => 'Cards\Payout',
            self::SALE                    => 'Cards\Sale',
            self::SALE_3D                 => 'Cards\Sale3D',
            self::TCS                     => 'GiftCards\Tcs',
            self::FASHIONCHEQUE           => 'GiftCards\Fashioncheque',
            self::INTERSOLVE              => 'GiftCards\Intersolve',
            self::CITADEL_PAYIN           => 'OnlineBankingPayments\Citadel\Payin',
            self::CITADEL_PAYOUT          => 'OnlineBankingPayments\Citadel\Payout',
            self::IDEBIT_PAYIN            => 'OnlineBankingPayments\iDebit\Payin',
            self::IDEBIT_PAYOUT           => 'OnlineBankingPayments\iDebit\Payout',
            self::INSTA_DEBIT_PAYIN       => 'OnlineBankingPayments\InstaDebit\PayIn',
            self::INSTA_DEBIT_PAYOUT      => 'OnlineBankingPayments\InstaDebit\Payout',
            self::PAYSEC_PAYIN            => 'OnlineBankingPayments\PaySec\Payin',
            self::PAYSEC_PAYOUT           => 'OnlineBankingPayments\PaySec\Payout',
            self::ALIPAY                  => 'OnlineBankingPayments\Alipay',
            self::WECHAT                  => 'OnlineBankingPayments\WeChat',
            self::PAYBYVOUCHER_YEEPAY     => 'PayByVouchers\oBeP',
            self::PAYBYVOUCHER_SALE       => 'PayByVouchers\Sale',
            self::SCT_PAYOUT              => 'SCT\Payout',
            self::SDD_SALE                => 'SDD\Sale',
            self::SDD_INIT_RECURRING_SALE => 'SDD\Recurring\InitRecurringSale',
            self::SDD_RECURRING_SALE      => 'SDD\Recurring\RecurringSale',
            self::SDD_REFUND              => 'SDD\Refund',
            self::SDD_SALE                => 'SDD\Sale',
            self::EZEEWALLET              => 'Wallets\eZeeWallet',
            self::NETELLER                => 'Wallets\Neteller',
            self::WEBMONEY                => 'Wallets\WebMoney',
        ];

        return isset($map[$type]) ? 'Financial\\' . $map[$type] : false;
    }

    /**
     * Check whether this is a valid (known) transaction type
     *
     * @param string $type
     *
     * @return bool
     */
    public static function isValidTransactionType($type)
    {
        $transactionTypes = \Genesis\Utils\Common::getClassConstants(__CLASS__);

        return in_array(strtolower($type), $transactionTypes);
    }

    /**
     * Get valid WPF transaction types
     *
     * @return array
     */
    public static function getWPFTransactionTypes()
    {
        return [
            self::AUTHORIZE,
            self::AUTHORIZE_3D,
            self::SALE,
            self::SALE_3D,
            self::INIT_RECURRING_SALE,
            self::INIT_RECURRING_SALE_3D,
            self::CASHU,
            self::PAYSAFECARD,
            self::EZEEWALLET,
            self::PAYBYVOUCHER_YEEPAY,
            self::PPRO,
            self::SOFORT,
            self::NETELLER,
            self::ABNIDEAL,
            self::WEBMONEY,
            self::POLI,
            self::PAYBYVOUCHER_SALE,
            self::INPAY,
            self::SDD_SALE,
            self::SDD_INIT_RECURRING_SALE,
            self::P24,
            self::TRUSTLY_SALE,
            self::TRUSTLY_WITHDRAWAL,
            self::PAYPAL_EXPRESS,
            self::CITADEL_PAYIN,
            self::INSTA_DEBIT_PAYIN,
            self::WECHAT,
            self::ALIPAY,
            self::PAYSEC_PAYIN,
            self::PAYSEC_PAYOUT,
            self::IDEBIT_PAYIN,
            self::TCS,
            self::FASHIONCHEQUE,
            self::INTERSOLVE,
            self::KLARNA_AUTHORIZE
        ];
    }

    /**
     * Check whether this is a valid (known) transaction type
     *
     * @param string $type
     *
     * @return bool
     */
    public static function isValidWPFTransactionType($type)
    {
        return in_array(strtolower($type), self::getWPFTransactionTypes());
    }

    /**
     * Get valid split payment transaction types
     *
     * @return array
     */
    public static function getSplitPaymentsTrxTypes()
    {
        return [
            self::SALE,
            self::SALE_3D,
            self::TCS,
            self::FASHIONCHEQUE,
            self::INTERSOLVE
        ];
    }

    /**
     * Check whether this is a valid (known) split payment transaction type
     *
     * @param string $type
     *
     * @return bool
     */
    public static function isValidSplitPaymentTrxType($type)
    {
        return in_array(strtolower($type), self::getSplitPaymentsTrxTypes());
    }

    /**
     * Check whether this is a valid (known) transaction type
     *
     * @param string $type
     *
     * @return bool
     */
    public static function isPayByVoucher($type)
    {
        $transactionTypesList = [
            self::PAYBYVOUCHER_YEEPAY,
            self::PAYBYVOUCHER_SALE
        ];

        return in_array(strtolower($type), $transactionTypesList);
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public static function canCapture($type)
    {
        $transactionTypesList = [
            self::AUTHORIZE,
            self::AUTHORIZE_3D,
            self::KLARNA_AUTHORIZE
        ];

        return in_array(strtolower($type), $transactionTypesList);
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public static function canRefund($type)
    {
        $transactionTypesList = [
            self::CAPTURE,
            self::CASHU,
            self::INIT_RECURRING_SALE,
            self::INIT_RECURRING_SALE_3D,
            self::INPAY,
            self::P24,
            self::PAYPAL_EXPRESS,
            self::PPRO,
            self::SALE,
            self::SALE_3D,
            self::SOFORT,
            self::TRUSTLY_SALE,
            self::FASHIONCHEQUE,
            self::KLARNA_CAPTURE
        ];

        return in_array(strtolower($type), $transactionTypesList);
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public static function canVoid($type)
    {
        $transactionTypesList = [
            self::AUTHORIZE,
            self::AUTHORIZE_3D,
            self::TRUSTLY_SALE,
            self::TCS,
            self::FASHIONCHEQUE,
            self::INTERSOLVE
        ];

        return in_array(strtolower($type), $transactionTypesList);
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public static function is3D($type)
    {
        return Common::endsWith($type, '3d');
    }

    /**
     * @param $type
     *
     * @return bool
     */
    public static function isAuthorize($type)
    {
        $transactionTypesList = [
            self::AUTHORIZE,
            self::AUTHORIZE_3D,
            self::KLARNA_AUTHORIZE
        ];

        return in_array(strtolower($type), $transactionTypesList);
    }

    /**
     * @param $type
     *
     * @return bool
     */
    public static function isCapture($type)
    {
        $transactionTypesList = [
            self::CAPTURE,
            self::KLARNA_CAPTURE
        ];

        return in_array(strtolower($type), $transactionTypesList);
    }

    /**
     * @param $type
     *
     * @return bool
     */
    public static function isRefund($type)
    {
        $transactionTypesList = [
            self::REFUND,
            self::SDD_REFUND,
            self::KLARNA_REFUND
        ];

        return in_array(strtolower($type), $transactionTypesList);
    }

    /**
     * Get capture transaction class from authorize type
     *
     * @param $authorizeType
     * @return string
     */
    public static function getCaptureTransactionClass($authorizeType)
    {
        switch ($authorizeType) {
            case self::AUTHORIZE:
                return 'Financial\Capture';
            case self::KLARNA_AUTHORIZE:
                return 'Financial\Alternatives\Klarna\Capture';
            break;
        }
    }

    /**
     * Get refund transaction class from authorize type
     *
     * @param $captureType
     * @return string
     */
    public static function getRefundTransactionClass($captureType)
    {
        switch ($captureType) {
            case self::CAPTURE:
                return 'Financial\Refund';
            case self::KLARNA_CAPTURE:
                return 'Financial\Alternatives\Klarna\Refund';
                break;
        }
    }

    /**
     * Get custom required parameters with values per transaction
     * @param string $type
     * @return array|bool
     */
    public static function getCustomRequiredParameters($type)
    {
        switch ($type) {
            case self::PPRO:
                return [
                    'payment_method' => \Genesis\API\Constants\Payment\Methods::getMethods()
                ];
                break;

            case self::PAYBYVOUCHER_SALE:
            case self::PAYBYVOUCHER_YEEPAY:
                $customParameters = [
                    'card_type'   =>
                        \Genesis\API\Constants\Transaction\Parameters\PayByVouchers\CardTypes::getCardTypes(),
                    'redeem_type' =>
                        \Genesis\API\Constants\Transaction\Parameters\PayByVouchers\RedeemTypes::getRedeemTypes()
                ];

                if ($type == self::PAYBYVOUCHER_YEEPAY) {
                    $customParameters = array_merge(
                        $customParameters,
                        [
                            'product_name'     => null,
                            'product_category' => null
                        ]
                    );
                }

                return $customParameters;
                break;

            case self::CITADEL_PAYIN:
                return [
                    'merchant_customer_id' => null
                ];
                break;

            case self::INSTA_DEBIT_PAYIN:
            case self::IDEBIT_PAYIN:
                return [
                    'customer_account_id' => null
                ];
                break;

            default:
                return false;
        }
    }
}
