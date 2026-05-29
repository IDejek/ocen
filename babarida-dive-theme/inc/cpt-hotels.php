<?php
defined('ABSPATH') || exit;

function bdc_register_hotel() {
    register_post_type('bdc_hotel', array(
        'labels'       => array('name' => __('Hotels', 'babarida-dive'), 'singular_name' => __('Hotel', 'babarida-dive'), 'add_new_item' => __('Add New Hotel', 'babarida-dive'), 'all_items' => __('Hotel Partners', 'babarida-dive')),
        'public'       => true,
        'has_archive'  => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-building',
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'),
        'rewrite'      => array('slug' => 'hotels'),
    ));
}
add_action('init', 'bdc_register_hotel');

function bdc_hotel_meta() {
    add_meta_box('bdc_hotel_details', __('Hotel Details', 'babarida-dive'), 'bdc_hotel_details_cb', 'bdc_hotel', 'normal', 'high');
}
add_action('add_meta_boxes', 'bdc_hotel_meta');

function bdc_hotel_details_cb($post) {
    wp_nonce_field('bdc_hotel_nonce', 'bdc_hotel_nonce_field');
    $fields = array(
        'price_usd'   => __('Price per Night (USD)', 'babarida-dive'),
        'star_rating' => __('Star Rating (1-5)', 'babarida-dive'),
        'address'     => __('Address', 'babarida-dive'),
        'phone'       => __('Phone', 'babarida-dive'),
        'website'     => __('Website URL', 'babarida-dive'),
        'amenities'   => __('Amenities (comma separated)', 'babarida-dive'),
        'room_types'  => __('Room Types (comma separated)', 'babarida-dive'),
        'check_in'    => __('Check-in Time', 'babarida-dive'),
        'check_out'   => __('Check-out Time', 'babarida-dive'),
    );
    echo '<div class="bdc-meta-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">';
    foreach ($fields as $key => $label) {
        $val = get_post_meta($post->ID, $key, true);
        echo '<div><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html($label) . '</label>';
        echo '<input type="text" name="' . esc_attr($key) . '" value="' . esc_attr($val) . '" style="width:100%;padding:8px 12px;border:1px solid #ddd;border-radius:4px;"></div>';
    }
    echo '</div>';
}

function bdc_save_hotel($post_id) {
    if (!isset($_POST['bdc_hotel_nonce_field']) || !wp_verify_nonce($_POST['bdc_hotel_nonce_field'], 'bdc_hotel_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    $fields = array('price_usd', 'star_rating', 'address', 'phone', 'website', 'amenities', 'room_types', 'check_in', 'check_out');
    foreach ($fields as $f) {
        if (isset($_POST[$f])) update_post_meta($post_id, $f, sanitize_text_field($_POST[$f]));
    }
}
add_action('save_post_bdc_hotel', 'bdc_save_hotel');
