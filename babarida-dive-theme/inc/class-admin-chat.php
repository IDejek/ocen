<?php
defined('ABSPATH') || exit;

class BDC_Admin_Chat {

    public static function init() {
        register_post_type('bdc_chat_message', array(
            'public'       => false,
            'show_ui'      => false,
            'supports'     => array('title'),
        ));
        add_action('wp_ajax_bdc_send_chat', array(__CLASS__, 'send_message'));
        add_action('wp_ajax_bdc_get_chat', array(__CLASS__, 'get_messages'));
    }

    public static function send_message() {
        check_ajax_referer('bdc_admin_nonce', 'nonce');
        wp_insert_post(array(
            'post_title'  => 'Chat',
            'post_type'   => 'bdc_chat_message',
            'post_status' => 'publish',
            'meta_input'  => array(
                'sender_id'   => get_current_user_id(),
                'message'     => sanitize_textarea_field($_POST['message'] ?? ''),
                'room'        => sanitize_text_field($_POST['room'] ?? 'general'),
                'sent_at'     => current_time('mysql'),
            ),
        ));
        wp_send_json_success();
    }

    public static function get_messages() {
        check_ajax_referer('bdc_admin_nonce', 'nonce');
        $room = sanitize_text_field($_POST['room'] ?? 'general');
        $messages = get_posts(array(
            'post_type'   => 'bdc_chat_message',
            'meta_key'    => 'room',
            'meta_value'  => $room,
            'posts_per_page' => 50,
            'orderby'     => 'date',
            'order'       => 'ASC',
        ));
        $data = array();
        foreach ($messages as $m) {
            $user = get_user_by('id', get_post_meta($m->ID, 'sender_id', true));
            $data[] = array(
                'sender'  => $user ? $user->display_name : 'Unknown',
                'message' => get_post_meta($m->ID, 'message', true),
                'time'    => get_post_meta($m->ID, 'sent_at', true),
                'is_me'   => get_post_meta($m->ID, 'sender_id', true) == get_current_user_id(),
            );
        }
        wp_send_json_success($data);
    }
}
BDC_Admin_Chat::init();
