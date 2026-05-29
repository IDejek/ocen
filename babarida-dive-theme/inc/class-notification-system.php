<?php
/**
 * Notification System
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

class BDC_Notification_System {

    /**
     * Send booking confirmation to guest + admin
     */
    public static function send_booking_confirmation($booking_id, $data) {
        if (empty($data['email'])) return;

        $to      = $data['email'];
        $subject = __('Booking Received - ', 'babarida-dive') . get_bloginfo('name');
        $body    = sprintf(
            __('Hello %s,<br><br>Thank you for your booking request!<br><br><strong>Trip Type:</strong> %s<br><strong>Date:</strong> %s<br><strong>Guests:</strong> %s<br><br>We will confirm your booking within 24 hours.<br><br>Booking Reference: BDC-%d', 'babarida-dive'),
            esc_html($data['name'] ?? ''),
            esc_html($data['trip_type'] ?? ''),
            esc_html($data['date'] ?? ''),
            esc_html($data['guests'] ?? ''),
            $booking_id
        );
        $html_body = self::build_email_template(__('Booking Confirmation', 'babarida-dive'), $body);
        self::send_email($to, $subject, $html_body);

        // Admin notification
        $admin_email = get_theme_mod('bdc_email', get_option('admin_email'));
        if ($admin_email) {
            $admin_body = sprintf(
                'New booking from %s (%s). Trip: %s, Date: %s, Guests: %s',
                $data['name'] ?? '',
                $data['email'] ?? '',
                $data['trip_type'] ?? '',
                $data['date'] ?? '',
                $data['guests'] ?? ''
            );
            self::send_email($admin_email, 'New Booking - BDC-' . $booking_id, $admin_body);
        }
    }

    /**
     * Send WhatsApp notification (opens WA link, non-blocking)
     */
    public static function send_whatsapp_notification($data) {
        $wa_number = get_theme_mod('bdc_whatsapp', '62895801960359');
        if (!$wa_number) return;
        $msg = urlencode(sprintf(
            "New booking from %s\nEmail: %s\nTrip: %s\nDate: %s\nGuests: %s",
            $data['name'] ?? '',
            $data['email'] ?? '',
            $data['trip_type'] ?? '',
            $data['date'] ?? '',
            $data['guests'] ?? ''
        ));
        // Non-blocking, fire-and-forget
        wp_remote_get("https://api.whatsapp.com/send?phone={$wa_number}&text={$msg}", array(
            'timeout' => 2,
            'blocking' => false,
        ));
    }

    /**
     * Send HTML email
     */
    public static function send_email($to, $subject, $body) {
        if (!$to || !is_email($to)) return false;
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . get_bloginfo('name') . ' <noreply@' . parse_url(home_url(), PHP_URL_HOST) . '>',
        );
        return wp_mail($to, $subject, $body, $headers);
    }

    /**
     * Build branded email HTML wrapper
     */
    private static function build_email_template($title, $content) {
        $site_name = esc_html(get_bloginfo('name'));
        $year = date('Y');
        return '<div style="max-width:600px;margin:0 auto;font-family:DM Sans,Arial,sans-serif;color:#0B1D35;">'
            . '<div style="background:linear-gradient(135deg,#003566,#0077B6);padding:32px;border-radius:12px 12px 0 0;text-align:center;">'
            . '<h1 style="color:#ffffff;font-family:Playfair Display,Georgia,serif;margin:0;font-size:24px;">' . $site_name . '</h1>'
            . '</div>'
            . '<div style="background:#ffffff;padding:32px;border:1px solid #EEF2F6;border-top:none;border-radius:0 0 12px 12px;">'
            . '<h2 style="color:#003566;margin:0 0 16px;font-size:20px;">' . $title . '</h2>'
            . '<div style="line-height:1.7;color:#334155;font-size:15px;">' . $content . '</div>'
            . '</div>'
            . '<p style="text-align:center;font-size:12px;color:#94A3B8;margin-top:16px;">&copy; ' . $year . ' ' . $site_name . '</p>'
            . '</div>';
            /**
     * Public wrapper for build_email_template (used by newsletter)
     */
    public static function build_email_template_protected($title, $content) {
        return self::build_email_template($title, $content);
    
    }
}
