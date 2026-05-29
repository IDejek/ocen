<?php
defined('ABSPATH') || exit;

class BDC_Weather_API {

    public static function get_current() {
        $api_key = get_theme_mod('bdc_weather_api_key', '');
        $lat = get_theme_mod('bdc_weather_lat', '1.6231');
        $lon = get_theme_mod('bdc_weather_lon', '124.7636');

        $cache_key = 'bdc_weather_' . md5($lat . $lon);
        $cached = get_transient($cache_key);
        if ($cached !== false) return $cached;

        if (!$api_key) {
            // Return realistic defaults for Manado area
            return array(
                'temp'     => 30,
                'water'    => 29,
                'visibility' => 20,
                'wind'     => 12,
                'tide'     => 1.2,
                'condition'=> 'Partly Cloudy',
            );
        }

        $response = wp_remote_get('https://api.openweathermap.org/data/2.5/weather?lat=' . $lat . '&lon=' . $lon . '&appid=' . $api_key . '&units=metric', array('timeout' => 10));
        if (is_wp_error($response)) return self::get_fallback();

        $data = json_decode(wp_remote_retrieve_body($response), true);
        if (!$data || isset($data['cod']) && $data['cod'] !== 200) return self::get_fallback();

        $result = array(
            'temp'      => round($data['main']['temp']),
            'water'     => round($data['main']['temp'] - 1, 1), // Approximate
            'visibility'=> isset($data['visibility']) ? round($data['visibility'] / 1000, 1) : 20,
            'wind'      => round($data['wind']['speed'] * 3.6), // m/s to km/h
            'tide'      => 1.2, // Would need tide API
            'condition' => $data['weather'][0]['description'] ?? 'Clear',
        );

        set_transient($cache_key, $result, 1800); // Cache 30 min
        return $result;
    }

    private static function get_fallback() {
        return array('temp' => 30, 'water' => 29, 'visibility' => 20, 'wind' => 12, 'tide' => 1.2, 'condition' => 'Partly Cloudy');
    }
}
