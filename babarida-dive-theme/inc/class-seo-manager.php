<?php
defined('ABSPATH') || exit;

class BDC_SEO_Manager {

    public static function meta_title($title) {
        if (is_singular(array('bdc_trip', 'bdc_liveaboard', 'bdc_course', 'bdc_watersport', 'bdc_destination', 'bdc_hotel'))) {
            $custom = get_post_meta(get_the_ID(), '_seo_title', true);
            if ($custom) return $custom . ' | ' . get_bloginfo('name');
            $price = get_post_meta(get_the_ID(), 'price_usd', true);
            $suffix = $price ? ' from $' . number_format($price) . ' | ' . get_bloginfo('name') : ' | ' . get_bloginfo('name');
            return get_the_title() . $suffix;
        }
        return $title;
    }

    public static function meta_description() {
        if (is_singular()) {
            $custom = get_post_meta(get_the_ID(), '_seo_description', true);
            if ($custom) return $custom;
            return wp_strip_all_tags(get_the_excerpt());
        }
        if (is_front_page()) return get_bloginfo('description');
        return '';
    }

    public static function output_meta() {
        $desc = self::meta_description();
        if ($desc) echo '<meta name="description" content="' . esc_attr($desc) . '">' . "\n";

        // Canonical
        if (is_singular()) {
            echo '<link rel="canonical" href="' . esc_url(get_permalink()) . '">' . "\n";
        }

        // OG overrides for singular
        if (is_singular()) {
            $og_img = get_post_meta(get_the_ID(), '_seo_og_image', true);
            if (!$og_img && has_post_thumbnail()) $og_img = get_the_post_thumbnail_url(get_the_ID(), 'full');
            if ($og_img) echo '<meta property="og:image" content="' . esc_url($og_img) . '">' . "\n";
        }

        // Noindex for non-public CPTs
        if (is_post_type_archive('bdc_booking')) {
            echo '<meta name="robots" content="noindex, nofollow">' . "\n";
        }
    }
}
add_filter('pre_get_document_title', array('BDC_SEO_Manager', 'meta_title'));
add_action('wp_head', array('BDC_SEO_Manager', 'output_meta'), 2);
