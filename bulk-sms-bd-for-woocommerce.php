<?php
/**
 * Plugin Name: Bulk SMS BD for WooCommerce
 * Description: Send SMS notifications on WooCommerce orders using BulkSMSBD API. Includes settings, logs, and balance check.
 * Version: 1.2
 * Author: Abdur Rahim
 * Author URI:  https://rahimbd.com
 * License:     GPL2
 * Text Domain: bulk-sms-bd-for-woocommerce
 */

if (!defined('ABSPATH')) exit;

define('WCSMS_PATH', plugin_dir_path(__FILE__));
define('WCSMS_URL', plugin_dir_url(__FILE__));

require_once WCSMS_PATH . 'includes/class-wc-sms-notification.php';

WC_SMS_Notification::get_instance();
