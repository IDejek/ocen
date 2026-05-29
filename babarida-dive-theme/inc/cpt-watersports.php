<?php
defined('ABSPATH') || exit;

function bdc_register_watersport() {
    register_post_type('bdc_watersport', array(
        'labels'       => array('name' => __('Water Sports', 'babarida-dive'), 'singular_name' => __('Water Sport', 'babarida-dive'), 'add_new_item' => __('Add New Water Sport', 'babarida-dive'), 'all_items' => __('All Water Sports', 'babarida-dive')),
        'public'       => true,
        'has_archive'  => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-water',
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'),
        'rewrite'      => array('slug' => 'water-sports'),
    ));
}
add_action('init', 'bdc_register_watersport');

function bdc_watersport_meta() {
    add_meta_box('bdc_ws_details', __('Water Sport Details', 'babarida-dive'), 'bdc_ws_details_cb', 'bdc_watersport', 'normal', 'high');
}
add_action('add_meta_boxes', 'bdc_watersport_meta');

function bdc_ws_details_cb($post) {
    wp_nonce_field('bdc_ws_nonce', 'bdc_ws_nonce_field');
    $fields = array('price_usd' => __('Price per Session (USD)', 'babarida-dive'), 'duration' => __('Session Duration', 'babarida-dive'), 'min_participants' => __('Min Participants', 'babarida-dive'), 'max_participants' => __('Max Participants', 'babarida-dive'), 'difficulty' => __('Difficulty', 'babarida-dive'), 'includes' => __('Includes (comma separated)', 'babarida-dive'));
    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">';
    foreach ($fields as $key => $label) {
        $val = get_post_meta($post->ID, $key, true);
        echo '<div><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html($label) . '</label>';
        echo '<input type="text" name="' . esc_attr($key) . '" value="' . esc_attr($val) . '" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;"></div>';
    }
    echo '</div>';
}

function bdc_save_watersport($post_id) {
    if (!isset($_POST['bdc_ws_nonce_field']) || !wp_verify_nonce($_POST['bdc_ws_nonce_field'], 'bdc_ws_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    $fields = array('price_usd', 'duration', 'min_participants', 'max_participants', 'difficulty');
    foreach ($fields as $f) { if (isset($_POST[$f])) update_post_meta($post_id, $f, sanitize_text_field($_POST[$f])); }
    if (isset($_POST['includes'])) update_post_meta($post_id, 'includes', array_map('sanitize_text_field', explode(',', $_POST['includes'])));
}
add_action('save_post_bdc_watersport', 'bdc_save_watersport');
