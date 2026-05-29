<?php
/**
 * Newsletter System
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

class BDC_Newsletter {

    /**
     * Register the subscriber CPT
     */
    public static function register_cpt() {
        register_post_type('bdc_newsletter_sub', array(
            'public'       => false,
            'show_ui'      => true,
            'show_in_menu' => 'bdc-dashboard',
            'labels'       => array(
                'name'               => __('Subscribers', 'babarida-dive'),
                'singular_name'      => __('Subscriber', 'babarida-dive'),
                'all_items'          => __('Newsletter Subscribers', 'babarida-dive'),
                'add_new_item'       => __('Add Subscriber', 'babarida-dive'),
            ),
            'supports'     => array('title'),
        ));
    }

    /**
     * Get total subscriber count
     */
    public static function get_subscriber_count() {
        global $wpdb;
        return (int) $wpdb->get_var(
            "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'bdc_newsletter_sub' AND post_status = 'publish'"
        );
    }

    /**
     * Send campaign to all subscribers
     */
    public static function send_campaign($subject, $body, $test = false) {
        $limit = $test ? 1 : -1;
        $ids = get_posts(array(
            'post_type'      => 'bdc_newsletter_sub',
            'posts_per_page' => $limit,
            'fields'         => 'ids',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));

        if (empty($ids)) return 0;

        $sent = 0;
        foreach ($ids as $id) {
            $email = get_post_meta($id, 'subscriber_email', true);
            if ($email && is_email($email)) {
                $html = BDC_Notification_System::build_email_template_protected($subject, $body);
                $result = BDC_Notification_System::send_email($email, $subject, $html);
                if ($result) $sent++;
            }
        }
        return $sent;
    }
}

// Register late to avoid conflicts
add_action('init', array('BDC_Newsletter', 'register_cpt'), 99);
