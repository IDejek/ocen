<?php
defined('ABSPATH') || exit;

class BDC_Newsletter {

    public static function init() {
        register_post_type('bdc_newsletter_sub', array(
            'public'       => false,
            'show_ui'      => true,
            'show_in_menu' => 'bdc-dashboard',
            'labels'       => array('name' => __('Subscribers', 'babarida-dive'), 'singular_name' => __('Subscriber', 'babarida-dive'), 'all_items' => __('Newsletter Subscribers', 'babarida-dive')),
            'supports'     => array('title'),
        ));
    }

    public static function get_subscriber_count() {
        return count(get_posts(array('post_type' => 'bdc_newsletter_sub', 'posts_per_page' => -1, 'fields' => 'ids')));
    }

    public static function send_campaign($subject, $body, $test = false) {
        $args = array('post_type' => 'bdc_newsletter_sub', 'posts_per_page' => $test ? 1 : -1, 'fields' => 'ids');
        $ids = get_posts($args);
        $sent = 0;
        foreach ($ids as $id) {
            $email = get_post_meta($id, 'subscriber_email', true);
            if ($email && is_email($email)) {
                BDC_Notification_System::send_email($email, $subject, BDC_Notification_System::build_email_template($subject, $body));
                $sent++;
            }
        }
        return $sent;
    }
}
BDC_Newsletter::init();
