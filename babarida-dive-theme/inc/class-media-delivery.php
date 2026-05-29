<?php
defined('ABSPATH') || exit;

class BDC_Media_Delivery {

    public static function get_trip_media($booking_id) {
        return get_post_meta($booking_id, 'trip_media', true);
    }

    public static function add_media($booking_id, $attachment_ids) {
        $existing = self::get_trip_media($booking_id);
        if (!is_array($existing)) $existing = array();
        $merged = array_unique(array_merge($existing, $attachment_ids));
        update_post_meta($booking_id, 'trip_media', $merged);
    }

    public static function create_gallery_page($booking_id) {
        $media = self::get_trip_media($booking_id);
        if (empty($media)) return false;

        $page_id = wp_insert_post(array(
            'post_title'  => __('Your Trip Photos', 'babarida-dive') . ' - BDC-' . $booking_id,
            'post_type'   => 'page',
            'post_status' => 'private',
            'meta_input'  => array('bdc_booking_media' => $booking_id),
        ));
        return $page_id;
    }
}
