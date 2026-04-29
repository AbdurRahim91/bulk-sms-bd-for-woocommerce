=== Bulk SMS BD for WooCommerce ===1.2
Contributors: rahim71
Donate link: https://rahimbd.com
Tags: woocommerce, sms notification, order notification, bulk sms bd
Requires at least: 5.0
Tested up to: 6.8
Requires PHP: 7.2
Stable tag: 1.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Send BulkSMSBD order notifications to WooCommerce customers and keep an audit log inside wp-admin.

== Description ==

Bulk SMS BD for WooCommerce connects your store to the BulkSMSBD gateway so customers receive timely SMS alerts when orders are created or their statuses change. The plugin keeps configuration simple while still providing balance insights and an auditable log of every message that leaves your site.

Key features include:

* Automatic SMS after checkout and on every order status transition.
* Settings screen for storing the BulkSMSBD API key and sender ID.
* Balance checker sourced from the BulkSMSBD API.
* SMS log viewer with sortable/searchable DataTables UI.
* Secure option handling with WordPress nonces, sanitization, and optional caching.

== External services ==

This plugin integrates with BulkSMSBD (https://bulksmsbd.net) to send SMS notifications and to retrieve the account balance configured in the settings screen.

* **What is sent:** When an SMS is triggered we send the customer name, phone number, message body, and your BulkSMSBD credentials to https://bulksmsbd.net/api/smsapi. When viewing the settings page we call https://bulksmsbd.net/api/getBalanceApi with only your API key to retrieve the remaining balance.
* **When it happens:** SMS requests run automatically after you configure the API key and sender ID, whenever a new order is created or an order status changes. Balance lookups run when the settings page is loaded.
* **Service policies:** Terms of Service https://bulksmsbd.net/terms-of-service, Privacy Policy https://bulksmsbd.net/privacy-policy.

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/`, or install the ZIP through the WordPress plugin installer.
2. Activate the plugin through the **Plugins** screen.
3. Navigate to **Bulk SMS BD Settings** under the admin menu, add your API key and sender ID, and save.
4. Place a test order to confirm that the SMS reaches the configured phone number.

== Frequently Asked Questions ==

= Do I need a BulkSMSBD account? =  
Yes. You must have an active BulkSMSBD account with available credits plus an approved sender ID.

= Can I disable SMS for certain statuses? =  
Not yet. The current version sends messages on creation and on any status change. You can extend the code using the provided hooks if you need a custom workflow.

= Does this plugin store SMS content? =  
Yes. Every SMS is stored in the custom `wc_sms_logs` database table so you have an audit trail inside the admin area.

= Will it work on multisite? =  
The plugin stores settings per-site, so network admins should configure each site individually.

== Screenshots ==

1. Settings panel with balance information and credential fields.
2. SMS logs table powered by DataTables in wp-admin.

== Changelog ==

= 1.2 =
* Align readme metadata with current release and expand feature documentation.
* Improved admin scripts to follow WordPress enqueue standards.

= 1.1 =
* Added explicit disclosure of BulkSMSBD external API usage.
* Switched DataTables initialization to WordPress script enqueues.

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 1.2 =
Metadata and compliance improvements. Update before resubmitting to WordPress.org.

= 1.1 =
Compliance improvements for the WordPress.org review.

= 1.0 =
First stable version.
