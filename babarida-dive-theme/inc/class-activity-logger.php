<?php
/**
 * Activity Logger
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

class BDC_Activity_Logger {

    /**
     * Register the hidden CPT
     */
    public static function register_cpt() {
        register_post_type('bdc_activity', array(
            'public'       => false,
            'show_ui'      => false,
            'supports'     => array('title'),
            'capabilities' => array('create_posts' => 'manage_options'),
        ));
    }

    /**
     * Log an activity
     */
    public static function log($action, $details = '', $user_id = 0) {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }
        // Use wp_insert_post which will work even if CPT isn't registered yet,
        // because WordPress checks post_type against registered types at post_type_exists level
        $result = wp_insert_post(array(
            'post_title'  => substr(sanitize_text_field($action), 0, 200),
            'post_type'   => 'bdc_activity',
            'post_status' => 'publish',
            'meta_input'  => array(
                'action'     => sanitize_text_field($action),
                'details'    => sanitize_textarea_field($details),
                'user_id'    => (int) $user_id,
                'ip_address' => isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field($_SERVER['REMOTE_ADDR']) : '',
                'timestamp'  => current_time('mysql'),
            ),
        ));
        return $result;
    }

    /**
     * Get log entries
     */
    public static function get_logs($args = array()) {
        $defaults = array(
            'post_type'      => 'bdc_activity',
            'posts_per_page' => 50,
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
        return get_posts(array_merge($defaults, $args));
    }
}

// Register on init, AFTER all plugin CPTs are registered
add_action('init', array('BDC_Activity_Logger', 'register_cpt'), 99);
