<?php
/**
 * Babarida Dive Center Theme Functions
 *
 * @package Babarida_Dive
 * @author  Iqbal Tombinawa <tombinawaiqbal@gmail.com>
 * @version 1.0.0
 * @link    https://babaridadive.com
 */

defined('ABSPATH') || exit;

// ============================================================
// THEME CONSTANTS
// ============================================================
define('BDC_VERSION', '1.0.0');
define('BDC_DIR', get_template_directory());
define('BDC_URI', get_template_directory_uri());
define('BDC_INC', BDC_DIR . '/inc/');
define('BDC_ADMIN', BDC_DIR . '/admin/');

// ============================================================
// THEME SETUP
// ============================================================
function bdc_theme_setup() {

    // Title Tag
    add_theme_support('title-tag');

    // Post Thumbnails
    add_theme_support('post-thumbnails');

    // HTML5 Support
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Customizer Selective Refresh
    add_theme_support('customize-selective-refresh-widgets');

    // Responsive Embeds
    add_theme_support('responsive-embeds');

    // Block Editor Support
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');

    // Custom Logo
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Image Sizes
    add_image_size('bdc-hero', 1920, 1080, true);
    add_image_size('bdc-card', 600, 450, true);
    add_image_size('bdc-thumb', 400, 300, true);
    add_image_size('bdc-gallery', 800, 600, true);
    add_image_size('bdc-fullwidth', 1400, 700, true);

    // Navigation Menus
    register_nav_menus(array(
        'primary'    => __('Primary Navigation', 'babarida-dive'),
        'bunaken'    => __('Bunaken Submenu', 'babarida-dive'),
        'siladen'    => __('Siladen Submenu', 'babarida-dive'),
        'bangka'     => __('Bangka Submenu', 'babarida-dive'),
        'lembeh'     => __('Lembeh Submenu', 'babarida-dive'),
        'liveaboard' => __('Liveaboard Submenu', 'babarida-dive'),
        'footer'     => __('Footer Navigation', 'babarida-dive'),
    ));

    // Text Domain
    load_theme_textdomain('babarida-dive', BDC_DIR . '/languages');
}
add_action('after_setup_theme', 'bdc_theme_setup');

// ============================================================
// ENQUEUE SCRIPTS & STYLES
// ============================================================
function bdc_enqueue_assets() {

    // Google Fonts (async load)
    wp_enqueue_style(
        'bdc-google-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap',
        array(),
        null
    );

    // Theme Stylesheet
    wp_enqueue_style('bdc-style', get_stylesheet_uri(), array(), BDC_VERSION);

    // Lucide Icons
    wp_enqueue_script('lucide-icons', 'https://unpkg.com/lucide@latest/dist/umd/lucide.min.js', array(), null, true);

    // Main JS
    wp_enqueue_script('bdc-main', BDC_URI . '/assets/js/main.js', array('lucide-icons'), BDC_VERSION, true);

    // Clock JS
    wp_enqueue_script('bdc-clocks', BDC_URI . '/assets/js/clocks.js', array(), BDC_VERSION, true);

    // Booking JS
    wp_enqueue_script('bdc-booking', BDC_URI . '/assets/js/booking.js', array('bdc-main'), BDC_VERSION, true);

    // Localize Script — Main
    wp_localize_script('bdc-main', 'bdcData', array(
        'ajaxUrl'  => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('bdc_nonce'),
        'siteUrl'  => home_url('/'),
        'themeUrl' => BDC_URI,
        'waNumber' => '62895801960359',
        'i18n'     => array(
            'loading'  => __('Loading...', 'babarida-dive'),
            'bookNow'  => __('Book Now', 'babarida-dive'),
            'sent'     => __('Message sent!', 'babarida-dive'),
            'error'    => __('Something went wrong. Please try again.', 'babarida-dive'),
            'required' => __('This field is required.', 'babarida-dive'),
        ),
    ));

    // Localize Script — Clocks
    wp_localize_script('bdc-clocks', 'bdcClocks', array(
        'timezones' => array(
            array('city' => 'Manado',    'tz' => 'Asia/Makassar'),
            array('city' => 'Jakarta',   'tz' => 'Asia/Jakarta'),
            array('city' => 'Singapore', 'tz' => 'Asia/Singapore'),
            array('city' => 'Dubai',     'tz' => 'Asia/Dubai'),
            array('city' => 'London',    'tz' => 'Europe/London'),
            array('city' => 'New York',  'tz' => 'America/New_York'),
            array('city' => 'Tokyo',     'tz' => 'Asia/Tokyo'),
            array('city' => 'Seoul',     'tz' => 'Asia/Seoul'),
        ),
    ));
}

add_action('wp_enqueue_scripts', 'bdc_enqueue_assets');

// Admin Assets
function bdc_admin_assets($hook) {
    // Only load on our custom admin pages
    $our_pages = array(
        'toplevel_page_bdc-dashboard',
        'babarida-dive-center_page_bdc-bookings',
        'babarida-dive-center_page_bdc-analytics',
        'babarida-dive-center_page_bdc-pricing',
        'babarida-dive-center_page_bdc-customers',
        'babarida-dive-center_page_bdc-seo',
        'babarida-dive-center_page_bdc-weather',
        'babarida-dive-center_page_bdc-activity-log',
        'babarida-dive-center_page_bdc-chat',
        'babarida-dive-center_page_bdc-newsletter',
        'babarida-dive-center_page_bdc-backup',
        'babarida-dive-center_page_bdc-system',
        'babarida-dive-center_page_bdc-roles',
    );

    // Also load on our CPT edit screens
    $screen = get_current_screen();
    $our_cpts = array('bdc_trip', 'bdc_liveaboard', 'bdc_hotel', 'bdc_testimonial', 'bdc_partner', 'bdc_faq', 'bdc_booking', 'bdc_course', 'bdc_watersport', 'bdc_destination');

    $should_load = in_array($hook, $our_pages);
    if ($screen && in_array($screen->post_type, $our_cpts)) {
        $should_load = true;
    }

    if (!$should_load) return;

    wp_enqueue_style('bdc-admin', BDC_URI . '/assets/css/admin.css', array(), BDC_VERSION);
    wp_enqueue_script('bdc-admin-js', BDC_URI . '/assets/js/admin.js', array('jquery'), BDC_VERSION, true);
    wp_localize_script('bdc-admin-js', 'bdcAdmin', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('bdc_admin_nonce'),
    ));
}
add_action('admin_enqueue_scripts', 'bdc_admin_assets');

