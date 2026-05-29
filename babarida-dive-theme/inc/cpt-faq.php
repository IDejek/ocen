<?php
defined('ABSPATH') || exit;

function bdc_register_faq() {
    register_post_type('bdc_faq', array(
        'labels'       => array('name' => __('FAQs', 'babarida-dive'), 'singular_name' => __('FAQ', 'babarida-dive'), 'add_new_item' => __('Add New FAQ', 'babarida-dive'), 'all_items' => __('All FAQs', 'babarida-dive')),
        'public'       => true,
        'has_archive'  => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-editor-help',
        'supports'     => array('title', 'editor', 'custom-fields', 'page-attributes'),
        'rewrite'      => array('slug' => 'faq'),
    ));
}
add_action('init', 'bdc_register_faq');
