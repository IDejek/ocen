<?php
defined('ABSPATH') || exit;

class BDC_Notification_System {

    public static function send_booking_confirmation($booking_id, $data) {
        $to = $data['email'];
        $subject = __('Booking Received - ', 'babarida-dive') . get_bloginfo('name');
        $body = self::build_email_template(__('Booking Confirmation', 'babarida-dive'), sprintf(
            __('Hello %s,<br><br>Thank you for your booking request!<br><br><strong>Trip Type:</strong> %s<br><strong>Date:</strong> %s<br><strong>Guests:</strong> %s<br><br>We will confirm your booking within 24 hours.<br><br>Booking Reference: BDC-%d', 'babarida-dive'),
            esc_html($data['name']),
            esc_html($data['trip_type']),
            esc_html($data['date']),
            esc_html($data['guests']),
            $booking_id
        ));
        self::send_email($to, $subject, $body);

        // Admin notification
        $admin_email = get_theme_mod('bdc_email', get_option('admin_email'));
        self::send_email($admin_email, 'New Booking - BDC-' . $booking_id, "New booking from {$data['name']} ({$data['email']}). Trip: {$data['trip_type']}, Date: {$data['date']}, Guests: {$data['guests']}");
    }

    public static function send_whatsapp_notification($data) {
        $wa = get_theme_mod('bdc_whatsapp', '62895801960359');
        $msg = urlencode("New booking from {$data['name']}\nEmail: {$data['email']}\nTrip: {$data['trip_type']}\nDate: {$data['date']}\nGuests: {$data['guests']}");
        // Silent notification to admin (non-blocking)
        wp_remote_get("https://api.whatsapp.com/send?phone={$wa}&text={$msg}", array('timeout' => 3));
    }

    public static function send_email($to, $subject, $body) {
        $headers = array('Content-Type: text/html; charset=UTF-8', 'From: ' . get_bloginfo('name') . ' <noreply@' . parse_url(home_url(), PHP_URL_HOST) . '>');
        wp_mail($to, $subject, $body, $headers);
    }

    private static function build_email_template($title, $content) {
        return '<div style="max-width:600px;margin:0 auto;font-family:DM Sans,sans-serif;color:#0B1D35;">'
            . '<div style="background:linear-gradient(135deg,#003566,#0077B6);padding:32px;border-radius:12px 12px 0 0;text-align:center;">'
            . '<h1 style="color:white;font-family:Playfair Display,serif;margin:0;font-size:24px;">' . esc_html(get_bloginfo('name')) . '</h1>'
            . '</div>'
            . '<div style="background:white;padding:32px;border:1px solid #EEF2F6;border-top:none;border-radius:0 0 12px 12px;">'
            . '<h2 style="color:#003566;margin:0 0 16px;">' . $title . '</h2>'
            . '<p style="line-height:1.7;color:#334155;">' . $content . '</p>'
            . '</div>'
            . '<p style="text-align:center;font-size:12px;color:#94A3B8;margin-top:16px;">© ' . date('Y') . ' ' . esc_html(get_bloginfo('name')) . '</p>'
            . '</div>';
    }
}
