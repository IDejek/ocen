<?php
defined('ABSPATH') || exit;

class BDC_Waiver_System {

    public static function save_waiver($booking_id, $data) {
        $waiver_id = wp_insert_post(array(
            'post_title'  => 'Waiver - ' . $data['name'] . ' - BDC-' . $booking_id,
            'post_type'   => 'bdc_waiver',
            'post_status' => 'publish',
            'meta_input'  => array(
                'booking_id'  => $booking_id,
                'full_name'   => sanitize_text_field($data['name']),
                'signature'   => sanitize_text_field($data['signature'] ?? ''),
                'ip_address'  => $_SERVER['REMOTE_ADDR'],
                'accepted_at' => current_time('mysql'),
                'medical_conditions' => sanitize_textarea_field($data['medical'] ?? ''),
                'emergency_contact'  => sanitize_text_field($data['emergency'] ?? ''),
            ),
        ));
        return $waiver_id;
    }

    public static function is_signed($booking_id) {
        $exists = get_posts(array('post_type' => 'bdc_waiver', 'meta_key' => 'booking_id', 'meta_value' => $booking_id, 'posts_per_page' => 1));
        return !empty($exists);
    }
}