// Async font loading
function bdc_async_fonts($tag, $handle) {
    if ('bdc-google-fonts' === $handle) {
        $tag = str_replace("rel='stylesheet'", "rel='stylesheet' media='print' onload=\"this.media='all'\"", $tag);
        $tag .= '<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap"></noscript>';
    }
    return $tag;
}
add_filter('style_loader_tag', 'bdc_async_fonts', 10, 2);

// ============================================================
// WIDGET AREAS
// ============================================================
function bdc_widgets_init() {
    $sidebar_defaults = array(
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    );

    register_sidebar(array_merge($sidebar_defaults, array(
        'name'        => __('Footer Column 1', 'babarida-dive'),
        'id'          => 'footer-1',
        'description' => __('Footer widget area 1.', 'babarida-dive'),
    )));

    register_sidebar(array_merge($sidebar_defaults, array(
        'name'        => __('Footer Column 2', 'babarida-dive'),
        'id'          => 'footer-2',
        'description' => __('Footer widget area 2.', 'babarida-dive'),
    )));

    register_sidebar(array_merge($sidebar_defaults, array(
        'name'        => __('Footer Column 3', 'babarida-dive'),
        'id'          => 'footer-3',
        'description' => __('Footer widget area 3.', 'babarida-dive'),
    )));

    register_sidebar(array(
        'name'          => __('Sidebar', 'babarida-dive'),
        'id'            => 'sidebar-1',
        'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="sidebar-widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'bdc_widgets_init');

// ============================================================
// SAFE FILE LOADING — CUSTOM POST TYPES
// ============================================================
 $bdc_cpt_files = array(
    'cpt-destinations.php',
    'cpt-trips.php',
    'cpt-liveaboards.php',
    'cpt-hotels.php',
    'cpt-testimonials.php',
    'cpt-partners.php',
    'cpt-faq.php',
    'cpt-bookings.php',
    'cpt-courses.php',
    'cpt-watersports.php',
);

foreach ($bdc_cpt_files as $bdc_cpt_file) {
    $bdc_cpt_path = BDC_INC . $bdc_cpt_file;
    if (file_exists($bdc_cpt_path)) {
        require_once $bdc_cpt_path;
    }
}

// ============================================================
// SAFE FILE LOADING — CORE CLASSES
// ============================================================
 $bdc_class_files = array(
    'class-mega-menu-walker.php',
    'class-booking-system.php',
    'class-pricing-engine.php',
    'class-crm.php',
    'class-payment-gateway.php',
    'class-seo-manager.php',
    'class-weather-api.php',
    'class-loyalty-system.php',
    'class-waiver-system.php',
    'class-media-delivery.php',
    'class-currency-switcher.php',
    'class-ai-chat.php',
    'class-notification-system.php',
    'class-activity-logger.php',
    'class-system-health.php',
    'class-backup-system.php',
    'class-role-manager.php',
    'class-dashboard.php',
    'class-admin-chat.php',
    'class-newsletter.php',
    'class-social-sync.php',
);

foreach ($bdc_class_files as $bdc_class_file) {
    $bdc_class_path = BDC_INC . $bdc_class_file;
    if (file_exists($bdc_class_path)) {
        require_once $bdc_class_path;
    }
}

// ============================================================
// SAFE FILE LOADING — WORDPRESS CUSTOMIZER
// ============================================================
 $bdc_customizer_path = BDC_DIR . '/customizer.php';
if (file_exists($bdc_customizer_path)) {
    require_once $bdc_customizer_path;
}

// ============================================================
// SAFE FILE LOADING — ADMIN PAGES (admin only)
// ============================================================
if (is_admin()) {
    $bdc_admin_files = array(
        'dashboard.php',
        'bookings.php',
        'analytics.php',
        'pricing.php',
        'customers.php',
        'seo-panel.php',
        'weather-panel.php',
        'media-mgmt.php',
        'roles.php',
        'activity-log.php',
        'chat.php',
        'newsletter.php',
        'backup.php',
        'system-health.php',
    );

    foreach ($bdc_admin_files as $bdc_admin_file) {
        $bdc_admin_path = BDC_ADMIN . $bdc_admin_file;
        if (file_exists($bdc_admin_path)) {
            require_once $bdc_admin_path;
        }
    }
}

// ============================================================
// AJAX HANDLERS — FRONTEND
// ============================================================

// --- Booking Form Submission ---
add_action('wp_ajax_bdc_submit_booking', 'bdc_submit_booking');
add_action('wp_ajax_nopriv_bdc_submit_booking', 'bdc_submit_booking');
function bdc_submit_booking() {
    check_ajax_referer('bdc_nonce', 'nonce');

    $data = array(
        'name'        => sanitize_text_field($_POST['name'] ?? ''),
        'email'       => sanitize_email($_POST['email'] ?? ''),
        'phone'       => sanitize_text_field($_POST['phone'] ?? ''),
        'nationality' => sanitize_text_field($_POST['nationality'] ?? ''),
        'trip_id'     => intval($_POST['trip_id'] ?? 0),
        'trip_type'   => sanitize_text_field($_POST['trip_type'] ?? ''),
        'date'        => sanitize_text_field($_POST['date'] ?? ''),
        'guests'      => max(1, intval($_POST['guests'] ?? 1)),
        'message'     => sanitize_textarea_field($_POST['message'] ?? ''),
        'status'      => 'pending',
    );

    // Validate required fields
    if (empty($data['name']) || empty($data['email'])) {
        wp_send_json_error(array(
            'message' => __('Name and email are required.', 'babarida-dive'),
        ));
    }

    if (!is_email($data['email'])) {
        wp_send_json_error(array(
            'message' => __('Please enter a valid email address.', 'babarida-dive'),
        ));
    }

    // Create booking post
    $post_id = wp_insert_post(array(
        'post_title'  => sprintf(__('Booking: %s — %s', 'babarida-dive'), $data['name'], $data['date']),
        'post_type'   => 'bdc_booking',
        'post_status' => 'publish',
        'meta_input'  => $data,
    ));

    if (is_wp_error($post_id)) {
        wp_send_json_error(array(
            'message' => __('Booking failed. Please try again.', 'babarida-dive'),
        ));
    }

    // Generate QR code
    if (!get_post_meta($post_id, 'qr_code', true)) {
        $qr_code = 'BDC-' . $post_id . '-' . strtoupper(substr(md5($post_id . wp_salt()), 0, 8));
        update_post_meta($post_id, 'qr_code', $qr_code);
    }

    // Send notifications (non-blocking, don't block response)
    if (class_exists('BDC_Notification_System')) {
        try {
            BDC_Notification_System::send_booking_confirmation($post_id, $data);
            BDC_Notification_System::send_whatsapp_notification($data);
        } catch (Exception $e) {
            // Log error but don't fail the booking
            error_log('BDC Notification Error: ' . $e->getMessage());
        }
    }

    wp_send_json_success(array(
        'booking_id' => $post_id,
        'message'    => __('Booking submitted successfully! We will contact you within 24 hours.', 'babarida-dive'),
    ));
}

// --- Check-in Form ---
add_action('wp_ajax_bdc_submit_checkin', 'bdc_submit_checkin');
add_action('wp_ajax_nopriv_bdc_submit_checkin', 'bdc_submit_checkin');
function bdc_submit_checkin() {
    check_ajax_referer('bdc_nonce', 'nonce');

    $booking_id = intval($_POST['booking_id'] ?? 0);
    if (!$booking_id) {
        wp_send_json_error(array('message' => __('Invalid booking ID.', 'babarida-dive')));
    }

    // Verify booking exists
    $booking = get_post($booking_id);
    if (!$booking || $booking->post_type !== 'bdc_booking') {
        wp_send_json_error(array('message' => __('Booking not found.', 'babarida-dive')));
    }

    // Save check-in data
    $checkin_fields = array(
        'passport_number'     => 'passport_number',
        'passport_expiry'     => 'passport_expiry',
        'hotel_pickup'        => 'hotel_pickup',
        'certification_level' => 'certification_level',
    );

    foreach ($checkin_fields as $post_key => $meta_key) {
        $value = sanitize_text_field($_POST[$post_key] ?? '');
        if ($value) {
            update_post_meta($booking_id, $meta_key, $value);
        }
    }

    $dives = intval($_POST['dives_count'] ?? 0);
    update_post_meta($booking_id, 'dives_count', $dives);
    update_post_meta($booking_id, 'status', 'checked-in');

    $qr_code = get_post_meta($booking_id, 'qr_code', true);

    wp_send_json_success(array(
        'message'   => __('Check-in completed! See you at the dive center.', 'babarida-dive'),
        'qr_code'   => $qr_code,
        'booking_id'=> $booking_id,
    ));
}

// --- Find Booking for Check-in ---
add_action('wp_ajax_bdc_find_checkin', 'bdc_find_checkin');
add_action('wp_ajax_nopriv_bdc_find_checkin', 'bdc_find_checkin');
function bdc_find_checkin() {
    check_ajax_referer('bdc_nonce', 'nonce');

    $search = sanitize_text_field($_POST['search'] ?? '');
    if (empty($search)) {
        wp_send_json_error(array('message' => __('Please enter a booking reference or email.', 'babarida-dive')));
    }

    // Search by booking ID (BDC-123) or email
    $args = array(
        'post_type'      => 'bdc_booking',
        'posts_per_page' => 1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    // Check if searching by BDC-XXX format
    if (preg_match('/^BDC-(\d+)$/i', $search, $matches)) {
        $args['p'] = intval($matches[1]);
    } else {
        $args['meta_query'] = array(
            array(
                'key'   => 'email',
                'value' => $search,
            ),
        );
    }

    $bookings = get_posts($args);

    if (empty($bookings)) {
        wp_send_json_error(array('message' => __('Booking not found. Please check your reference or email.', 'babarida-dive')));
    }

    $b = $bookings[0];
    $status = get_post_meta($b->ID, 'status', true);

    if ($status === 'completed') {
        wp_send_json_error(array('message' => __('This booking has already been completed.', 'babarida-dive')));
    }

    if ($status === 'cancelled') {
        wp_send_json_error(array('message' => __('This booking has been cancelled.', 'babarida-dive')));
    }

    wp_send_json_success(array(
        'booking_id' => $b->ID,
        'name'       => get_post_meta($b->ID, 'name', true),
        'trip_type'  => get_post_meta($b->ID, 'trip_type', true),
        'date'       => get_post_meta($b->ID, 'date', true),
        'guests'     => get_post_meta($b->ID, 'guests', true),
        'status'     => $status,
    ));
}

// --- Newsletter Subscribe ---
add_action('wp_ajax_bdc_subscribe_newsletter', 'bdc_subscribe_newsletter');
add_action('wp_ajax_nopriv_bdc_subscribe_newsletter', 'bdc_subscribe_newsletter');
function bdc_subscribe_newsletter() {
    check_ajax_referer('bdc_nonce', 'nonce');

    $email = sanitize_email($_POST['email'] ?? '');
    if (!is_email($email)) {
        wp_send_json_error(array('message' => __('Please enter a valid email address.', 'babarida-dive')));
    }

    // Check for duplicate
    $exists = get_posts(array(
        'post_type'      => 'bdc_newsletter_sub',
        'meta_key'       => 'subscriber_email',
        'meta_value'     => $email,
        'posts_per_page' => 1,
        'fields'         => 'ids',
    ));

    if (!empty($exists)) {
        wp_send_json_error(array('message' => __('You are already subscribed.', 'babarida-dive')));
    }

    $sub_id = wp_insert_post(array(
        'post_title'  => $email,
        'post_type'   => 'bdc_newsletter_sub',
        'post_status' => 'publish',
        'meta_input'  => array(
            'subscriber_email' => $email,
            'subscribed_at'    => current_time('mysql'),
        ),
    ));

    if (is_wp_error($sub_id)) {
        wp_send_json_error(array('message' => __('Subscription failed. Please try again.', 'babarida-dive')));
    }

    wp_send_json_success(array('message' => __('Successfully subscribed!', 'babarida-dive')));
}

// --- AI Chat ---
add_action('wp_ajax_bdc_ai_chat', 'bdc_ai_chat_handler');
add_action('wp_ajax_nopriv_bdc_ai_chat', 'bdc_ai_chat_handler');
function bdc_ai_chat_handler() {
    check_ajax_referer('bdc_nonce', 'nonce');

    $message = sanitize_text_field($_POST['message'] ?? '');
    if (empty($message)) {
        wp_send_json_success(array('reply' => __('Please type a question.', 'babarida-dive')));
    }

    if (class_exists('BDC_AI_Chat')) {
        $reply = BDC_AI_Chat::get_response($message);
    } else {
        $reply = __('Thank you for your interest! Please contact us at info@babaridadive.com for assistance.', 'babarida-dive');
    }

    wp_send_json_success(array('reply' => $reply));
}

// --- Currency Switch ---
add_action('wp_ajax_bdc_switch_currency', 'bdc_switch_currency');
add_action('wp_ajax_nopriv_bdc_switch_currency', 'bdc_switch_currency');
function bdc_switch_currency() {
    $currency = sanitize_text_field($_POST['currency'] ?? 'USD');
    $valid    = array('USD', 'IDR', 'EUR', 'SGD', 'AUD');

    if (!in_array($currency, $valid)) {
        wp_send_json_error();
    }

    setcookie('bdc_currency', $currency, time() + (86400 * 30), '/');
    wp_send_json_success(array('currency' => $currency));
}

// --- Filter Products (AJAX Archive) ---
add_action('wp_ajax_bdc_filter_products', 'bdc_filter_products');
add_action('wp_ajax_nopriv_bdc_filter_products', 'bdc_filter_products');
function bdc_filter_products() {
    check_ajax_referer('bdc_nonce', 'nonce');

    $args = array(
        'post_type'      => sanitize_text_field($_POST['post_type'] ?? 'bdc_trip'),
        'posts_per_page' => max(1, intval($_POST['per_page'] ?? 9)),
        'paged'          => max(1, intval($_POST['page'] ?? 1)),
        'orderby'        => sanitize_text_field($_POST['orderby'] ?? 'date'),
        'order'          => sanitize_text_field($_POST['order'] ?? 'DESC'),
    );

    $tax_query = array();

    $destination = sanitize_text_field($_POST['destination'] ?? '');
    if (!empty($destination) && taxonomy_exists('bdc_destination')) {
        $tax_query[] = array(
            'taxonomy' => 'bdc_destination',
            'field'    => 'slug',
            'terms'    => $destination,
        );
    }

    $activity = sanitize_text_field($_POST['activity'] ?? '');
    if (!empty($activity) && taxonomy_exists('bdc_activity')) {
        $tax_query[] = array(
            'taxonomy' => 'bdc_activity',
            'field'    => 'slug',
            'terms'    => $activity,
        );
    }

    if (!empty($tax_query)) {
        $tax_query['relation'] = 'AND';
        $args['tax_query'] = $tax_query;
    }

    $price_min = intval($_POST['price_min'] ?? 0);
    $price_max = intval($_POST['price_max'] ?? 0);
    if ($price_min > 0 || $price_max > 0) {
        $args['meta_query'] = array(
            array(
                'key'     => 'price_usd',
                'value'   => array(max(0, $price_min), max(1, $price_max)),
                'compare' => 'BETWEEN',
                'type'    => 'NUMERIC',
            ),
        );
    }

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) :
        while ($query->have_posts()) :
            $query->the_post();
            get_template_part('template-parts/card', get_post_type());
        endwhile;
    else :
        echo '<p style="grid-column:1/-1;padding:40px 0;color:var(--mid-gray);text-align:center;">'
           . esc_html__('No results found. Try adjusting your filters.', 'babarida-dive')
           . '</p>';
    endif;

    wp_reset_postdata();

    $html = ob_get_clean();

    wp_send_json_success(array(
        'html'      => $html,
        'total'     => $query->found_posts,
        'max_pages' => $query->max_num_pages,
    ));
}

// --- Weather Data ---
add_action('wp_ajax_bdc_get_weather', 'bdc_get_weather');
add_action('wp_ajax_nopriv_bdc_get_weather', 'bdc_get_weather');
function bdc_get_weather() {
    if (class_exists('BDC_Weather_API')) {
        $weather = BDC_Weather_API::get_current();
    } else {
        $weather = array(
            'temp'      => 30,
            'water'     => 29,
            'visibility'=> 20,
            'wind'      => 12,
            'tide'      => 1.2,
            'condition' => 'Partly Cloudy',
        );
    }
    wp_send_json_success($weather);
}

// ============================================================
// AJAX HANDLERS — ADMIN ONLY
// ============================================================

// --- CRM Customer Search ---
add_action('wp_ajax_bdc_get_customer', 'bdc_ajax_get_customer');
function bdc_ajax_get_customer() {
    check_ajax_referer('bdc_admin_nonce', 'nonce');

    if (!current_user_can('bdc_view_bookings')) {
        wp_send_json_error(array('message' => __('Unauthorized.', 'babarida-dive')));
    }

    $email = sanitize_email($_POST['email'] ?? '');
    if (!$email) {
        wp_send_json_error(array('message' => __('Invalid email.', 'babarida-dive')));
    }

    if (class_exists('BDC_CRM')) {
        wp_send_json_success(BDC_CRM::get_customer_profile($email));
    } else {
        wp_send_json_error(array('message' => __('CRM module not available.', 'babarida-dive')));
    }
}

// --- Booking Status Change ---
add_action('wp_ajax_bdc_change_booking_status', 'bdc_ajax_change_status');
function bdc_ajax_change_status() {
    check_ajax_referer('bdc_admin_nonce', 'nonce');

    if (!current_user_can('bdc_manage_bookings')) {
        wp_send_json_error(array('message' => __('Unauthorized.', 'babarida-dive')));
    }

    $booking_id = intval($_POST['booking_id'] ?? 0);
    $status     = sanitize_text_field($_POST['status'] ?? '');
    $valid_statuses = array('pending', 'confirmed', 'paid', 'checked-in', 'completed', 'cancelled');

    if (!$booking_id || !in_array($status, $valid_statuses)) {
        wp_send_json_error(array('message' => __('Invalid parameters.', 'babarida-dive')));
    }

    $old_status = get_post_meta($booking_id, 'status', true);
    update_post_meta($booking_id, 'status', $status);

    // Fire hooks
    if ($status === 'confirmed' && $old_status !== 'confirmed') {
        do_action('bdc_booking_confirmed', $booking_id);
    }
    if ($status === 'cancelled' && $old_status !== 'cancelled') {
        do_action('bdc_booking_cancelled', $booking_id);
    }

    // Log activity
    if (class_exists('BDC_Activity_Logger')) {
        BDC_Activity_Logger::log(
            'Booking status changed',
            sprintf('BDC-%d: %s → %s', $booking_id, $old_status, $status)
        );
    }

    wp_send_json_success(array('status' => $status));
}

// --- Admin Gallery Refresh ---
add_action('wp_ajax_bdc_refresh_gallery', 'bdc_ajax_refresh_gallery');
function bdc_ajax_refresh_gallery() {
    check_ajax_referer('bdc_admin_nonce', 'nonce');

    $ids_raw = sanitize_text_field($_GET['ids'] ?? '');
    $ids = array_filter(array_map('intval', explode(',', $ids_raw)));

    if (empty($ids)) {
        wp_die('0');
    }

    foreach ($ids as $img_id) {
        echo '<div style="display:inline-block;margin:0 8px 8px 0;">'
           . wp_get_attachment_image($img_id, 'thumbnail')
           . '</div>';
    }

    wp_die();
}

// ============================================================
// SCHEMA MARKUP OUTPUT
// ============================================================
function bdc_output_schema() {
    // TouristTrip schema for trip CPTs
    if (is_singular(array('bdc_trip', 'bdc_liveaboard', 'bdc_destination'))) {
        global $post;
        $price = get_post_meta($post->ID, 'price_usd', true);

        $schema = array(
            '@context'  => 'https://schema.org',
            '@type'     => 'TouristTrip',
            'name'      => get_the_title(),
            'description'=> wp_strip_all_tags(get_the_excerpt()),
            'url'       => get_permalink(),
            'image'     => get_the_post_thumbnail_url($post->ID, 'full'),
            'offers'    => array(
                '@type'         => 'Offer',
                'price'         => $price ? $price : '0',
                'priceCurrency' => 'USD',
                'availability'  => 'https://schema.org/InStock',
            ),
        );

        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    }

    // Liveaboard schema
    if (is_singular('bdc_liveaboard')) {
        global $post;
        $schema = array(
            '@context'    => 'https://schema.org',
            '@type'       => 'BoatTrip',
            'name'        => get_the_title(),
            'description' => wp_strip_all_tags(get_the_excerpt()),
            'url'         => get_permalink(),
            'image'       => get_the_post_thumbnail_url($post->ID, 'full'),
        );
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    }
}
add_action('wp_head', 'bdc_output_schema');

// ============================================================
// SITEMAP & ROBOTS (dynamic via rewrite rules)
// ============================================================
function bdc_generate_sitemap() {
    if (!isset($_GET['sitemap']) || $_GET['sitemap'] !== 'xml') {
        return;
    }

    header('Content-Type: application/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    $post_types = array(
        'page',
        'post',
        'bdc_destination',
        'bdc_trip',
        'bdc_liveaboard',
        'bdc_hotel',
        'bdc_course',
        'bdc_watersport',
        'bdc_faq',
    );

    foreach ($post_types as $pt) {
        $posts = get_posts(array(
            'post_type'      => $pt,
            'posts_per_page' => 500,
            'post_status'    => 'publish',
            'fields'         => 'ids',
        ));

        foreach ($posts as $p_id) {
            $mod  = get_post_modified_time('Y-m-d\TH:i:s+00:00', false, $p_id);
            $freq = ($pt === 'post') ? 'weekly' : 'monthly';
            $pri  = '0.6';
            if ($pt === 'page')              $pri = '0.8';
            if ($pt === 'bdc_destination')   $pri = '0.9';
            if ($p_id === get_option('page_on_front')) $pri = '1.0';

            printf(
                "<url><loc>%s</loc><lastmod>%s</lastmod><changefreq>%s</changefreq><priority>%s</priority></url>\n",
                esc_url(get_permalink($p_id)),
                esc_html($mod),
                esc_html($freq),
                esc_html($pri)
            );
        }
    }

    echo '</urlset>';
    exit;
}
add_action('init', 'bdc_generate_sitemap');

function bdc_generate_robots() {
    if (!isset($_GET['robots']) || $_GET['robots'] !== 'txt') {
        return;
    }

    header('Content-Type: text/plain; charset=utf-8');
    echo "User-agent: *\n";
    echo "Allow: /\n";
    echo "Disallow: /wp-admin/\n";
    echo "Disallow: /wp-includes/\n";
    echo "Disallow: /?s=\n";
    echo "Disallow: /wp-login.php\n";
    echo "Sitemap: " . esc_url(home_url('/sitemap.xml')) . "\n";
    exit;
}
add_action('init', 'bdc_generate_robots');

// Rewrite rules for sitemap.xml and robots.txt
function bdc_rewrite_rules() {
    add_rewrite_rule('^sitemap\.xml$', 'index.php?sitemap=xml', 'top');
    add_rewrite_rule('^robots\.txt$', 'index.php?robots=txt', 'top');
}
add_action('init', 'bdc_rewrite_rules');

function bdc_query_vars($vars) {
    $vars[] = 'sitemap';
    $vars[] = 'robots';
    return $vars;
}
add_filter('query_vars', 'bdc_query_vars');

// ============================================================
// SECURITY ENHANCEMENTS
// ============================================================

// Remove WordPress version from head
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'rest_output_link_wp_head');

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Login attempts limiter
function bdc_login_limiter($user) {
    if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
        return $user;
    }

    $ip       = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown';
    $attempts = get_transient('bdc_login_' . $ip);

    if ($attempts !== false && (int) $attempts >= 5) {
        return new WP_Error(
            'too_many_attempts',
            __('Too many login attempts. Please try again in 15 minutes.', 'babarida-dive'),
            array('status' => 429)
        );
    }

    // Only count for failed attempts (user is WP_Error)
    if (is_wp_error($user)) {
        set_transient('bdc_login_' . $ip, ((int) $attempts + 1), 900);
    }

    return $user;
}
add_filter('authenticate', 'bdc_login_limiter', 30);

// Clear login attempts on successful login
function bdc_clear_login_limiter($user) {
    if (!is_wp_error($user) && isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
        delete_transient('bdc_login_' . $ip);
    }
    return $user;
}
add_filter('authenticate', 'bdc_clear_login_limiter', 40);

// Security headers
function bdc_security_headers() {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
}
add_action('send_headers', 'bdc_security_headers');

// Sanitize upload types — block dangerous files
function bdc_disallow_upload_types($types) {
    unset(
        $types['php'],
        $types['php4'],
        $types['php5'],
        $types['php7'],
        $types['php8'],
        $types['phtml'],
        $types['pht'],
        $types['exe'],
        $types['js'],
        $types['html'],
        $types['htm'],
        $types['sh'],
        $types['py'],
        $types['pl'],
        $types['cgi']
    );
    return $types;
}
add_filter('upload_mimes', 'bdc_disallow_upload_types');

// Remove author pages (security)
function bdc_disable_author_pages() {
    if (isset($_GET['author'])) {
        wp_redirect(home_url(), 301);
        exit;
    }
}
add_action('template_redirect', 'bdc_disable_author_pages');

// ============================================================
// PERFORMANCE OPTIMIZATIONS
// ============================================================

// Defer non-critical JS
function bdc_defer_js($tag, $handle) {
    $defer_handles = array('lucide-icons', 'bdc-main', 'bdc-clocks', 'bdc-booking');
    if (in_array($handle, $defer_handles)) {
        return str_replace(' src=', ' defer src=', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'bdc_defer_js', 10, 2);

// Remove emoji scripts (saves ~30KB)
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Native lazy loading for images
function bdc_lazy_load_images($attr) {
    if (!is_admin()) {
        $attr['loading'] = 'lazy';
        $attr['decoding'] = 'async';
    }
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'bdc_lazy_load_images');

// Preload hero image
function bdc_preload_hero() {
    $hero_img = get_theme_mod('bdc_hero_image', '');
    if ($hero_img) {
        printf(
            '<link rel="preload" as="image" href="%s">' . "\n",
            esc_url($hero_img)
        );
    }
}
add_action('wp_head', 'bdc_preload_hero', 1);

// DNS prefetch for external domains
function bdc_dns_prefetch() {
    echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">' . "\n";
    echo '<link rel="dns-prefetch" href="//unpkg.com">' . "\n";
    echo '<link rel="dns-prefetch" href="//api.whatsapp.com">' . "\n";
    echo '<link rel="dns-prefetch" href="//i0.wp.com">' . "\n";
}
add_action('wp_head', 'bdc_dns_prefetch', 0);

// Disable jQuery Migrate on frontend
function bdc_dequeue_jquery_migrate($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
}
add_action('wp_default_scripts', 'bdc_dequeue_jquery_migrate');

// ============================================================
// GUTENBERG COMPATIBILITY
// ============================================================
function bdc_gutenberg_colors() {
    add_theme_support('editor-color-palette', array(
        array('name' => __('Deep Ocean', 'babarida-dive'),     'slug' => 'deep-ocean',     'color' => '#001D3D'),
        array('name' => __('Mid Ocean', 'babarida-dive'),      'slug' => 'mid-ocean',      'color' => '#003566'),
        array('name' => __('Bright Blue', 'babarida-dive'),    'slug' => 'bright-blue',    'color' => '#0077B6'),
        array('name' => __('Sky Blue', 'babarida-dive'),       'slug' => 'sky-blue',       'color' => '#00B4D8'),
        array('name' => __('Tropical Yellow', 'babarida-dive'),'slug' => 'tropical-yellow','color' => '#FFB703'),
        array('name' => __('Golden', 'babarida-dive'),         'slug' => 'golden',         'color' => '#FB8500'),
        array('name' => __('Coral', 'babarida-dive'),          'slug' => 'coral',          'color' => '#E07A5F'),
        array('name' => __('White', 'babarida-dive'),          'slug' => 'white',          'color' => '#FFFFFF'),
    ));

    add_theme_support('editor-font-sizes', array(
        array('name' => __('Small', 'babarida-dive'),  'slug' => 'small',  'size' => 13),
        array('name' => __('Normal', 'babarida-dive'), 'slug' => 'normal', 'size' => 16),
        array('name' => __('Medium', 'babarida-dive'), 'slug' => 'medium', 'size' => 20),
        array('name' => __('Large', 'babarida-dive'),  'slug' => 'large',  'size' => 28),
        array('name' => __('Huge', 'babarida-dive'),   'slug' => 'huge',   'size' => 42),
    ));
}
add_action('after_setup_theme', 'bdc_gutenberg_colors');

// ============================================================
// EXCERPT SETTINGS
// ============================================================
function bdc_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'bdc_excerpt_length');

function bdc_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'bdc_excerpt_more');

// ============================================================
// BODY CLASSES
// ============================================================
function bdc_body_classes($classes) {
    $classes[] = 'bdc-theme';

    if (is_front_page()) {
        $classes[] = 'home';
    }
    if (is_singular()) {
        $classes[] = 'singular';
    }
    if (wp_is_mobile()) {
        $classes[] = 'mobile';
    }

    return $classes;
}
add_filter('body_class', 'bdc_body_classes');

// ============================================================
// CUSTOM LOGIN PAGE
// ============================================================
function bdc_custom_login_handler() {
    if (!isset($_GET['bdc-login'])) {
        return;
    }

    $login_template = BDC_DIR . '/templates/login.php';
    if (file_exists($login_template)) {
        include $login_template;
        exit;
    }
}
add_action('init', 'bdc_custom_login_handler');

// Redirect wp-login to custom login
function bdc_redirect_login() {
    global $pagenow;

    if ($pagenow !== 'wp-login.php') {
        return;
    }

    // Allow standard WordPress actions to work (logout, lostpassword, etc.)
    $allowed_actions = array('logout', 'lostpassword', 'rp', 'resetpass', 'postpass');
    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

    if (in_array($action, $allowed_actions)) {
        return;
    }

    // Allow POST requests (actual login form submissions)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        return;
    }

    wp_redirect(home_url('/wp-login.php?bdc-login=1'));
    exit;
}
add_action('init', 'bdc_redirect_login');

