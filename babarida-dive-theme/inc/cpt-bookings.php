<?php
defined('ABSPATH') || exit;

function bdc_register_booking() {
    register_post_type('bdc_booking', array(
        'labels'       => array('name' => __('Bookings', 'babarida-dive'), 'singular_name' => __('Booking', 'babarida-dive'), 'add_new_item' => __('Add New Booking', 'babarida-dive'), 'all_items' => __('All Bookings', 'babarida-dive')),
        'public'       => false,
        'show_ui'      => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-calendar-alt',
        'supports'     => array('title', 'custom-fields'),
        'capability_type' => 'bdc_booking',
        'map_meta_cap'   => true,
    ));
}
add_action('init', 'bdc_register_booking');

function bdc_booking_meta() {
    add_meta_box('bdc_booking_details', __('Booking Details', 'babarida-dive'), 'bdc_booking_details_cb', 'bdc_booking', 'normal', 'high');
    add_meta_box('bdc_booking_actions', __('Booking Actions', 'babarida-dive'), 'bdc_booking_actions_cb', 'bdc_booking', 'side', 'high');
}
add_action('add_meta_boxes', 'bdc_booking_meta');

function bdc_booking_details_cb($post) {
    $fields = array(
        'name'        => __('Guest Name', 'babarida-dive'),
        'email'       => __('Email', 'babarida-dive'),
        'phone'       => __('Phone', 'babarida-dive'),
        'nationality' => __('Nationality', 'babarida-dive'),
        'trip_type'   => __('Trip Type', 'babarida-dive'),
        'trip_id'     => __('Trip Post ID', 'babarida-dive'),
        'date'        => __('Preferred Date', 'babarida-dive'),
        'guests'      => __('Number of Guests', 'babarida-dive'),
        'message'     => __('Special Requests', 'babarida-dive'),
        'status'      => __('Status', 'babarida-dive'),
        'total_price' => __('Total Price (USD)', 'babarida-dive'),
        'paid_amount' => __('Paid Amount (USD)', 'babarida-dive'),
        'payment_method' => __('Payment Method', 'babarida-dive'),
        'payment_id'  => __('Payment Transaction ID', 'babarida-dive'),
        'assigned_guide' => __('Assigned Dive Guide', 'babarida-dive'),
        'assigned_boat'  => __('Assigned Boat', 'babarida-dive'),
        'passport_number' => __('Passport Number', 'babarida-dive'),
        'passport_expiry' => __('Passport Expiry', 'babarida-dive'),
        'hotel_pickup' => __('Hotel Pickup Location', 'babarida-dive'),
        'certification_level' => __('Certification Level', 'babarida-dive'),
        'dives_count' => __('Total Dives', 'babarida-dive'),
        'qr_code'     => __('QR Code Data', 'babarida-dive'),
    );
    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">';
    foreach ($fields as $key => $label) {
        $val = get_post_meta($post->ID, $key, true);
        if ($key === 'status') {
            $statuses = array('pending', 'confirmed', 'paid', 'checked-in', 'completed', 'cancelled');
            echo '<div><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html($label) . '</label>';
            echo '<select name="' . esc_attr($key) . '" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;">';
            foreach ($statuses as $s) echo '<option value="' . $s . '"' . selected($val, $s, false) . '>' . ucfirst($s) . '</option>';
            echo '</select></div>';
        } elseif ($key === 'message') {
            echo '<div style="grid-column:1/-1;"><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html($label) . '</label>';
            echo '<textarea name="' . esc_attr($key) . '" rows="3" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;">' . esc_textarea($val) . '</textarea></div>';
        } else {
            echo '<div><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html($label) . '</label>';
            echo '<input type="text" name="' . esc_attr($key) . '" value="' . esc_attr($val) . '" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px;"></div>';
        }
    }
    echo '</div>';
}

function bdc_booking_actions_cb($post) {
    $status = get_post_meta($post->ID, 'status', true);
    echo '<div style="display:flex;flex-direction:column;gap:8px;">';
    echo '<button type="button" class="button" onclick="bdcChangeStatus(\'confirmed\')">' . esc_html__('Confirm', 'babarida-dive') . '</button>';
    echo '<button type="button" class="button" onclick="bdcChangeStatus(\'paid\')">' . esc_html__('Mark Paid', 'babarida-dive') . '</button>';
    echo '<button type="button" class="button" onclick="bdcChangeStatus(\'checked-in\')">' . esc_html__('Check-In', 'babarida-dive') . '</button>';
    echo '<button type="button" class="button" onclick="bdcChangeStatus(\'completed\')">' . esc_html__('Complete', 'babarida-dive') . '</button>';
    echo '<button type="button" class="button" style="color:#dc2626;" onclick="bdcChangeStatus(\'cancelled\')">' . esc_html__('Cancel', 'babarida-dive') . '</button>';
    echo '<hr>';
    echo '<button type="button" class="button" id="send-booking-email">' . esc_html__('Send Email', 'babarida-dive') . '</button>';
    echo '<button type="button" class="button" id="send-booking-wa">' . esc_html__('Send WhatsApp', 'babarida-dive') . '</button>';
    echo '<button type="button" class="button" id="print-booking">' . esc_html__('Print', 'babarida-dive') . '</button>';
    echo '</div>';
}

function bdc_save_booking($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    $fields = array('name', 'email', 'phone', 'nationality', 'trip_type', 'trip_id', 'date', 'guests', 'message', 'status', 'total_price', 'paid_amount', 'payment_method', 'payment_id', 'assigned_guide', 'assigned_boat', 'passport_number', 'passport_expiry', 'hotel_pickup', 'certification_level', 'dives_count', 'qr_code');
    foreach ($fields as $f) {
        if (isset($_POST[$f])) {
            $val = in_array($f, array('guests', 'trip_id', 'dives_count')) ? intval($_POST[$f]) : sanitize_text_field($_POST[$f]);
            update_post_meta($post_id, $f, $val);
        }
    }
    // Generate QR if new booking
    if (!get_post_meta($post_id, 'qr_code', true)) {
        update_post_meta($post_id, 'qr_code', 'BDC-' . $post_id . '-' . strtoupper(substr(md5($post_id . time()), 0, 8)));
    }
}
add_action('save_post_bdc_booking', 'bdc_save_booking');

// AJAX status change
add_action('wp_ajax_bdc_change_booking_status', function() {
    check_ajax_referer('bdc_admin_nonce', 'nonce');
    $id = intval($_POST['booking_id'] ?? 0);
    $status = sanitize_text_field($_POST['status'] ?? '');
    if ($id && $status) {
        update_post_meta($id, 'status', $status);
        wp_send_json_success(array('status' => $status));
    }
    wp_send_json_error();
});
