<?php
defined('ABSPATH') || exit;

function bdc_register_course() {
    register_post_type('bdc_course', array(
        'labels'       => array('name' => __('Dive Courses', 'babarida-dive'), 'singular_name' => __('Dive Course', 'babarida-dive'), 'add_new_item' => __('Add New Course', 'babarida-dive'), 'all_items' => __('All Courses', 'babarida-dive')),
        'public'       => true,
        'has_archive'  => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-awards',
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'),
        'rewrite'      => array('slug' => 'dive-courses'),
    ));
}
add_action('init', 'bdc_register_course');

function bdc_course_meta() {
    add_meta_box('bdc_course_details', __('Course Details', 'babarida-dive'), 'bdc_course_details_cb', 'bdc_course', 'normal', 'high');
}
add_action('add_meta_boxes', 'bdc_course_meta');

function bdc_course_details_cb($post) {
    wp_nonce_field('bdc_course_nonce', 'bdc_course_nonce_field');
    $fields = array('price_usd' => __('Price (USD)', 'babarida-dive'), 'duration' => __('Duration (e.g. 3 Days)', 'babarida-dive'), 'max_depth' => __('Max Depth', 'babarida-dive'), 'min_age' => __('Minimum Age', 'babarida-dive'), 'certification' => __('Certification Organization (e.g. SSI)', 'babarida-dive'), 'prerequisites' => __('Prerequisites (comma separated)', 'babarida-dive'), 'includes' => __('Includes (comma separated)', 'babarida-dive'));
    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">';
    foreach ($fields as $key => $label) {
        $val = get_post_meta($post->ID, $key, true);
        echo '<div><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html($label) . '</label>';
        echo '<input type="text" name="' . esc_attr($key) . '" value="' . esc_attr($val) . '" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;"></div>';
    }
    echo '</div>';
}

function bdc_save_course($post_id) {
    if (!isset($_POST['bdc_course_nonce_field']) || !wp_verify_nonce($_POST['bdc_course_nonce_field'], 'bdc_course_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    $fields = array('price_usd', 'duration', 'max_depth', 'min_age', 'certification');
    foreach ($fields as $f) { if (isset($_POST[$f])) update_post_meta($post_id, $f, sanitize_text_field($_POST[$f])); }
    foreach (array('prerequisites', 'includes') as $f) { if (isset($_POST[$f])) update_post_meta($post_id, $f, array_map('sanitize_text_field', explode(',', $_POST[$f]))); }
}
add_action('save_post_bdc_course', 'bdc_save_course');
