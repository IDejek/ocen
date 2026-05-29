<?php
/**
 * CRM System — PHP 8.1+ safe
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

class BDC_CRM {

    public static function get_customer_profile($email) {
        if (empty($email) || !is_email($email)) {
            return self::empty_profile($email);
        }

        $bookings = get_posts(array(
            'post_type'      => 'bdc_booking',
            'meta_key'       => 'email',
            'meta_value'     => $email,
            'posts_per_page' => 100,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));

        if (empty($bookings)) {
            return self::empty_profile($email);
        }

        $profile = self::empty_profile($email);
        $dest_counts = array();

        foreach ($bookings as $b) {
            self::merge_profile($profile, $b);
            self::count_dest($dest_counts, $b);
        }

        if (!empty($dest_counts)) {
            arsort($dest_counts);
            $profile['favorite_dest'] = array_key_first($dest_counts);
        }

        return $profile;
    }

    private static function empty_profile($email) {
        return array(
            'email'         => $email,
            'name'          => '',
            'phone'         => '',
            'nationality'   => '',
            'total_trips'   => 0,
            'total_spent'   => 0,
            'total_dives'   => 0,
            'cert_level'    => '',
            'favorite_dest' => '',
            'bookings'      => array(),
            'last_visit'    => '',
        );
    }

    private static function merge_profile(&$profile, $post) {
        $set_if_empty = function(&$target, $key, $value) {
            if (empty($target[$key]) && !empty($value)) {
                $target[$key] = $value;
            }
        };

        $set_if_empty($profile, 'name', get_post_meta($post->ID, 'name', true));
        $set_if_empty($profile, 'phone', get_post_meta($post->ID, 'phone', true));
        $set_if_empty($profile, 'nationality', get_post_meta($post->ID, 'nationality', true));
        $set_if_empty($profile, 'cert_level', get_post_meta($post->ID, 'certification_level', true));

        $paid = (float) get_post_meta($post->ID, 'paid_amount', true);
        $profile['total_spent'] += $paid;
        $profile['total_dives'] += (int) get_post_meta($post->ID, 'dives_count', true);
        $profile['total_trips']++;

        $profile['bookings'][] = array(
            'id'     => $post->ID,
            'date'   => $post->post_date,
            'type'   => get_post_meta($post->ID, 'trip_type', true),
            'status' => get_post_meta($post->ID, 'status', true),
            'amount' => $paid,
        );

        if (empty($profile['last_visit']) || strtotime($post->post_date) > strtotime($profile['last_visit'])) {
            $profile['last_visit'] = $post->post_date;
        }
    }

    private static function count_dest(&$counts, $post) {
        $trip_type = get_post_meta($post->ID, 'trip_type', true);
        if (!empty($trip_type)) {
            if (!isset($counts[$trip_type])) {
                $counts[$trip_type] = 0;
            }
            $counts[$trip_type]++;
        }
    }

    public static function get_loyalty_points($email) {
        $profile = self::get_customer_profile($email);
        $points  = ($profile['total_trips'] * 100) + floor($profile['total_spent'] / 10);
        return max(0, (int) $points);
    }

    public static function get_loyalty_level($email) {
        $points = self::get_loyalty_points($email);
        if ($points >= 5000) return array('name' => 'Platinum Diver', 'icon' => '💎', 'discount' => 15);
        if ($points >= 2000) return array('name' => 'Gold Diver', 'icon' => '🥇', 'discount' => 10);
        if ($points >= 500)  return array('name' => 'Silver Diver', 'icon' => '🥈', 'discount' => 5);
        return array('name' => 'Explorer', 'icon' => '🌊', 'discount' => 0);
    }
}
