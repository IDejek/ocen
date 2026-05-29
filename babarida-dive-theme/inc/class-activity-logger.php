<?php
defined('ABSPATH') || exit;

class BDC_Activity_Logger {

    public static function log($action, $details = '', $user_id = 0) {
        if (!$user_id) $user_id = get_current_user_id();
        wp_insert_post(array(
            'post_title'  => $action,
            'post_type'   => 'bdc_activity',
            'post_status' => 'publish',
            'meta_input'  => array(
                'action'     => sanitize_text_field($action),
                'details'    => sanitize_textarea_field($details),
                'user_id'    => $user_id,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
                'timestamp'  => current_time('mysql'),
            ),
        ));
    }

    public static function get_logs($args = array()) {
        $defaults = array('post_type' => 'bdc_activity', 'posts_per_page' => 50, 'orderby' => 'date', 'order' => 'DESC');
        return get_posts(array_merge($defaults, $args));
    }

    public static function init() {
        // Register hidden CPT for logs
        register_post_type('bdc_activity', array(
            'public'       => false,
            'show_ui'      => false,
            'supports'     => array('title'),
            'capabilities' => array('create_posts' => 'manage_options'),
        ));
    }
}
add_action('init', array('BDC_Activity_Logger', 'init'));