// ============================================================
// PWA SUPPORT
// ============================================================
function bdc_pwa_headers() {
    header('Service-Worker-Allowed: /');
}
add_action('send_headers', 'bdc_pwa_headers');

// ============================================================
// CUSTOM FALLBACK MENU (used when no menu is assigned)
// ============================================================
function bdc_fallback_menu() {
    $fallback_items = array(
        array('url' => home_url('/'),               'label' => __('Home', 'babarida-dive')),
        array('url' => home_url('/bunaken'),         'label' => 'Bunaken'),
        array('url' => home_url('/siladen'),         'label' => 'Siladen'),
        array('url' => home_url('/bangka'),          'label' => 'Bangka'),
        array('url' => home_url('/lembeh'),          'label' => 'Lembeh'),
        array('url' => home_url('/liveaboards'),     'label' => __('Liveaboards', 'babarida-dive')),
        array('url' => home_url('/blog'),            'label' => __('Blog', 'babarida-dive')),
        array('url' => home_url('/faq'),             'label' => __('FAQ', 'babarida-dive')),
        array('url' => home_url('/check-in'),        'label' => __('Check-In', 'babarida-dive')),
    );

    echo '<ul class="nav-menu">';
    foreach ($fallback_items as $item) {
        echo '<li><a href="' . esc_url($item['url']) . '">' . esc_html($item['label']) . '</a></li>';
    }
    echo '</ul>';
}

