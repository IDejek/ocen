<?php
/**
 * Booking System
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

class BDC_Booking_System {

    public static function init() {
        add_action('bdc_booking_confirmed', array(__CLASS__, 'reduce_availability'));
        add_action('bdc_booking_cancelled', array(__CLASS__, 'restore_availability'));
    }

    public static function reduce_availability($booking_id) {
        if (!$booking_id) return;
        $trip_id = get_post_meta($booking_id, 'trip_id', true);
        $guests  = get_post_meta($booking_id, 'guests', true);
        if ($trip_id && $guests) {
            $current = (int) get_post_meta($trip_id, 'booked_count', true);
            update_post_meta($trip_id, 'booked_count', $current + (int) $guests);
            $max = (int) get_post_meta($trip_id, 'max_guests', true);
            if ($max > 0) {
                $available = $max - $current - (int) $guests;
                update_post_meta($trip_id, 'available_spots', max(0, $available));
            }
        }
    }

    public static function restore_availability($booking_id) {
        if (!$booking_id) return;
        $trip_id = get_post_meta($booking_id, 'trip_id', true);
        $guests  = get_post_meta($booking_id, 'guests', true);
        if ($trip_id && $guests) {
            $current = (int) get_post_meta($trip_id, 'booked_count', true);
            $reduced = max(0, $current - (int) $guests);
            update_post_meta($trip_id, 'booked_count', $reduced);
            $max = (int) get_post_meta($trip_id, 'max_guests', true);
            if ($max > 0) {
                update_post_meta($trip_id, 'available_spots', min($max, $max - $reduced));
            }
        }
    }

    public static function check_availability($trip_id, $date, $guests) {
        if (!$trip_id || !$guests) return false;
        $available = (int) get_post_meta($trip_id, 'available_spots', true);
        $max = (int) get_post_meta($trip_id, 'max_guests', true);
        if (!$available && $max > 0) {
            $booked = (int) get_post_meta($trip_id, 'booked_count', true);
            $available = $max - $booked;
        }
        return $available >= (int) $guests;
    }

    public static function get_booking_stats($period = 'today') {
        $args = array(
            'post_type'      => 'bdc_booking',
            'posts_per_page' => -1,
            'fields'         => 'ids',
        );
        switch ($period) {
            case 'today':
                $args['date_query'] = array(array(
                    'year'  => date('Y'),
                    'month' => date('m'),
                    'day'   => date('d'),
                ));
                break;
            case 'week':
                $args['date_query'] = array(array('after' => '1 week ago'));
                break;
            case 'month':
                $args['date_query'] = array(array(
                    'month' => date('m'),
                    'year'  => date('Y'),
                ));
                break;
            case 'year':
                $args['date_query'] = array(array('year' => date('Y')));
                break;
        }

        $ids = get_posts($args);
        $stats = array(
            'total'     => count($ids),
            'pending'   => 0,
            'confirmed' => 0,
            'paid'      => 0,
            'completed' => 0,
            'cancelled' => 0,
            'revenue'   => 0,
        );

        if (empty($ids)) return $stats;

        global $wpdb;
        $ids_csv = implode(',', array_map('intval', $ids));
        $meta = $wpdb->get_results(
            "SELECT post_id, meta_key, meta_value FROM {$wpdb->postmeta} 
             WHERE post_id IN ($ids_csv) 
             AND meta_key IN ('status','paid_amount')",
            ARRAY_A
        );

        $mapped = array();
        foreach ($meta as $row) {
            $mapped[$row['post_id']][$row['meta_key']] = $row['meta_value'];
        }

        foreach ($ids as $id) {
            $status = isset($mapped[$id]['status']) ? $mapped[$id]['status'] : '';
            if (isset($stats[$status])) {
                $stats[$status]++;
            }
            $paid = isset($mapped[$id]['paid_amount']) ? (float) $mapped[$id]['paid_amount'] : 0;
            if (in_array($status, array('paid', 'completed'))) {
                $stats['revenue'] += $paid;
            }
        }

        return $stats;
    }

    public static function generate_invoice($booking_id) {
        if (!$booking_id) return array();
        return array(
            'id'           => $booking_id,
            'qr'           => get_post_meta($booking_id, 'qr_code', true),
            'name'         => get_post_meta($booking_id, 'name', true),
            'email'        => get_post_meta($booking_id, 'email', true),
            'trip'         => get_post_meta($booking_id, 'trip_type', true),
            'date'         => get_post_meta($booking_id, 'date', true),
            'guests'       => get_post_meta($booking_id, 'guests', true),
            'total'        => get_post_meta($booking_id, 'total_price', true),
            'paid'         => get_post_meta($booking_id, 'paid_amount', true),
            'status'       => get_post_meta($booking_id, 'status', true),
            'company_name' => get_bloginfo('name'),
            'company_email' => get_theme_mod('bdc_email', 'info@babaridadive.com'),
            'date_issued'  => current_time('mysql'),
        );
    }
}

BDC_Booking_System::init();
