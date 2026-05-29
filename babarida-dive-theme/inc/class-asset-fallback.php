<?php
/**
 * Asset Fallback — prevents 404 errors on missing images
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

class BDC_Asset_Fallback {

    /**
     * Return SVG data URI as fallback when image file doesn't exist
     */
    public static function placeholder_svg($width = 600, $height = 450, $text = '') {
        $label = $text ? esc_attr($text) : 'Babarida Dive';
        $bg = '%23003366'; // URL-encoded #003566
        return "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='{$width}' height='{$height}'%3E%3Crect width='100%25' height='100%25' fill='{$bg}'/%3E%3Ctext x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' font-family='sans-serif' font-size='16' fill='%2390E0EF'%3E{$label}%3C/text%3E%3C/svg%3E";
    }

    /**
     * Filter get_post_thumbnail to return SVG fallback
     */
    public static function filter_thumbnail($html, $post_id, $thumb_id, $size, $attr) {
        // If WordPress already generated HTML, return it
        if (!empty($html)) {
            return $html;
        }

        // If no thumbnail, return SVG fallback
        $size_data = wp_get_attachment_image_src($thumb_id, $size);
        $w = is_array($size_data) ? $size_data[1] : 600;
        $h = is_array($size_data) ? $size_data[2] : 450;

        $class = isset($attr['class']) ? esc_attr($attr['class']) : '';
        $alt   = isset($attr['alt']) ? esc_attr($attr['alt']) : '';

        return sprintf(
            '<img src="%s" width="%d" height="%d" alt="%s" class="%s" loading="lazy" decoding="async">',
            self::placeholder_svg($w, $h, $alt),
            $w,
            $h,
            $alt,
            $class
        );
    }

    /**
     * Check if an image URL exists, return fallback if not
     */
    public static function safe_image_url($url, $fallback = '') {
        if (empty($url)) {
            return $fallback ? $fallback : self::placeholder_svg(600, 450);
        }
        return $url;
    }
}

// Hook into post thumbnail
add_filter('post_thumbnail_html', array('BDC_Asset_Fallback', 'filter_thumbnail'), 10, 5);
