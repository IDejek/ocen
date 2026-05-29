<?php
/**
 * Template Fallback — graceful degradation when no CPT content exists
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

class BDC_Template_Fallback {

    /**
     * Return safe excerpt/text, never empty
     */
    public static function safe_excerpt($post_id, $fallback = '') {
        $excerpt = get_the_excerpt($post_id);
        if (empty($excerpt) || $excerpt === '...') {
            return $fallback ?: __('Explore this amazing diving experience in North Sulawesi.', 'babarida-dive');
        }
        return $excerpt;
    }

    /**
     * Return safe price display
     */
    public static function safe_price($post_id, $currency = '$') {
        $price = get_post_meta($post_id, 'price_usd', true);
        if (empty($price) || $price <= 0) {
            return '';
        }
        return $currency . number_format((float) $price, 0);
    }

    /**
     * Return safe image with fallback
     */
    public static function safe_image($post_id, $size = 'bdc-card', $class = '') {
        if (has_post_thumbnail($post_id)) {
            return get_the_post_thumbnail($post_id, $size, array(
                'class' => $class,
                'loading' => 'lazy',
                'decoding' => 'async',
            ));
        }

        $sizes = array(
            'bdc-card'     => array(600, 450),
            'bdc-thumb'    => array(400, 300),
            'bdc-gallery'  => array(800, 600),
            'bdc-fullwidth'=> array(1400, 700),
            'thumbnail'    => array(150, 150),
            'medium'       => array(300, 225),
            'large'        => array(1024, 768),
        );

        $dims = isset($sizes[$size]) ? $sizes[$size] : array(600, 450);

        if (class_exists('BDC_Asset_Fallback')) {
            $src = BDC_Asset_Fallback::placeholder_svg($dims[0], $dims[1]);
        } else {
            $src = 'data:image/svg+xml,' . urlencode('<svg xmlns="http://www.w3.org/2000/svg" width="' . $dims[0] . '" height="' . $dims[1] . '"><rect width="100%" height="100%" fill="#003566"/></svg>');
        }

        return sprintf(
            '<img src="%s" width="%d" height="%d" alt="%s" class="%s" loading="lazy">',
            $src,
            $dims[0],
            $dims[1],
            esc_attr(get_the_title($post_id)),
            esc_attr($class)
        );
    }

    /**
     * Return safe meta value
     */
    public static function safe_meta($post_id, $key, $fallback = '') {
        $value = get_post_meta($post_id, $key, true);
        return (!empty($value)) ? $value : $fallback;
    }
}
