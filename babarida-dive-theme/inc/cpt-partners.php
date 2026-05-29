<?php
defined('ABSPATH') || exit;

function bdc_register_partner() {
    register_post_type('bdc_partner', array(
        'labels'       => array('name' => __('Partners', 'babarida-dive'), 'singular_name' => __('Partner', 'babarida-dive'), 'add_new_item' => __('Add New Partner', 'babarida-dive')),
        'public'       => true,
        'has_archive'  => false,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-handshake',
        'supports'     => array('title', 'thumbnail', 'page-attributes'),
        'rewrite'      => false,
    ));
}
add_action('init', 'bdc_register_partner');

function bdc_partner_meta() {
    add_meta_box('bdc_partner_details', __('Partner Details', 'babarida-dive'), 'bdc_partner_details_cb', 'bdc_partner', 'normal', 'high');
}
add_action('add_meta_boxes', 'bdc_partner_meta');

function bdc_partner_details_cb($post) {
    wp_nonce_field('bdc_partner_nonce', 'bdc_partner_nonce_field');
    $url = get_post_meta($post->ID, 'partner_url', true);
    echo '<label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html__('Partner URL', 'babarida-dive') . '</label>';
    echo '<input type="url" name="partner_url" value="' . esc_attr($url) . '" style="width:100%;padding:8px 12px;border:1px solid #ddd;border-radius:4px;">';
}

function bdc_save_partner($post_id) {
    if (!isset($_POST['bdc_partner_nonce_field']) || !wp_verify_nonce($_POST['bdc_partner_nonce_field'], 'bdc_partner_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['partner_url'])) update_post_meta($post_id, 'partner_url', esc_url_raw($_POST['partner_url']));
}
add_action('save_post_bdc_partner', 'bdc_save_partner');
