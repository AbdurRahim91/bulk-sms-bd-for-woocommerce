<?php
class WC_SMS_Notification {
    private static $instance = null;

    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        // Load other classes
        require_once WCSMS_PATH . 'includes/class-wc-sms-logger.php';
        require_once WCSMS_PATH . 'includes/class-wc-sms-sender.php';
        require_once WCSMS_PATH . 'includes/class-wc-sms-settings.php';

        register_activation_hook(__FILE__, ['WC_SMS_Logger', 'create_table']);
        add_action('admin_menu', ['WC_SMS_Settings', 'register_menus']);
        add_action('admin_enqueue_scripts', [$this, 'load_assets']);

        add_action('woocommerce_new_order', [$this, 'on_new_order']);
        add_action('woocommerce_order_status_changed', [$this, 'on_order_status_change'], 10, 3);
    }

    public function load_assets($hook) {
        if (strpos($hook, 'wc-sms') !== false) {
            $version = '1.0.0';

            wp_enqueue_script(
                'wc-sms-datatables',
                plugins_url('assets/js/datatables.min.js', dirname(__FILE__)),
                ['jquery'],
                $version,
                true
            );

            wp_enqueue_style(
                'wc-sms-datatables-css',
                plugins_url('assets/css/datatables.min.css', dirname(__FILE__)),
                [],
                $version
            );

            wp_add_inline_script(
                'wc-sms-datatables',
                "jQuery(function($){ if ($('#smsLogTable').length) { $('#smsLogTable').DataTable(); } });"
            );
        }
    }

    public function on_new_order($order_id) {
        $order = wc_get_order($order_id);
        if (!$order) {
            return;
        }

        $message = "Dear Customer, your order #$order_id has been received.";
        WC_SMS_Sender::send_sms($order, $message);
    }

    public function on_order_status_change($order_id, $old_status, $new_status) {
        $order = wc_get_order($order_id);
        if (!$order) {
            return;
        }

        $message = "Dear Customer, your order #$order_id status has changed to $new_status.";
        WC_SMS_Sender::send_sms($order, $message);
    }
}
