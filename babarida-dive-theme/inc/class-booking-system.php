<?php
defined('ABSPATH') || exit;

class BDC_Booking_System {

    public static function init() {
        add_action('bdc_booking_confirmed', array(__CLASS__, 'reduce_availability'));
        add_action('bdc_booking_cancelled', array(__CLASS__, 'restore_availability'));
    }

    public static function reduce_availability($booking_id) {
        $trip_id = get_post_meta($booking_id, 'trip_id', true);
        $guests = get_post_meta($booking_id, 'guests', true);
        if ($trip_id && $guests) {
            $current = (int) get_post_meta($trip_id, 'booked_count', true);
            update_post_meta($trip_id, 'booked_count', $current + (int) $guests);
            $max = (int) get_post_meta($trip_id, 'max_guests', true);
            $available = $max - $current - (int) $guests;
            update_post_meta($trip_id, 'available_spots', max(0, $available));
        }
    }

    public static function restore_availability($booking_id) {
        $trip_id = get_post_meta($booking_id, 'trip_id', true);
        $guests = get_post_meta($booking_id, 'guests', true);
        if ($trip_id && $guests) {
            $current = (int) get_post_meta($trip_id, 'booked_count', true);
            update_post_meta($trip_id, 'booked_count', max(0, $current - (int) $guests));
            $max = (int) get_post_meta($trip_id, 'max_guests', true);
            update_post_meta($trip_id, 'available_spots', min($max, $max - max(0, $current - (int) $guests)));
        }
    }

    public static function check_availability($trip_id, $date, $guests) {
        $available = (int) get_post_meta($trip_id, 'available_spots', true);
        $max = (int) get_post_meta($trip_id, 'max_guests', true);
        if (!$available) $available = $max; // fallback
        return $available >= (int) $guests;
    }

    public static function get_booking_stats($period = 'today') {
        $args = array('post_type' => 'bdc_booking', 'posts_per_page' => -1, 'fields' => 'ids');
        switch ($period) {
            case 'today': $args['date_query'] = array(array('year' => date('Y'), 'month' => date('m'), 'day' => date('d'))); break;
            case 'week': $args['date_query'] = array(array('after' => '1 week ago')); break;
            case 'month': $args['date_query'] = array(array('month' => date('m'), 'year' => date('Y'))); break;
            case 'year': $args['date_query'] = array(array('year' => date('Y'))); break;
        }
        $ids = get_posts($args);
        $stats = array('total' => count($ids), 'pending' => 0, 'confirmed' => 0, 'paid' => 0, 'completed' => 0, 'cancelled' => 0, 'revenue' => 0);
        foreach ($ids as $id) {
            $status = get_post_meta($id, 'status', true);
            if (isset($stats[$status])) $stats[$status]++;
            $paid = (float) get_post_meta($id, 'paid_amount', true);
            if (in_array($status, array('paid', 'completed'))) $stats['revenue'] += $paid;
        }
        return $stats;
    }

    public static function generate_invoice($booking_id) {
        $data = array(
            'id'       => $booking_id,
            'qr'       => get_post_meta($booking_id, 'qr_code', true),
            'name'     => get_post_meta($booking_id, 'name', true),
            'email'    => get_post_meta($booking_id, 'email', true),
            'trip'     => get_post_meta($booking_id, 'trip_type', true),
            'date'     => get_post_meta($booking_id, 'date', true),
            'guests'   => get_post_meta($booking_id, 'guests', true),
            'total'    => get_post_meta($booking_id, 'total_price', true),
            'paid'     => get_post_meta($booking_id, 'paid_amount', true),
            'status'   => get_post_meta($booking_id, 'status', true),
            'company'  => get_bloginfo('name'),
            'email'    => get_theme_mod('bdc_email', 'info
