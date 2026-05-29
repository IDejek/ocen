<?php
defined('ABSPATH') || exit;

function bdc_register_testimonial() {
    register_post_type('bdc_testimonial', array(
        'labels'       => array('name' => __('Testimonials', 'babarida-dive'), 'singular_name' => __('Testimonial', 'babarida-dive'), 'add_new_item' => __('Add New Testimonial', 'babarida-dive')),
        'public'       => true,
        'has_archive'  => false,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-format-quote',
        'supports'     => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'rewrite'      => array('slug' => 'testimonials'),
    ));
}
add_action('init', 'bdc_register_testimonial');

function bdc_testimonial_meta() {
    add_meta_box('bdc_testimonial_details', __('Testimonial Details', 'babarida-dive'), 'bdc_testimonial_details_cb', 'bdc_testimonial', 'normal', 'high');
}
add_action('add_meta_boxes', 'bdc_testimonial_meta');

function bdc_testimonial_details_cb($post) {
    wp_nonce_field('bdc_test_nonce', 'bdc_test_nonce_field');
    $rating  = get_post_meta($post->ID, 'rating', true);
    $country = get_post_meta($post->ID, 'country', true);
    $trip    = get_post_meta($post->ID, 'trip_type', true);
    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">';
    echo '<div><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html__('Rating (1-5)', 'babarida-dive') . '</label>';
    echo '<select name="rating" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;">';
    for ($i = 5; $i >= 1; $i--) echo '<option value="' . $i . '"' . selected($rating, $i, false) . '>' . $i . ' ★</option>';
    echo '</select></div>';
    echo '<div><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html__('Country', 'babarida-dive') . '</label>';
    echo '<input type="text" name="country" value="' . esc_attr($country) . '" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;"></div>';
    echo '<div><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html__('Trip Type', 'babarida-dive') . '</label>';
    echo '<input type="text" name="trip_type" value="' . esc_attr($trip) . '" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;"></div>';
    echo '</div>';
}

function bdc_save_testimonial($post_id) {
    if (!isset($_POST['bdc_test_nonce_field']) || !wp_verify_nonce($_POST['bdc_test_nonce_field'], 'bdc_test_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['rating'])) update_post_meta($post_id, 'rating', intval($_POST['rating']));
    if (isset($_POST['country'])) update_post_meta($post_id, 'country', sanitize_text_field($_POST['country']));
    if (isset($_POST['trip_type'])) update_post_meta($post_id, 'trip_type', sanitize_text_field($_POST['trip_type']));
}
add_action('save_post_bdc_testimonial', 'bdc_save_testimonial');
