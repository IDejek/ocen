<?php
/**
 * CPT: Destinations (simple version - taxonomy registered in cpt-trips.php)
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

function bdc_register_destination() {
    register_post_type('bdc_destination', array(
        'labels'             => array(
            'name'               => __('Destinations', 'babarida-dive'),
            'singular_name'      => __('Destination', 'babarida-dive'),
            'menu_name'          => __('Destinations', 'babarida-dive'),
            'add_new_item'       => __('Add New Destination', 'babarida-dive'),
            'edit_item'          => __('Edit Destination', 'babarida-dive'),
            'all_items'          => __('All Destinations', 'babarida-dive'),
            'search_items'       => __('Search Destinations', 'babarida-dive'),
            'not_found'          => __('No destinations found.', 'babarida-dive'),
        ),
        'public'             => true,
        'has_archive'        => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-location-alt',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
        'rewrite'            => array('slug' => 'destinations'),
        'capability_type'    => 'post',
    ));
}
add_action('init', 'bdc_register_destination');

// Meta Boxes
function bdc_destination_meta() {
    add_meta_box('bdc_dest_details', __('Destination Details', 'babarida-dive'), 'bdc_dest_details_cb', 'bdc_destination', 'normal', 'high');
}
add_action('add_meta_boxes', 'bdc_destination_meta');

function bdc_dest_details_cb($post) {
    wp_nonce_field('bdc_dest_nonce', 'bdc_dest_nonce_field');
    $fields = array(
        'dive_sites_count' => __('Number of Dive Sites', 'babarida-dive'),
        'depth_range'      => __('Depth Range (e.g. 5-40m)', 'babarida-dive'),
        'visibility'       => __('Average Visibility (e.g. 15-30m)', 'babarida-dive'),
        'water_temp'       => __('Water Temperature Range (e.g. 27-30°C)', 'babarida-dive'),
        'best_season'      => __('Best Season', 'babarida-dive'),
        'travel_time'      => __('Travel Time from Manado (e.g. 45 min)', 'babarida-dive'),
        'latitude'         => __('Latitude', 'babarida-dive'),
        'longitude'        => __('Longitude', 'babarida-dive'),
    );
    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">';
    foreach ($fields as $key => $label) {
        $val = get_post_meta($post->ID, $key, true);
        echo '<div>';
        echo '<label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html($label) . '</label>';
        echo '<input type="text" name="' . esc_attr($key) . '" value="' . esc_attr($val) . '" style="width:100%;padding:8px 12px;border:1px solid #ddd;border-radius:4px;">';
        echo '</div>';
    }
    echo '</div>';
}

function bdc_save_destination($post_id) {
    if (!isset($_POST['bdc_dest_nonce_field'])) return;
    if (!wp_verify_nonce($_POST['bdc_dest_nonce_field'], 'bdc_dest_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = array('dive_sites_count', 'depth_range', 'visibility', 'water_temp', 'best_season', 'travel_time', 'latitude', 'longitude');
    foreach ($fields as $f) {
        if (isset($_POST[$f])) {
            update_post_meta($post_id, $f, sanitize_text_field($_POST[$f]));
        }
    }
}
add_action('save_post_bdc_destination', 'bdc_save_destination');
