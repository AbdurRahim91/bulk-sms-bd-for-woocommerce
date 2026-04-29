<?php
class WC_SMS_Logger {
    public static function create_table() {
        global $wpdb;
        $table = $wpdb->prefix . 'wc_sms_logs';
        $charset = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS $table (
            id BIGINT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100),
            email VARCHAR(100),
            phone VARCHAR(30),
            message TEXT,
            status VARCHAR(30),
            sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) $charset;";
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    public static function log($name, $email, $phone, $message, $status) {
        global $wpdb;
        $wpdb->insert($wpdb->prefix . 'wc_sms_logs', compact('name', 'email', 'phone', 'message', 'status'));
    }

    public static function render_logs() {
        global $wpdb;
        $table = esc_sql($wpdb->prefix . 'wc_sms_logs');
        $cache_key = 'wc_sms_logs_all';
        $logs = wp_cache_get($cache_key);

        if ($logs === false) {
            $logs = $wpdb->get_results("SELECT * FROM {$table} ORDER BY sent_at DESC");
            wp_cache_set($cache_key, $logs, '', 300);
        }

        echo '<div class="wrap"><h1>' . esc_html__('SMS Logs', 'bulk-sms-bd-for-woocommerce') . '</h1>';
        echo '<table class="wp-list-table widefat fixed striped" id="smsLogTable">
                <thead>
                    <tr>
                        <th>' . esc_html__('ID', 'bulk-sms-bd-for-woocommerce') . '</th>
                        <th>' . esc_html__('Name', 'bulk-sms-bd-for-woocommerce') . '</th>
                        <th>' . esc_html__('Email', 'bulk-sms-bd-for-woocommerce') . '</th>
                        <th>' . esc_html__('Phone', 'bulk-sms-bd-for-woocommerce') . '</th>
                        <th>' . esc_html__('Message', 'bulk-sms-bd-for-woocommerce') . '</th>
                        <th>' . esc_html__('Status', 'bulk-sms-bd-for-woocommerce') . '</th>
                        <th>' . esc_html__('Sent At', 'bulk-sms-bd-for-woocommerce') . '</th>
                    </tr>
                </thead>
                <tbody>';

        if (!empty($logs)) {
            foreach ($logs as $log) {
                echo '<tr>
                        <td>' . esc_html($log->id) . '</td>
                        <td>' . esc_html($log->name) . '</td>
                        <td>' . esc_html($log->email) . '</td>
                        <td>' . esc_html($log->phone) . '</td>
                        <td>' . esc_html($log->message) . '</td>
                        <td>' . esc_html($log->status) . '</td>
                        <td>' . esc_html($log->sent_at) . '</td>
                    </tr>';
            }
        } else {
            echo '<tr><td colspan="7">' . esc_html__('No logs found.', 'bulk-sms-bd-for-woocommerce') . '</td></tr>';
        }

        echo '</tbody></table>';
        echo '</div>';
    }
}
