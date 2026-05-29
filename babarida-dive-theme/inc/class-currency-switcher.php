<?php
defined('ABSPATH') || exit;

class BDC_Currency_Switcher {

    public static function get_active_currency() {
        return $_COOKIE['bdc_currency'] ?? 'USD';
    }

    public static function format_price($amount_usd, $currency = '') {
        if (!$currency) $currency = self::get_active_currency();
        $converted = BDC_Pricing_Engine::convert_currency($amount_usd, $currency);
        $symbols = array('USD' => '$', 'EUR' => '€', 'SGD' => 'S$', 'AUD' => 'A$', 'IDR' => 'Rp');
        $symbol = $symbols[$currency] ?? '$';
        if ($currency === 'IDR') return $symbol . number_format($converted, 0, ',', '.');
        return $symbol . number_format($converted, 2);
    }

    public static function get_currency_options() {
        return array(
            'USD' => array('name' => 'US Dollar', 'symbol' => '$', 'rate' => 1),
            'EUR' => array('name' => 'Euro', 'symbol' => '€', 'rate' => 0.92),
            'SGD' => array('name' => 'Singapore Dollar', 'symbol' => 'S$', 'rate' => 1.34),
            'AUD' => array('name' => 'Australian Dollar', 'symbol' => 'A$', 'rate' => 1.53),
            'IDR' => array('name' => 'Indonesian Rupiah', 'symbol' => 'Rp', 'rate' => 15600),
        );
    }
}
