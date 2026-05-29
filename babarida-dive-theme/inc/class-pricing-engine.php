<?php
defined('ABSPATH') || exit;

class BDC_Pricing_Engine {

    public static function get_price($trip_id, $date = '') {
        if (!$date) $date = current_time('Y-m-d');
        $month = date('n', strtotime($date));
        $base_price = (float) get_post_meta($trip_id, 'price_usd', true);
        $season_multiplier = self::get_season_multiplier($month);
        return round($base_price * $season_multiplier, 2);
    }

    public static function get_season_multiplier($month) {
        if (in_array($month, array(6, 7, 8, 9))) return 1.35;   // Peak
        if (in_array($month, array(4, 5, 10, 11, 12))) return 1.15; // High
        return 1.0; // Low
    }

    public static function get_season_name($month) {
        if (in_array($month, array(6, 7, 8, 9))) return 'peak';
        if (in_array($month, array(4, 5, 10, 11, 12))) return 'high';
        return 'low';
    }

    public static function apply_promo($price, $promo_code = '') {
        if (!$promo_code) return $price;
        $promos = get_option('bdc_promo_codes', array());
        if (isset($promos[$promo_code])) {
            $promo = $promos[$promo_code];
            if ($promo['expires'] && strtotime($promo['expires']) < time()) return $price;
            if (isset($promo['type']) && $promo['type'] === 'percent') {
                return round($price * (1 - $promo['value'] / 100), 2);
            }
            if (isset($promo['type']) && $promo['type'] === 'fixed') {
                return max(0, $price - $promo['value']);
            }
        }
        return $price;
    }

    public static function calculate_group_discount($price, $guests) {
        if ($guests >= 10) return round($price * 0.85, 2);
        if ($guests >= 6) return round($price * 0.90, 2);
        if ($guests >= 4) return round($price * 0.95, 2);
        return $price;
    }

    public static function convert_currency($amount_usd, $to = 'USD') {
        $rates = array(
            'USD' => 1,
            'EUR' => 0.92,
            'SGD' => 1.34,
            'AUD' => 1.53,
            'IDR' => 15600,
        );
        $rate = $rates[$to] ?? 1;
        return round($amount_usd * $rate, $to === 'IDR' ? 0 : 2);
    }
}
