<?php
class WC_SMS_Settings {

    public static function register_menus() {
        add_menu_page('Bulk SMS BD Settings', 'Bulk SMS BD Settings', 'manage_options', 'wc-sms-settings', [self::class, 'settings_page']);
        add_submenu_page('wc-sms-settings', 'SMS Logs', 'SMS Logs', 'manage_options', 'wc-sms-logs', [self::class, 'logs_page']);
		
		add_action('admin_enqueue_scripts', [self::class, 'enqueue_styles']);
    }

    public static function settings_page() {
        if (isset($_POST['wc_sms_save'])) {
    
            // 1. Nonce verification
            if (
                ! isset($_POST['_wpnonce']) ||
                ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_wpnonce'])), 'wc_sms_settings_save')
            ) {
                echo '<div class="notice notice-error"><p>' . esc_html__('Security check failed.', 'bulk-sms-bd-for-woocommerce') . '</p></div>';
                return;
            }
    
            // 2. Validate and sanitize fields
            if (isset($_POST['api_key'])) {
                $api_key = sanitize_text_field(wp_unslash($_POST['api_key']));
                update_option('wc_sms_api_key', $api_key);
            }
    
            if (isset($_POST['sender_id'])) {
                $sender_id = sanitize_text_field(wp_unslash($_POST['sender_id']));
                update_option('wc_sms_sender_id', $sender_id);
            }
    
            echo '<div class="notice notice-success is-dismissible"><p><strong>' . esc_html__('Settings saved!', 'bulk-sms-bd-for-woocommerce') . '</strong></p></div>';
        }
    
        $api_key = get_option('wc_sms_api_key', '');
        $sender_id = get_option('wc_sms_sender_id', '');
        $balance = WC_SMS_Sender::get_balance($api_key);
    
        echo '<div class="wrap">
        <h1><span class="dashicons dashicons-email-alt"></span> ' . esc_html__('BulkSMSBD Settings', 'bulk-sms-bd-for-woocommerce') . '</h1>
        <div class="wc-sms-card">
            <div class="wc-sms-balance">
                <strong>' . esc_html__('Current Balance:', 'bulk-sms-bd-for-woocommerce') . '</strong> <span>' . esc_html($balance) . '</span>
            </div>
            <div class="wc-sms-sample">
                <strong>' . esc_html__('Sample SMS:', 'bulk-sms-bd-for-woocommerce') . '</strong> <span>' . esc_html('Dear Customer, your order #1011 has been received.') . '</span>
            </div>
            <form method="post">';
    
            // Output nonce properly.
            wp_nonce_field('wc_sms_settings_save', '_wpnonce', true, true);
    
    echo '      <table class="form-table">
                    <tr>
                        <th><label for="api_key">' . esc_html__('API Key', 'bulk-sms-bd-for-woocommerce') . '</label></th>
                        <td><input type="text" id="api_key" name="api_key" class="regular-text" value="' . esc_attr($api_key) . '"></td>
                    </tr>
                    <tr>
                        <th><label for="sender_id">' . esc_html__('Sender ID', 'bulk-sms-bd-for-woocommerce') . '</label></th>
                        <td><input type="text" id="sender_id" name="sender_id" class="regular-text" value="' . esc_attr($sender_id) . '"></td>
                    </tr>
                </table>
                <p><input type="submit" name="wc_sms_save" class="button button-primary button-hero" value="' . esc_attr__('Save Settings', 'bulk-sms-bd-for-woocommerce') . '"></p>
            </form>
        </div>
    </div>';
    
    }
    
public static function enqueue_styles() {
    wp_add_inline_style('wp-admin', '
        .wc-sms-card {
            background: #fff;
            border-left: 5px solid #2271b1;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            max-width: 700px;
        }
        .wc-sms-balance {
            font-size: 16px;
            margin-bottom: 20px;
            color: #2271b1;
        }
        .form-table th {
            width: 150px;
        }
        .form-table input[type="text"] {
            width: 100%;
            max-width: 400px;
        }
    ');
}


    public static function logs_page() {
        WC_SMS_Logger::render_logs();
    }
}