<?php
defined('ABSPATH') || exit;

class BDC_Payment_Gateway {

    private static $gateways = array('midtrans', 'xendit', 'stripe', 'paypal', 'bank_transfer');

    public static function process_payment($booking_id, $method, $amount) {
        switch ($method) {
            case 'midtrans':  return self::process_midtrans($booking_id, $amount);
            case 'xendit':    return self::process_xendit($booking_id, $amount);
            case 'stripe':    return self::process_stripe($booking_id, $amount);
            case 'paypal':    return self::process_paypal($booking_id, $amount);
            case 'bank_transfer': return self::process_bank_transfer($booking_id, $amount);
            default: return array('success' => false, 'message' => __('Invalid payment method.', 'babarida-dive'));
        }
    }

    private static function process_midtrans($booking_id, $amount) {
        $server_key = get_theme_mod('bdc_midtrans_key', '');
        if (!$server_key) return array('success' => false, 'message' => __('Midtrans not configured.', 'babarida-dive'));
        $payload = array(
            'transaction_details' => array(
                'order_id'     => 'BDC-' . $booking_id,
                'gross_amount' => (int) $amount,
            ),
            'customer_details' => array(
                'name'  => get_post_meta($booking_id, 'name', true),
                'email' => get_post_meta($booking_id, 'email', true),
                'phone' => get_post_meta($booking_id, 'phone', true),
            ),
        );
        $response = wp_remote_post('https://app.sandbox.midtrans.com/snap/v1/transactions', array(
            'headers' => array('Content-Type' => 'application/json', 'Accept' => 'application/json', 'Authorization' => 'Basic ' . base64_encode($server_key . ':')),
            'body'    => wp_json_encode($payload),
            'timeout' => 30,
        ));
        if (is_wp_error($response)) return array('success' => false, 'message' => $response->get_error_message());
        $body = json_decode(wp_remote_retrieve_body($response), true);
        if (isset($body['token'])) {
            update_post_meta($booking_id, 'payment_id', $body['token']);
            update_post_meta($booking_id, 'payment_method', 'midtrans');
            return array('success' => true, 'token' => $body['token'], 'redirect_url' => $body['redirect_url'] ?? '');
        }
        return array('success' => false, 'message' => $body['message'] ?? __('Payment failed.', 'babarida-dive'));
    }

    private static function process_xendit($booking_id, $amount) {
        $api_key = get_theme_mod('bdc_xendit_key', '');
        if (!$api_key) return array('success' => false, 'message' => __('Xendit not configured.', 'babarida-dive'));
        $response = wp_remote_post('https://api.xendit.co/v2/invoices', array(
            'headers' => array('Content-Type' => 'application/json', 'Authorization' => 'Basic ' . base64_encode($api_key . ':')),
            'body'    => wp_json_encode(array(
                'external_id'  => 'BDC-' . $booking_id,
                'amount'       => (float) $amount,
                'description'  => 'Booking BDC-' . $booking_id,
                'customer'     => array('email' => get_post_meta($booking_id, 'email', true), 'name' => get_post_meta($booking_id, 'name', true)),
                'success_redirect_url' => home_url('/booking-confirmed/?id=' . $booking_id),
                'failure_redirect_url' => home_url('/booking-failed/?id=' . $booking_id),
            )),
            'timeout' => 30,
        ));
        if (is_wp_error($response)) return array('success' => false, 'message' => $response->get_error_message());
        $body = json_decode(wp_remote_retrieve_body($response), true);
        if (isset($body['invoice_url'])) {
            update_post_meta($booking_id, 'payment_id', $body['id']);
            update_post_meta($booking_id, 'payment_method', 'xendit');
            return array('success' => true, 'redirect_url' => $body['invoice_url']);
        }
        return array('success' => false, 'message' => $body['message'] ?? __('Payment failed.', 'babarida-dive'));
    }

    private static function process_stripe($booking_id, $amount) {
        $key = get_theme_mod('bdc_stripe_key', '');
        if (!$key) return array('success' => false, 'message' => __('Stripe not configured.', 'babarida-dive'));
        update_post_meta($booking_id, 'payment_method', 'stripe');
        return array('success' => true, 'publishable_key' => $key, 'amount' => $amount * 100, 'currency' => 'usd', 'booking_id' => $booking_id);
    }

    private static function process_paypal($booking_id, $amount) {
        $client_id = get_theme_mod('bdc_paypal_client', '');
        if (!$client_id) return array('success' => false, 'message' => __('PayPal not configured.', 'babarida-dive'));
        update_post_meta($booking_id, 'payment_method', 'paypal');
        return array('success' => true, 'client_id' => $client_id, 'amount' => $amount, 'currency' => 'USD', 'booking_id' => $booking_id);
    }

    private static function process_bank_transfer($booking_id, $amount) {
        update_post_meta($booking_id, 'payment_method', 'bank_transfer');
        $bank_details = get_theme_mod('bdc_bank_accounts', '');
        return array('success' => true, 'message' => __('Please transfer to one of the following bank accounts:', 'babarida-dive'), 'bank_details' => $bank_details, 'amount' => $amount);
    }

    public static function handle_webhook($gateway) {
        $payload = file_get_contents('php://input');
        switch ($gateway) {
            case 'midtrans':
                $notif = json_decode($payload, true);
                if (isset($notif['order_id']) && strpos($notif['order_id'], 'BDC-') === 0) {
                    $id = (int) str_replace('BDC-', '', $notif['order_id']);
                    if ($notif['transaction_status'] === 'settlement') {
                        update_post_meta($id, 'status', 'paid');
                        update_post_meta($id, 'paid_amount', $notif['gross_amount']);
                    } elseif ($notif['transaction_status'] === 'expire') {
                        update_post_meta($id, 'status', 'cancelled');
                    }
                }
                http_response_code(200);
                exit;
            case 'xendit':
                $notif = json_decode($payload, true);
                if (isset($notif['external_id']) && strpos($notif['external_id'], 'BDC-') === 0) {
                    $id = (int) str_replace('BDC-', '', $notif['external_id']);
                    if ($notif['status'] === 'PAID') {
                        update_post_meta($id, 'status', 'paid');
                        update_post_meta($id, 'paid_amount', $notif['amount']);
                    }
                }
                http_response_code(200);
                exit;
        }
    }

    // Webhook endpoints
    public static function register_webhooks() {
        add_rewrite_rule('^payment/webhook/midtrans/?$', 'index.php?bdc_webhook=midtrans', 'top');
        add_rewrite_rule('^payment/webhook/xendit/?$', 'index.php?bdc_webhook=xendit', 'top');
        add_filter('query_vars', function($vars) { $vars[] = 'bdc_webhook'; return $vars; });
        add_action('template_redirect', function() {
            $webhook = get_query_var('bdc_webhook');
            if ($webhook) self::handle_webhook($webhook);
        });
    }
}
BDC_Payment_Gateway::register_webhooks();
