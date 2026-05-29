<?php
defined('ABSPATH') || exit;

function bdc_register_liveaboard() {
    register_post_type('bdc_liveaboard', array(
        'labels'       => array('name' => __('Liveaboards', 'babarida-dive'), 'singular_name' => __('Liveaboard', 'babarida-dive'), 'add_new_item' => __('Add New Liveaboard', 'babarida-dive'), 'all_items' => __('All Liveaboards', 'babarida-dive')),
        'public'       => true,
        'has_archive'  => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-sailboat',
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'),
        'rewrite'      => array('slug' => 'liveaboards'),
    ));
}
add_action('init', 'bdc_register_liveaboard');

function bdc_liveaboard_meta() {
    add_meta_box('bdc_boat_specs', __('Boat Specifications', 'babarida-dive'), 'bdc_boat_specs_cb', 'bdc_liveaboard', 'normal', 'high');
    add_meta_box('bdc_boat_gallery', __('Photo Gallery', 'babarida-dive'), 'bdc_boat_gallery_cb', 'bdc_liveaboard', 'side', 'high');
}
add_action('add_meta_boxes', 'bdc_liveaboard_meta');

function bdc_boat_specs_cb($post) {
    wp_nonce_field('bdc_boat_nonce', 'bdc_boat_nonce_field');
    $fields = array(
        'price_usd'     => __('Price per Night (USD)', 'babarida-dive'),
        'cabins'        => __('Number of Cabins', 'babarida-dive'),
        'max_guests'    => __('Maximum Guests', 'babarida-dive'),
        'boat_length'   => __('Boat Length (meters)', 'babarida-dive'),
        'boat_width'    => __('Boat Width (meters)', 'babarida-dive'),
        'year_built'    => __('Year Built', 'babarida-dive'),
        'engine'        => __('Engine', 'babarida-dive'),
        'speed'         => __('Cruising Speed (knots)', 'babarida-dive'),
        'route'         => __('Default Route', 'babarida-dive'),
        'includes'      => __('Includes (comma separated)', 'babarida-dive'),
        'excludes'      => __('Excludes (comma separated)', 'babarida-dive'),
    );
    echo '<div class="bdc-meta-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">';
    foreach ($fields as $key => $label) {
        $val = get_post_meta($post->ID, $key, true);
        echo '<div><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html($label) . '</label>';
        echo '<input type="text" name="' . esc_attr($key) . '" value="' . esc_attr($val) . '" style="width:100%;padding:8px 12px;border:1px solid #ddd;border-radius:4px;"></div>';
    }
    echo '</div>';
}

function bdc_boat_gallery_cb($post) {
    $gallery = get_post_meta($post->ID, 'gallery', true);
    echo '<div id="boat-gallery-preview">';
    if ($gallery && is_array($gallery)) {
        foreach ($gallery as $img_id) {
            echo '<div style="margin-bottom:8px;">' . wp_get_attachment_image($img_id, 'thumbnail') . '</div>';
        }
    }
    echo '</div>';
    echo '<button type="button" class="button" id="add-boat-gallery">+ Add Photos</button>';
    echo '<input type="hidden" name="boat_gallery_ids" id="boat-gallery-ids" value="' . esc_attr(implode(',', $gallery ?? array())) . '">';
    echo '<script>
    jQuery(document).ready(function($){
        var frame;
        $("#add-boat-gallery").click(function(e){
            e.preventDefault();
            if(frame){frame.open();return;}
            frame=wp.media({title:"Select Boat Photos",multiple:true,button:{text:"Add"}});
            frame.on("select",function(){
                var ids=$("#boat-gallery-ids").val()?$("#boat-gallery-ids").val().split(","):[];
                frame.state().get("selection").each(function(a){ids.push(a.id);});
                $("#boat-gallery-ids").val(ids.join(","));
                location.reload();
            });
            frame.open();
        });
    });
    </script>';
}

function bdc_save_liveaboard($post_id) {
    if (!isset($_POST['bdc_boat_nonce_field']) || !wp_verify_nonce($_POST['bdc_boat_nonce_field'], 'bdc_boat_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    $fields = array('price_usd', 'cabins', 'max_guests', 'boat_length', 'boat_width', 'year_built', 'engine', 'speed', 'route');
    foreach ($fields as $f) {
        if (isset($_POST[$f])) update_post_meta($post_id, $f, sanitize_text_field($_POST[$f]));
    }
    foreach (array('includes', 'excludes') as $f) {
        if (isset($_POST[$f])) update_post_meta($post_id, $f, array_map('sanitize_text_field', explode(',', $_POST[$f])));
    }
    if (isset($_POST['boat_gallery_ids'])) {
        $ids = array_filter(array_map('intval', explode(',', sanitize_text_field($_POST['boat_gallery_ids']))));
        update_post_meta($post_id, 'gallery', $ids);
    }
}
add_action('save_post_bdc_liveaboard', 'bdc_save_liveaboard');
