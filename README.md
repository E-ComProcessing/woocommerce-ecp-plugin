E-ComProcessing Gateway Module for WooCommerce
===========================================

This is a Payment Module for WooCommerce that gives you the ability to process payments through E-ComProcessing's Payment Gateway - Genesis.

Requirements
------------

* WordPress 4.x (Tested up to 4.9.7)
* WooCommerce 2.x or 3.x (Tested up to 3.4.3)
* [GenesisPHP v1.10.1](https://github.com/GenesisGateway/genesis_php/releases/tag/1.10.1) - (Integrated in Module)
* PCI-certified server in order to use ```E-ComProcessing Direct```
* [WooCommerce Subscription Extension](https://woocommerce.com/products/woocommerce-subscriptions/) 2.x (Tested up to 2.2.13) in order to use **Subscriptions**

GenesisPHP Requirements
------------

* PHP version 5.5.9 or newer
* PHP Extensions:
    * [BCMath](https://php.net/bcmath)
    * [CURL](https://php.net/curl) (required, only if you use the curl network interface)
    * [Filter](https://php.net/filter)
    * [Hash](https://php.net/hash)
    * [XMLReader](https://php.net/xmlreader)
    * [XMLWriter](https://php.net/xmlwriter)

Installation
------------

* Login into your Wordpress Admin Panel with Administrator privileges
* Navigate to ```Plugins -> Add New```
* Install through the Marketplace/ Select the downloaded ```.zip``` File
* Activate the newly installed ```WooCommerce E-ComProcessing Payment Gateway Client``` plugin
* Navigate to ```WooCommerce -> Settings -> Checkout``` 
* Select your preferred payment method ```E-ComProcessing Checkout``` or ```E-ComProcessing Direct```
* Check ```Enable```, set the correct credentials and click "Save changes"

Enable WooCommerce Secure Checkout
------------
This steps should be followed if you wish to use the ```E-ComProcessing Direct``` Method
* Ensure you have installed and configured a SSL Certificate on your PCI-DSS Certified Server
* Login into your WordPress Admin Panel with Administrator privileges
* Navigate to ```WooCommerce``` - > ```Settings``` -> ```Checkout```
* In Section ```Checkout Process``` check ```Force secure checkout```

Subscriptions
------------
In order to process **Subscriptions** the [WooCommerce Subscription Extension](https://woocommerce.com/products/woocommerce-subscriptions/)
needs to be installed, which will add **Subscription Support** to the **WooCommerce Plugin**.

**Add Subscription Product**

* Login to the WordPress Admin Panel
* Go to ```Products``` -> ```Products```
* Click ```Add Product``` or choose a product to edit
* Choose ```Simple subscription``` from the **Product Data** dropdown menu
* Check ```Virtual``` or ```Downloadable``` if needed
* In tab ```General``` you can define your subscription details
    * **Subscription price** - will be used for the **Recurring Sale** Transactions
    * **Subscription length**
    * **Sign-up fee** - will be used once for the **InitRecurring** Transaction
    * **Free trial** - define the period, which the consumer will not pay the subscription price in.
* In tab ```Inventory``` check ```Sold individually``` if you don't want the subscription's quantity to be increased in the shopping cart.

**Manage Subscriptions:**
* Navigate to ```WooCommerce``` -> ```Subscriptions``` and choose your **Subscription**
* You can ```Suspend``` or ```Cancel``` a **Subscription** by using the links next to the Subscription's status label or change manually the Status
* When you enter into a **Subscription**, you can preview also the **Related Orders** and modify the **Billing Schedule**
* If you wish to perform a manual re-billing, choose ```Process renewal``` from the ```Subscriptions Actions``` dropdown list on the Right and click the button next to the dropdown.

**Refund a Subscription:**

You are only allowed to refund the `Sign-Up Fee` for a Subscription

* Navigate to ```WooCommerce``` -> ```Subscriptions``` and choose your Subscription
* Scroll down to the ```Related Orders``` and click on the ```Parent Order```
* Scroll down to the Order Items and click the **Refund** button.
* Define your amount for refund. Have in mind that the refundable amount may be lower than the total order amount, because the **Parent Order** might be related to **Init Recurring** & **Recurring Sale** Transactions.
  You are only allowed to **refund** the amount of the **Init Recurring** Transaction.

After a **Refund** is processed, the related **Subscription** should be marked as ```Canceled``` and a **Note** should be added to the **Subscription**

**Processing Recurring Transactions**

* Recurring payments are scheduled and executed by the **WooCommerce Subscription Plugin** and information email should be sent.

**Configuring WordPress Cron**

* If your **WordPress Site** is on a **Hosting**, login to your **C-Panel** and add a **Cron Job** for executing the WP Cron
```bash
cd /path/to/wordpress/root; php -q wp-cron.php
```

* If your Site is hosted at your **Server**, connect to the machine using **SSH** and type the following command in the **terminal** to edit your **Cron Jobs**
  Do not forget to replace `www-data` with your **WebServer User**
```bash
sudo crontab -u www-data -e
```

and add the following line to execute the **WordPress Cron** once per 10 Minutes

```sh
*/10 * * * * cd /path/to/wordpress/root && php -q wp-cron.php
```

Supported Transactions
------------
* ```E-ComProcessing Direct``` Payment Method
	* __Authorize__
	* __Authorize (3D-Secure)__
	* __InitRecurringSale__
	* __InitRecurringSale (3D-Secure)__
	* __RecurringSale__
	* __Sale__
	* __Sale (3D-Secure)__

* ```E-ComProcessing Checkout``` Payment Method
    * __Alipay__
    * __Authorize__
    * __Authorize (3D-Secure)__
    * __CashU__
    * __Citadel__
    * __eZeeWallet__
    * __Fashioncheque__
    * __iDebit__
    * __InstaDebit__
    * __InitRecurringSale__
    * __InitRecurringSale (3D-Secure)__
    * __Intersolve__
    * __Klarna__
    * __Neteller__
    * __P24__
    * __PayByVoucher (Sale)__
    * __PayByVoucher (oBeP)__
    * __PayPal Express__
    * __PaySafeCard__
    * __PaySec__
    * __POLi__
    * __PPRO__
    	* __eps__
    	* __GiroPay__
    	* __Qiwi__
    	* __Przelewy24__
    	* __SafetyPay__
    	* __TrustPay__
    	* __Mr.Cash__
    	* __MyBank__
    * __RecurringSale__
    * __Sale__
    * __Sale (3D-Secure)__
    * __Sepa Direct Debit__
    * __SOFORT__
    * __TCS__
    * __Trustly__
    * __WebMoney__
    * __WeChat__
    
_Note_: If you have trouble with your credentials or terminal configuration, get in touch with our [support] team

You're now ready to process payments through our gateway.

[support]: mailto:tech-support@e-comprocessing.com
