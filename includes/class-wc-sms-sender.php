<?php
class WC_SMS_Sender {

    public static function send_sms($order, $message) {
        $api_key = get_option('wc_sms_api_key');
        $sender_id = get_option('wc_sms_sender_id');
        $phone = $order->get_billing_phone();

        if (!$api_key || !$sender_id || !$phone) return;

        $data = [
            'api_key'  => $api_key,
            'senderid' => $sender_id,
            'number'   => $phone,
            'message'  => $message,
        ];

        $response = wp_remote_post('http://bulksmsbd.net/api/smsapi', ['body' => $data]);

        $status = is_wp_error($response) ? 'Failed' : 'Sent';
        WC_SMS_Logger::log($order->get_billing_first_name(), $order->get_billing_email(), $phone, $message, $status);
    }

    public static function get_balance($api_key) {
        $url = 'http://bulksmsbd.net/api/getBalanceApi?api_key=' . urlencode($api_key);
        $res = wp_remote_get($url);

        if (is_wp_error($res)) return 'Unavailable';
        $body = json_decode(wp_remote_retrieve_body($res), true);
        return $body['balance'] ?? 'Error';
    }
}
