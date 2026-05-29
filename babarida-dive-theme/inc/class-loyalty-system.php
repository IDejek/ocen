<?php
defined('ABSPATH') || exit;

class BDC_Loyalty_System {

    public static function add_points($email, $points, $reason = '') {
        $subscribers = get_option('bdc_loyalty_members', array());
        if (!isset($subscribers[$email])) {
            $subscribers[$email] = array('points' => 0, 'history' => array(), 'joined' => current_time('mysql'));
        }
        $subscribers[$email]['points'] += $points;
        $subscribers[$email]['history'][] = array('points' => $points, 'reason' => $reason, 'date' => current_time('mysql'));
        update_option('bdc_loyalty_members', $subscribers);
    }

    public static function get_points($email) {
        $members = get_option('bdc_loyalty_members', array());
        return $members[$email]['points'] ?? 0;
    }

    public static function get_level($email) {
        $points = self::get_points($email);
        if ($points >= 5000) return array('name' => 'Platinum Diver', 'icon' => '💎', 'discount' => 15, 'color' => '#E5E4E2');
        if ($points >= 2000) return array('name' => 'Gold Diver', 'icon' => '🥇', 'discount' => 10, 'color' => '#FFD700');
        if ($points >= 500)  return array('name' => 'Silver Diver', 'icon' => '🥈', 'discount' => 5, 'color' => '#C0C0C0');
        return array('name' => 'Explorer', 'icon' => '🌊', 'discount' => 0, 'color' => '#0077B6');
    }
}
