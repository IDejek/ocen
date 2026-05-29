<?php
defined('ABSPATH') || exit;

class BDC_Social_Sync {

    public static function auto_publish($post_id, $post) {
        if (wp_is_post_revision($post_id)) return;
        if (!in_array($post->post_type, array('bdc_trip', 'bdc_liveaboard', 'post'))) return;

        $title = get_the_title($post_id);
        $url = get_permalink($post_id);
        $excerpt = wp_trim_words($post->post_content, 20);
        $message = "🤿 {$title}\n\n{$excerpt}\n\n🔗 {$url}\n\n#BabaridaDive #NorthSulawesi #DivingIndonesia";

        // Store for manual review (actual API posting would need OAuth tokens)
        update_post_meta($post_id, '_social_pending', array(
            'message'    => $message,
            'platforms'  => array('instagram', 'facebook', 'tiktok'),
            'created_at' => current_time('mysql'),
            'status'     => 'pending_review',
        ));
    }
}
add_action('publish_post', array('BDC_Social_Sync', 'auto_publish'), 10, 2);
add_action('publish_bdc_trip', array('BDC_Social_Sync', 'auto_publish'), 10, 2);
add_action('publish_bdc_liveaboard', array('BDC_Social_Sync', 'auto_publish'), 10, 2);