// ============================================================
// ACTIVATION HOOK
// ============================================================
function bdc_activate() {

    // Flush rewrite rules (critical for sitemap.xml and robots.txt)
    flush_rewrite_rules();

    // Create essential pages if they don't exist
    $pages_to_create = array(
        'check-in' => array(
            'title'    => __('Check-In', 'babarida-dive'),
            'template' => 'templates/check-in.php',
        ),
        'booking'  => array(
            'title'    => __('Book Now', 'babarida-dive'),
            'template' => 'templates/booking-form.php',
        ),
        'faq'      => array(
            'title'    => __('FAQ', 'babarida-dive'),
            'template' => '',
        ),
    );

    foreach ($pages_to_create as $slug => $page_data) {
        $existing = get_page_by_path($slug);

        if (!$existing) {
            $page_id = wp_insert_post(array(
                'post_title'  => $page_data['title'],
                'post_name'   => $slug,
                'post_status' => 'publish',
                'post_type'   => 'page',
            ));

            if ($page_id && !is_wp_error($page_id) && !empty($page_data['template'])) {
                update_post_meta($page_id, '_wp_page_template', $page_data['template']);
            }
        }
    }

    // Set default permalinks if not set
    $current_structure = get_option('permalink_structure');
    if (empty($current_structure)) {
        update_option('permalink_structure', '/%postname%/');
        flush_rewrite_rules();
    }
}
register_activation_hook(__FILE__, 'bdc_activate');

