<?php
defined('ABSPATH') || exit;

class BDC_CRM {

    public static function get_customer_profile($email) {
        $bookings = get_posts(array(
            'post_type'  => 'bdc_booking',
            'meta_key'   => 'email',
            'meta_value' => $email,
            'posts_per_page' => -1,
            'orderby'    => 'date',
            'order'      => 'DESC',
        ));

        $profile = array(
            'email'        => $email,
            'name'         => '',
            'phone'        => '',
            'nationality'  => '',
            'total_trips'  => count($bookings),
            'total_spent'  => 0,
            'total_dives'  => 0,
            'cert_level'   => '',
            'favorite_dest'=> '',
            'bookings'     => array(),
            'last_visit'   => '',
        );

        $dest_counts = array();
        foreach ($bookings as $b) {
            $profile['name'] = $profile['name'] ?: get_post_meta($b->ID, 'name', true);
            $profile['phone'] = $profile['phone'] ?: get_post_meta($b->ID, 'phone', true);
            $profile['nationality'] = $profile['nationality'] ?: get_post_meta($b->ID, 'nationality', true);
            $profile['cert_level'] = $profile['cert_level'] ?: get_post_meta($b->ID, 'certification_level', true);
            $paid = (float) get_post_meta($b->ID, 'paid_amount', true);
            $profile['total_spent'] += $paid;
            $profile['total_dives'] += (int) get_post_meta($b->ID, 'dives_count', true);
            $profile['bookings'][] = array(
                'id'     => $b->ID,
                'date'   => $b->post_date,
                'type'   => get_post_meta($b->ID, 'trip_type', true),
                'status' => get_post_meta($b->ID, 'status', true),
                'amount' => $paid,
            );
            $trip_type = get_post_meta($b->ID, 'trip_type', true);
            $dest_counts[$trip_type] = ($dest_counts[$trip_type] ?? 0) + 1;
            if (!$profile['last_visit'] || strtotime($b->post_date) > strtotime($profile['last_visit'])) {
                $profile['last_visit'] = $b->post_date;
            }
        }
        if (!empty($dest_counts)) {
            arsort($dest_counts);
            $profile['favorite_dest'] = array_key_first($dest_counts);
        }
        return $profile;
    }

    public static function get_loyalty_points($email) {
        $profile = self::get_customer_profile($email);
        $points = $profile['total_trips'] * 100;
        $points += floor($profile['total_spent'] / 10);
        return $points;
    }

    public static function get_loyalty_level($email) {
        $points = self::get_loyalty_points($email);
        if ($points >= 5000) return array('name' => 'Platinum Diver', 'discount' => 15);
        if ($points >= 2000) return array('name' => 'Gold Diver', 'discount' => 10);
        if ($points >= 500)  return array('name' => 'Silver Diver', 'discount' => 5);
        return array('name' => 'Explorer', 'discount' => 0);
    }
}
