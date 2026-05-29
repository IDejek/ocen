<?php
/**
 * CPT: Trips + Shared Taxonomies
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

// Shared Taxonomies (used by trips, liveaboards, courses, watersports)
function bdc_register_taxonomies() {
    // Destination Taxonomy
    register_taxonomy('bdc_destination', array('bdc_trip', 'bdc_liveaboard', 'bdc_course', 'bdc_watersport'), array(
        'labels'        => array('name' => __('Destinations', 'babarida-dive'), 'singular_name' => __('Destination', 'babarida-dive')),
        'hierarchical'  => true,
        'public'        => true,
        'show_in_rest'  => true,
        'rewrite'       => array('slug' => 'destination'),
    ));

    // Activity Taxonomy
    register_taxonomy('bdc_activity', array('bdc_trip', 'bdc_liveaboard', 'bdc_watersport'), array(
        'labels'        => array('name' => __('Activities', 'babarida-dive'), 'singular_name' => __('Activity', 'babarida-dive')),
        'hierarchical'  => false,
        'public'        => true,
        'show_in_rest'  => true,
        'rewrite'       => array('slug' => 'activity'),
    ));

    // Certification Level Taxonomy
    register_taxonomy('bdc_cert_level', 'bdc_course', array(
        'labels'        => array('name' => __('Certification Levels', 'babarida-dive'), 'singular_name' => __('Level', 'babarida-dive')),
        'hierarchical'  => true,
        'public'        => true,
        'show_in_rest'  => true,
        'rewrite'       => array('slug' => 'cert-level'),
    ));
}
add_action('init', 'bdc_register_taxonomies');

// Trip CPT
function bdc_register_trip() {
    register_post_type('bdc_trip', array(
        'labels'       => array('name' => __('Trips', 'babarida-dive'), 'singular_name' => __('Trip', 'babarida-dive'), 'add_new_item' => __('Add New Trip', 'babarida-dive'), 'all_items' => __('All Trips', 'babarida-dive')),
        'public'       => true,
        'has_archive'  => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-clipboard',
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'),
        'rewrite'      => array('slug' => 'trips'),
    ));
}
add_action('init', 'bdc_register_trip');

function bdc_trip_meta() {
    add_meta_box('bdc_trip_details', __('Trip Details', 'babarida-dive'), 'bdc_trip_details_cb', 'bdc_trip', 'normal', 'high');
    add_meta_box('bdc_trip_itinerary', __('Itinerary', 'babarida-dive'), 'bdc_trip_itinerary_cb', 'bdc_trip', 'normal', 'high');
    add_meta_box('bdc_trip_gallery', __('Photo Gallery', 'babarida-dive'), 'bdc_trip_gallery_cb', 'bdc_trip', 'side', 'high');
}
add_action('add_meta_boxes', 'bdc_trip_meta');

function bdc_trip_details_cb($post) {
    wp_nonce_field('bdc_trip_nonce', 'bdc_trip_nonce_field');
    $fields = array(
        'price_usd'   => __('Price (USD)', 'babarida-dive'),
        'duration'    => __('Duration (e.g. 3 Days / 2 Nights)', 'babarida-dive'),
        'group_size'  => __('Group Size (e.g. 2-8)', 'babarida-dive'),
        'difficulty'  => __('Difficulty (Beginner/Intermediate/Advanced)', 'babarida-dive'),
        'includes'    => __('Includes (comma separated)', 'babarida-dive'),
        'excludes'    => __('Excludes (comma separated)', 'babarida-dive'),
        'badge_text'  => __('Badge Text (e.g. Popular, New)', 'babarida-dive'),
    );
    echo '<div class="bdc-meta-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">';
    foreach ($fields as $key => $label) {
        $val = get_post_meta($post->ID, $key, true);
        echo '<div><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html($label) . '</label>';
        echo '<input type="text" name="' . esc_attr($key) . '" value="' . esc_attr($val) . '" style="width:100%;padding:8px 12px;border:1px solid #ddd;border-radius:4px;"></div>';
    }
    echo '</div>';
}

function bdc_trip_itinerary_cb($post) {
    $itinerary = get_post_meta($post->ID, 'itinerary', true);
    echo '<div id="itinerary-repeater">';
    if ($itinerary && is_array($itinerary)) {
        foreach ($itinerary as $i => $day) {
            echo '<div class="itinerary-row" style="margin-bottom:12px;padding:16px;background:#f9f9f9;border-radius:8px;">';
            echo '<input type="text" name="itinerary[' . $i . '][title]" value="' . esc_attr($day['title'] ?? '') . '" placeholder="Day Title" style="width:100%;padding:8px;margin-bottom:8px;border:1px solid #ddd;border-radius:4px;">';
            echo '<textarea name="itinerary[' . $i . '][description]" rows="2" placeholder="Description" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;">' . esc_textarea($day['description'] ?? '') . '</textarea>';
            echo '<button type="button" class="button remove-itinerary" style="margin-top:8px;color:#dc2626;">Remove</button>';
            echo '</div>';
        }
    }
    echo '</div>';
    echo '<button type="button" class="button" id="add-itinerary" style="margin-top:8px;">+ Add Day</button>';
    echo '<script>
    jQuery(document).ready(function($){
        $("#add-itinerary").click(function(){
            var idx = $(".itinerary-row").length;
            var html = \'<div class="itinerary-row" style="margin-bottom:12px;padding:16px;background:#f9f9f9;border-radius:8px;"><input type="text" name="itinerary[\'+idx+\'][title]" value="" placeholder="Day Title" style="width:100%;padding:8px;margin-bottom:8px;border:1px solid #ddd;border-radius:4px;"><textarea name="itinerary[\'+idx+\'][description]" rows="2" placeholder="Description" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;"></textarea><button type="button" class="button remove-itinerary" style="margin-top:8px;color:#dc2626;">Remove</button></div>\';
            $("#itinerary-repeater").append(html);
        });
        $(document).on("click",".remove-itinerary",function(){$(this).closest(".itinerary-row").remove();});
    });
    </script>';
}

function bdc_trip_gallery_cb($post) {
    $gallery = get_post_meta($post->ID, 'gallery', true);
    echo '<div id="gallery-preview">';
    if ($gallery && is_array($gallery)) {
        foreach ($gallery as $img_id) {
            echo '<div style="margin-bottom:8px;">' . wp_get_attachment_image($img_id, 'thumbnail') . '<button type="button" class="button remove-gallery" data-id="' . $img_id . '" style="margin-left:8px;color:#dc2626;">×</button></div>';
        }
    }
    echo '</div>';
    echo '<button type="button" class="button" id="add-gallery-images">+ Add Images</button>';
    echo '<input type="hidden" name="gallery_ids" id="gallery-ids" value="' . esc_attr(implode(',', $gallery ?? array())) . '">';
    echo '<script>
    jQuery(document).ready(function($){
        var frame;
        $("#add-gallery-images").click(function(e){
            e.preventDefault();
            if(frame){frame.open();return;}
            frame=wp.media({title:"Select Images",multiple:true,button:{text:"Add to Gallery"}});
            frame.on("select",function(){
                var ids=$("#gallery-ids").val()?$("#gallery-ids").val().split(","):[];
                frame.state().get("selection").each(function(a){ids.push(a.id);});
                $("#gallery-ids").val(ids.join(","));
                $("#gallery-preview").load(ajaxurl+"?action=bdc_refresh_gallery&ids="+ids.join(",")+"&nonce=' . wp_create_nonce('bdc_admin_nonce') . '");
            });
            frame.open();
        });
        $(document).on("click",".remove-gallery",function(){
            var id=$(this).data("id");
            var ids=$("#gallery-ids").val().split(",").filter(function(i){return i!=id;});
            $("#gallery-ids").val(ids.join(","));
            $(this).parent().remove();
        });
    });
    </script>';
}

function bdc_save_trip($post_id) {
    if (!isset($_POST['bdc_trip_nonce_field']) || !wp_verify_nonce($_POST['bdc_trip_nonce_field'], 'bdc_trip_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    $fields = array('price_usd', 'duration', 'group_size', 'difficulty', 'badge_text');
    foreach ($fields as $f) {
        if (isset($_POST[$f])) update_post_meta($post_id, $f, sanitize_text_field($_POST[$f]));
    }
    // Array fields
    foreach (array('includes', 'excludes') as $f) {
        if (isset($_POST[$f])) update_post_meta($post_id, $f, array_map('sanitize_text_field', explode(',', $_POST[$f])));
    }
    // Itinerary
    if (isset($_POST['itinerary']) && is_array($_POST['itinerary'])) {
        $itinerary = array();
        foreach ($_POST['itinerary'] as $day) {
            if (!empty($day['title'])) $itinerary[] = array('title' => sanitize_text_field($day['title']), 'description' => sanitize_textarea_field($day['description']));
        }
        update_post_meta($post_id, 'itinerary', $itinerary);
    }
    // Gallery
    if (isset($_POST['gallery_ids'])) {
        $ids = array_filter(array_map('intval', explode(',', sanitize_text_field($_POST['gallery_ids']))));
        update_post_meta($post_id, 'gallery', $ids);
    }
}
add_action('save_post_bdc_trip', 'bdc_save_trip');

// AJAX gallery refresh for admin
add_action('wp_ajax_bdc_refresh_gallery', function() {
    check_ajax_referer('bdc_admin_nonce', 'nonce');
    $ids = explode(',', sanitize_text_field($_GET['ids'] ?? ''));
    foreach (array_filter($ids) as $id) {
        echo '<div style="margin-bottom:8px;display:inline-block;margin-right:8px;">' . wp_get_attachment_image($id, 'thumbnail') . '</div>';
    }
    wp_die();
});