// ============================================================
// DEACTIVATION HOOK
// ============================================================
function bdc_deactivate() {
    flush_rewrite_rules();

    // Clear scheduled events
    wp_clear_scheduled_hook('bdc_daily_backup');
}
register_deactivation_hook(__FILE__, 'bdc_deactivate');

// ============================================================
// THEME UPDATE HOOK (re-flush rules on version change)
// ============================================================
function bdc_check_version() {
    $saved_version = get_option('bdc_theme_version', '0.0.0');
    if (version_compare($saved_version, BDC_VERSION, '<')) {
        flush_rewrite_rules();
        update_option('bdc_theme_version', BDC_VERSION);
    }
}
add_action('after_setup_theme', 'bdc_check_version');

// ============================================================
// PREVENT DIRECT ACCESS TO TEMPLATE PARTS
// ============================================================
function bdc_block_direct_template_access() {
    $template_path = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME'] ?? '');
    $theme_path   = str_replace('\\', '/', BDC_DIR);

    if (strpos($template_path, $theme_path . '/template-parts/') !== false) {
        wp_die(__('Direct access to template files is not allowed.', 'babarida-dive'), 403);
    }
}
add_action('init', 'bdc_block_direct_template_access');

// ============================================================
// ADD BDC_BOOKING CAPABILITY MAP
// ============================================================
function bdc_map_booking_meta_caps($caps, $cap, $user_id, $args) {
    if (strpos($cap, 'bdc_booking') === false) {
        return $caps;
    }

    // Admin can do everything
    if (user_can($user_id, 'manage_options')) {
        return array('manage_options');
    }

    // Users with bdc_manage_bookings can do most things
    if (user_can($user_id, 'bdc_manage_bookings')) {
        return array('bdc_manage_bookings');
    }

    // Users with bdc_view_bookings can only read
    if ($cap === 'read_bdc_booking' || $cap === 'edit_bdc_booking') {
        if (user_can($user_id, 'bdc_view_bookings')) {
            return array('bdc_view_bookings');
        }
    }

    return $caps;
}
add_filter('map_meta_cap', 'bdc_map_booking_meta_caps', 10, 4);

