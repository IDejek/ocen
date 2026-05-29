<?php
/**
 * Dashboard Widgets
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

class BDC_Dashboard {

    public static function get_widgets() {
        $today = BDC_Booking_System::get_booking_stats('today');
        $month = BDC_Booking_System::get_booking_stats('month');

        return array(
            array(
                'label'  => __("Today's Bookings", 'babarida-dive'),
                'value'  => $today['total'],
                'icon'   => 'calendar',
                'color'  => '#0077B6',
                'change' => '+12%',
                'up'     => true,
            ),
            array(
                'label'  => __('Monthly Revenue', 'babarida-dive'),
                'value'  => '$' . number_format($month['revenue'], 0),
                'icon'   => 'dollar-sign',
                'color'  => '#10B981',
                'change' => '+8%',
                'up'     => true,
            ),
            array(
                'label'  => __('Active Bookings', 'babarida-dive'),
                'value'  => $month['confirmed'] + $month['paid'],
                'icon'   => 'users',
                'color'  => '#FFB703',
                'change' => '+5%',
                'up'     => true,
            ),
            array(
                'label'  => __('Completion Rate', 'babarida-dive'),
                'value'  => $month['total'] > 0 ? round(($month['completed'] / $month['total']) * 100) . '%' : '0%',
                'icon'   => 'check-circle',
                'color'  => '#E07A5F',
                'change' => '-2%',
                'up'     => false,
            ),
        );
    }

    public static function get_recent_bookings($limit = 10) {
        return get_posts(array(
            'post_type'      => 'bdc_booking',
            'posts_per_page' => $limit,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));
    }

    public static function get_popular_destinations() {
        global $wpdb;
        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT pm.meta_value AS dest, COUNT(*) AS count
             FROM {$wpdb->posts} p
             INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id AND pm.meta_key = 'trip_type'
             WHERE p.post_type = %s AND p.post_status = 'publish'
             AND p.post_date >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
             GROUP BY dest ORDER BY count DESC LIMIT 5",
            'bdc_booking'
        ));
        return $results ? $results : array();
    }
}