// ============================================================
// HELPER: Safely get theme mod with fallback
// ============================================================
function bdc_get_mod($key, $fallback = '') {
    $value = get_theme_mod($key, $fallback);
    return $value ? $value : $fallback;
}

// ============================================================
// HELPER: Truncate text safely
// ============================================================
function bdc_truncate($text, $length = 100, $end = '...') {
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length) . $end;
}

// ============================================================
// HELPER: Format price with currency
// ============================================================
function bdc_price($amount_usd, $currency = '') {
    if (class_exists('BDC_Currency_Switcher')) {
        return BDC_Currency_Switcher::format_price((float) $amount_usd, $currency);
    }
    return '$' . number_format((float) $amount_usd, 2);
}

// ============================================================
// HELPER: Get star rating HTML
// ============================================================
function bdc_stars($rating, $max = 5) {
    $html = '';
    for ($i = 1; $i <= $max; $i++) {
        if ($i <= $rating) {
            $html .= '<span style="color:var(--tropical-yellow);">★</span>';
        } else {
            $html .= '<span style="color:var(--light-gray);">★</span>';
        }
    }
    return $html;
}

// ============================================================
// HELPER: Get status badge HTML
// ============================================================
function bdc_status_badge($status) {
    $badge_classes = array(
        'pending'    => 'bdc-badge-pending',
        'confirmed'  => 'bdc-badge-confirmed',
        'paid'       => 'bdc-badge-paid',
        'checked-in' => 'bdc-badge-checked-in',
        'completed'  => 'bdc-badge-completed',
        'cancelled'  => 'bdc-badge-cancelled',
    );
    $class = isset($badge_classes[$status]) ? $badge_classes[$status] : 'bdc-badge-pending';
    return '<span class="bdc-badge ' . esc_attr($class) . '">' . esc_html(ucfirst($status)) . '</span>';
}

// ============================================================
// DEBUG: Log theme errors (only when WP_DEBUG_LOG is on)
// ============================================================
function bdc_error_handler($errno, $errstr, $errfile, $errline) {
    // Only log errors from our theme
    $theme_path = str_replace('\\', '/', BDC_DIR);
    $err_file  = str_replace('\\', '/', $errfile);

    if (strpos($err_file, $theme_path) !== false) {
        error_log(sprintf(
            '[BDC Theme] %s in %s on line %d',
            $errstr,
            $errfile,
            $errline
        ));
    }

    // Don't prevent PHP's built-in error handler
    return false;
}
set_error_handler('bdc_error_handler');
