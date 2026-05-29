<?php
/**
 * Babarida Dive Center Theme Functions
 *
 * @package Babarida_Dive
 * @author Iqbal Tombinawa <tombinawaiqbal@gmail.com>
 * @version 1.0.0
 */

defined('ABSPATH') || exit;

// Theme Constants
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
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
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
        'primary'   => __('Primary Navigation', 'babarida-dive'),
        'bunaken'   => __('Bunaken Submenu', 'babarida-dive'),
        'siladen'   => __('Siladen Submenu', 'babarida-dive'),
        'bangka'    => __('Bangka Submenu', 'babarida-dive'),
        'lembeh'    => __('Lembeh Submenu', 'babarida-dive'),
        'liveaboard'=> __('Liveaboard Submenu', 'babarida-dive'),
        'footer'    => __('Footer Navigation', 'babarida-dive'),
    ));

    // Text Domain
    load_theme_textdomain('babarida-dive', BDC_DIR . '/languages');
}
add_action('after_setup_theme', 'bdc_theme_setup');

// ============================================================
// ENQUEUE SCRIPTS & STYLES
// ============================================================
function bdc_enqueue_assets() {
    // Google Fonts
    wp_enqueue_style('bdc-google-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap', array(), null);

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

    // Localize Script
    wp_localize_script('bdc-main', 'bdcData', array(
        'ajaxUrl'  => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('bdc_nonce'),
        'siteUrl'  => home_url('/'),
        'themeUrl' => BDC_URI,
        'waNumber' => '62895801960359',
        'i18n'     => array(
            'loading'    => __('Loading...', 'babarida-dive'),
            'bookNow'    => __('Book Now', 'babarida-dive'),
            'sent'       => __('Message sent!', 'babarida-dive'),
            'error'      => __('Something went wrong. Please try again.', 'babarida-dive'),
            'required'   => __('This field is required.', 'babarida-dive'),
        ),
    ));

    // Pass PHP data to clock script
    wp_localize_script('bdc-clocks', 'bdcClocks', array(
        'timezones' => array(
            array('city' => 'Manado', 'tz' => 'Asia/Makassar'),
            array('city' => 'Jakarta', 'tz' => 'Asia/Jakarta'),
            array('city' => 'Singapore', 'tz' => 'Asia/Singapore'),
            array('city' => 'Dubai', 'tz' => 'Asia/Dubai'),
            array('city' => 'London', 'tz' => 'Europe/London'),
            array('city' => 'New York', 'tz' => 'America/New_York'),
            array('city' => 'Tokyo', 'tz' => 'Asia/Tokyo'),
            array('city' => 'Seoul', 'tz' => 'Asia/Seoul'),
        ),
    ));

    // Preload Critical Fonts
    add_filter('style_loader_tag', function($tag, $handle) {
        if ('bdc-google-fonts' === $handle) {
            $tag = str_replace("rel='stylesheet'", "rel='stylesheet' media='print' onload=\"this.media='all'\"", $tag);
            $tag .= "<noscript><link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap'></noscript>";
        }
        return $tag;
    }, 10, 2);
}
add_action('wp_enqueue_scripts', 'bdc_enqueue_assets');

// Admin Assets
function bdc_admin_assets($hook) {
    if (strpos($hook, 'babarida') === false && $hook !== 'toplevel_page_bdc-dashboard') return;
    wp_enqueue_style('bdc-admin', BDC_URI . '/assets/css/admin.css', array(), BDC_VERSION);
    wp_enqueue_script('bdc-admin-js', BDC_URI . '/assets/js/admin.js', array('jquery'), BDC_VERSION, true);
    wp_localize_script('bdc-admin-js', 'bdcAdmin', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('bdc_admin_nonce'),
    ));
}
add_action('admin_enqueue_scripts', 'bdc_admin_assets');

// ============================================================
// WIDGET AREAS
// ============================================================
function bdc_widgets_init() {
    register_sidebar(array(
        'name'          => __('Footer Column 1', 'babarida-dive'),
        'id'            => 'footer-1',
        'description'   => __('Footer widget area 1.', 'babarida-dive'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ));
    register_sidebar(array(
        'name'          => __('Footer Column 2', 'babarida-dive'),
        'id'            => 'footer-2',
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ));
    register_sidebar(array(
        'name'          => __('Footer Column 3', 'babarida-dive'),
        'id'            => 'footer-3',
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ));
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
// CUSTOM POST TYPES
// ============================================================
require_once BDC_INC . 'cpt-destinations.php';
require_once BDC_INC . 'cpt-trips.php';
require_once BDC_INC . 'cpt-liveaboards.php';
require_once BDC_INC . 'cpt-hotels.php';
require_once BDC_INC . 'cpt-testimonials.php';
require_once BDC_INC . 'cpt-partners.php';
require_once BDC_INC . 'cpt-faq.php';
require_once BDC_INC . 'cpt-bookings.php';
require_once BDC_INC . 'cpt-courses.php';
require_once BDC_INC . 'cpt-watersports.php';

// ============================================================
// CORE SYSTEMS
// ============================================================
require_once BDC_INC . 'class-mega-menu-walker.php';
require_once BDC_INC . 'class-booking-system.php';
require_once BDC_INC . 'class-pricing-engine.php';
require_once BDC_INC . 'class-crm.php';
require_once BDC_INC . 'class-payment-gateway.php';
require_once BDC_INC . 'class-seo-manager.php';
require_once BDC_INC . 'class-weather-api.php';
require_once BDC_INC . 'class-loyalty-system.php';
require_once BDC_INC . 'class-waiver-system.php';
require_once BDC_INC . 'class-media-delivery.php';
require_once BDC_INC . 'class-currency-switcher.php';
require_once BDC_INC . 'class-ai-chat.php';
require_once BDC_INC . 'class-notification-system.php';
require_once BDC_INC . 'class-activity-logger.php';
require_once BDC_INC . 'class-system-health.php';
require_once BDC_INC . 'class-backup-system.php';
require_once BDC_INC . 'class-role-manager.php';
require_once BDC_INC . 'class-dashboard.php';
require_once BDC_INC . 'class-admin-chat.php';
require_once BDC_INC . 'class-newsletter.php';
require_once BDC_INC . 'class-social-sync.php';

// ============================================================
// WORDPRESS CUSTOMIZER
// ============================================================
require_once BDC_DIR . '/customizer.php';

// ============================================================
// ADMIN PAGES
// ============================================================
require_once BDC_ADMIN . 'dashboard.php';
require_once BDC_ADMIN . 'bookings.php';
require_once BDC_ADMIN . 'analytics.php';
require_once BDC_ADMIN . 'pricing.php';
require_once BDC_ADMIN . 'customers.php';
require_once BDC_ADMIN . 'seo-panel.php';
require_once BDC_ADMIN . 'weather-panel.php';
require_once BDC_ADMIN . 'media-mgmt.php';
require_once BDC_ADMIN . 'roles.php';
require_once BDC_ADMIN . 'activity-log.php';
require_once BDC_ADMIN . 'chat.php';
require_once BDC_ADMIN . 'newsletter.php';
require_once BDC_ADMIN . 'backup.php';
require_once BDC_ADMIN . 'system-health.php';

// ============================================================
// AJAX HANDLERS
// ============================================================

// Booking Form Submission
add_action('wp_ajax_bdc_submit_booking', 'bdc_submit_booking');
add_action('wp_ajax_nopriv_bdc_submit_booking', 'bdc_submit_booking');
function bdc_submit_booking() {
    check_ajax_referer('bdc_nonce', 'nonce');
    $data = array(
        'name'       => sanitize_text_field($_POST['name'] ?? ''),
        'email'      => sanitize_email($_POST['email'] ?? ''),
        'phone'      => sanitize_text_field($_POST['phone'] ?? ''),
        'nationality'=> sanitize_text_field($_POST['nationality'] ?? ''),
        'trip_id'    => intval($_POST['trip_id'] ?? 0),
        'trip_type'  => sanitize_text_field($_POST['trip_type'] ?? ''),
        'date'       => sanitize_text_field($_POST['date'] ?? ''),
        'guests'     => intval($_POST['guests'] ?? 1),
        'message'    => sanitize_textarea_field($_POST['message'] ?? ''),
        'status'     => 'pending',
    );
    if (empty($data['name']) || empty($data['email'])) {
        wp_send_json_error(array('message' => __('Name and email are required.', 'babarida-dive')));
    }
    $post_id = wp_insert_post(array(
        'post_title'  => sprintf(__('Booking: %s - %s', 'babarida-dive'), $data['name'], $data['date']),
        'post_type'   => 'bdc_booking',
        'post_status' => 'publish',
        'meta_input'  => $data,
    ));
    if (is_wp_error($post_id)) {
        wp_send_json_error(array('message' => __('Booking failed. Please try again.', 'babarida-dive')));
    }
    // Send notifications
    BDC_Notification_System::send_booking_confirmation($post_id, $data);
    BDC_Notification_System::send_whatsapp_notification($data);
    wp_send_json_success(array('booking_id' => $post_id, 'message' => __('Booking submitted successfully!', 'babarida-dive')));
}

// Check-in Form
add_action('wp_ajax_bdc_submit_checkin', 'bdc_submit_checkin');
add_action('wp_ajax_nopriv_bdc_submit_checkin', 'bdc_submit_checkin');
function bdc_submit_checkin() {
    check_ajax_referer('bdc_nonce', 'nonce');
    $booking_id = intval($_POST['booking_id'] ?? 0);
    if (!$booking_id) wp_send_json_error(array('message' => __('Invalid booking ID.', 'babarida-dive')));
    update_post_meta($booking_id, 'passport_number', sanitize_text_field($_POST['passport_number'] ?? ''));
    update_post_meta($booking_id, 'passport_expiry', sanitize_text_field($_POST['passport_expiry'] ?? ''));
    update_post_meta($booking_id, 'hotel_pickup', sanitize_text_field($_POST['hotel_pickup'] ?? ''));
    update_post_meta($booking_id, 'certification_level', sanitize_text_field($_POST['certification_level'] ?? ''));
    update_post_meta($booking_id, 'dives_count', intval($_POST['dives_count'] ?? 0));
    update_post_meta($booking_id, 'status', 'checked-in');
    wp_send_json_success(array('message' => __('Check-in completed!', 'babarida-dive')));
}

// Newsletter Subscribe
add_action('wp_ajax_bdc_subscribe_newsletter', 'bdc_subscribe_newsletter');
add_action('wp_ajax_nopriv_bdc_subscribe_newsletter', 'bdc_subscribe_newsletter');
function bdc_subscribe_newsletter() {
    check_ajax_referer('bdc_nonce', 'nonce');
    $email = sanitize_email($_POST['email'] ?? '');
    if (!is_email($email)) wp_send_json_error(array('message' => __('Invalid email address.', 'babarida-dive')));
    $exists = get_posts(array('post_type' => 'bdc_newsletter_sub', 'meta_key' => 'subscriber_email', 'meta_value' => $email, 'posts_per_page' => 1));
    if ($exists) wp_send_json_error(array('message' => __('You are already subscribed.', 'babarida-dive')));
    wp_insert_post(array(
        'post_title'  => $email,
        'post_type'   => 'bdc_newsletter_sub',
        'post_status' => 'publish',
        'meta_input'  => array('subscriber_email' => $email, 'subscribed_at' => current_time('mysql')),
    ));
    wp_send_json_success(array('message' => __('Successfully subscribed!', 'babarida-dive')));
}

// AI Chat
add_action('wp_ajax_bdc_ai_chat', 'bdc_ai_chat');
add_action('wp_ajax_nopriv_bdc_ai_chat', 'bdc_ai_chat');
function bdc_ai_chat() {
    check_ajax_referer('bdc_nonce', 'nonce');
    $message = sanitize_text_field($_POST['message'] ?? '');
    $response = BDC_AI_Chat::get_response($message);
    wp_send_json_success(array('reply' => $response));
}

// Currency Switch
add_action('wp_ajax_bdc_switch_currency', 'bdc_switch_currency');
add_action('wp_ajax_nopriv_bdc_switch_currency', 'bdc_switch_currency');
function bdc_switch_currency() {
    $currency = sanitize_text_field($_POST['currency'] ?? 'USD');
    $valid = array('USD', 'IDR', 'EUR', 'SGD', 'AUD');
    if (!in_array($currency, $valid)) wp_send_json_error();
    setcookie('bdc_currency', $currency, time() + (86400 * 30), '/');
    wp_send_json_success(array('currency' => $currency));
}

// Filter Products (AJAX)
add_action('wp_ajax_bdc_filter_products', 'bdc_filter_products');
add_action('wp_ajax_nopriv_bdc_filter_products', 'bdc_filter_products');
function bdc_filter_products() {
    $args = array(
        'post_type'      => sanitize_text_field($_POST['post_type'] ?? 'bdc_trip'),
        'posts_per_page' => intval($_POST['per_page'] ?? 9),
        'paged'          => intval($_POST['page'] ?? 1),
        'orderby'        => sanitize_text_field($_POST['orderby'] ?? 'date'),
        'order'          => sanitize_text_field($_POST['order'] ?? 'DESC'),
    );
    $tax_query = array();
    if (!empty($_POST['destination'])) {
        $tax_query[] = array('taxonomy' => 'bdc_destination', 'field' => 'slug', 'terms' => sanitize_text_field($_POST['destination']));
    }
    if (!empty($_POST['activity'])) {
        $tax_query[] = array('taxonomy' => 'bdc_activity', 'field' => 'slug', 'terms' => sanitize_text_field($_POST['activity']));
    }
    if (!empty($_POST['price_min']) || !empty($_POST['price_max'])) {
        $args['meta_query'] = array(
            array(
                'key'     => 'price_usd',
                'value'   => array(intval($_POST['price_min'] ?? 0), intval($_POST['price_max'] ?? 99999)),
                'compare' => 'BETWEEN',
                'type'    => 'NUMERIC',
            ),
        );
    }
    if (!empty($tax_query)) {
        $tax_query['relation'] = 'AND';
        $args['tax_query'] = $tax_query;
    }
    $query = new WP_Query($args);
    ob_start();
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            get_template_part('template-parts/card', get_post_type());
        endwhile;
    else :
        echo '<p class="text-center" style="grid-column:1/-1;padding:40px;color:var(--mid-gray);">' . __('No results found.', 'babarida-dive') . '</p>';
    endif;
    wp_reset_postdata();
    $html = ob_get_clean();
    wp_send_json_success(array(
        'html'       => $html,
        'total'      => $query->found_posts,
        'max_pages'  => $query->max_num_pages,
    ));
}

// Weather Data
add_action('wp_ajax_bdc_get_weather', 'bdc_get_weather');
add_action('wp_ajax_nopriv_bdc_get_weather', 'bdc_get_weather');
function bdc_get_weather() {
    $weather = BDC_Weather_API::get_current();
    wp_send_json_success($weather);
}

// ============================================================
// SCHEMA MARKUP OUTPUT
// ============================================================
function bdc_output_schema() {
    if (is_singular(array('bdc_trip', 'bdc_liveaboard', 'bdc_destination'))) {
        global $post;
        $price = get_post_meta($post->ID, 'price_usd', true);
        $schema = array(
            '@context'  => 'https://schema.org',
            '@type'     => 'TouristTrip',
            'name'      => get_the_title(),
            'description' => wp_strip_all_tags(get_the_excerpt()),
            'url'       => get_permalink(),
            'image'     => get_the_post_thumbnail_url($post->ID, 'full'),
            'offers'    => array(
                '@type'         => 'Offer',
                'price'         => $price ? $price : '0',
                'priceCurrency' => 'USD',
                'availability'  => 'https://schema.org/InStock',
            ),
        );
        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
    }
}
add_action('wp_head', 'bdc_output_schema');

// ============================================================
// CUSTOM LOGIN PAGE
// ============================================================
function bdc_custom_login() {
    if (isset($_GET['bdc-login'])) {
        include BDC_DIR . '/templates/login.php';
        exit;
    }
}
add_action('init', 'bdc_custom_login');

// Redirect wp-login to custom login
function bdc_redirect_login() {
    global $pagenow;
    if ($pagenow === 'wp-login.php' && !isset($_REQUEST['action']) && !isset($_REQUEST['loggedout'])) {
        wp_redirect(home_url('/wp-login.php?bdc-login=1'));
        exit;
    }
}
add_action('init', 'bdc_redirect_login');

// ============================================================
// SITEMAP & ROBOTS
// ============================================================
function bdc_generate_sitemap() {
    if (isset($_GET['sitemap']) && $_GET['sitemap'] === 'xml') {
        header('Content-Type: application/xml; charset=utf-8');
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $post_types = array('page', 'post', 'bdc_destination', 'bdc_trip', 'bdc_liveaboard', 'bdc_hotel', 'bdc_course', 'bdc_watersport', 'bdc_faq');
        foreach ($post_types as $pt) {
            $posts = get_posts(array('post_type' => $pt, 'posts_per_page' => -1, 'post_status' => 'publish'));
            foreach ($posts as $p) {
                $mod = get_post_modified_time('Y-m-d\TH:i:s+00:00', false, $p);
                $freq = $pt === 'post' ? 'weekly' : 'monthly';
                $pri = $pt === 'page' ? '0.8' : '0.6';
                if ($pt === 'bdc_destination') $pri = '0.9';
                echo "<url><loc>" . get_permalink($p) . "</loc><lastmod>$mod</lastmod><changefreq>$freq</changefreq><priority>$pri</priority></url>";
            }
        }
        echo '</urlset>';
        exit;
    }
}
add_action('init', 'bdc_generate_sitemap');

function bdc_robots_txt() {
    if (isset($_GET['robots']) && $_GET['robots'] === 'txt') {
        header('Content-Type: text/plain; charset=utf-8');
        echo "User-agent: *\n";
        echo "Allow: /\n";
        echo "Disallow: /wp-admin/\n";
        echo "Disallow: /wp-includes/\n";
        echo "Disallow: /?s=\n";
        echo "Sitemap: " . home_url('/?sitemap=xml') . "\n";
        exit;
    }
}
add_action('init', 'bdc_robots_txt');

// Add rewrite rules for sitemap/robots
function bdc_rewrite_rules() {
    add_rewrite_rule('^sitemap\\.xml$', 'index.php?sitemap=xml', 'top');
    add_rewrite_rule('^robots\\.txt$', 'index.php?robots=txt', 'top');
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
// Remove WordPress version
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'rest_output_link_wp_head');

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Login attempts limiter
function bdc_login_limiter($user) {
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $ip = $_SERVER['REMOTE_ADDR'];
        $attempts = get_transient('bdc_login_' . $ip);
        if ($attempts && $attempts >= 5) {
            wp_die(__('Too many login attempts. Please try again in 15 minutes.', 'babarida-dive'));
        }
        set_transient('bdc_login_' . $ip, ($attempts ? $attempts + 1 : 1), 900);
    }
    return $user;
}
add_filter('authenticate', 'bdc_login_limiter', 30);

// Clear login attempts on success
function bdc_clear_login_limiter($user) {
    if (!is_wp_error($user)) {
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
    header("Content-Security-Policy: default-src 'self' 'unsafe-inline' 'unsafe-eval' https: data: blob:;");
}
add_action('send_headers', 'bdc_security_headers');

// Sanitize uploads
function bdc_disallow_upload_types($types) {
    unset($types['php'], $types['php4'], $types['php5'], $types['phtml'], $types['exe'], $types['js'], $types['html'], $types['htm']);
    return $types;
}
add_filter('upload_mimes', 'bdc_disallow_upload_types');

// ============================================================
// PERFORMANCE OPTIMIZATIONS
// ============================================================
// Defer non-critical JS
function bdc_defer_js($tag, $handle) {
    $defer = array('lucide-icons', 'bdc-main', 'bdc-clocks', 'bdc-booking');
    if (in_array($handle, $defer)) {
        return str_replace(' src=', ' defer src=', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'bdc_defer_js', 10, 2);

// Remove emoji scripts
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Lazy load images natively
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
        echo '<link rel="preload" as="image" href="' . esc_url($hero_img) . '">' . "\n";
    }
}
add_action('wp_head', 'bdc_preload_hero', 1);

// ============================================================
// GUTENBERG COMPATIBILITY
// ============================================================
function bdc_gutenberg_colors() {
    add_theme_support('editor-color-palette', array(
        array('name' => __('Deep Ocean', 'babarida-dive'), 'slug' => 'deep-ocean', 'color' => '#001D3D'),
        array('name' => __('Mid Ocean', 'babarida-dive'), 'slug' => 'mid-ocean', 'color' => '#003566'),
        array('name' => __('Bright Blue', 'babarida-dive'), 'slug' => 'bright-blue', 'color' => '#0077B6'),
        array('name' => __('Sky Blue', 'babarida-dive'), 'slug' => 'sky-blue', 'color' => '#00B4D8'),
        array('name' => __('Tropical Yellow', 'babarida-dive'), 'slug' => 'tropical-yellow', 'color' => '#FFB703'),
        array('name' => __('Golden', 'babarida-dive'), 'slug' => 'golden', 'color' => '#FB8500'),
        array('name' => __('Coral', 'babarida-dive'), 'slug' => 'coral', 'color' => '#E07A5F'),
        array('name' => __('White', 'babarida-dive'), 'slug' => 'white', 'color' => '#FFFFFF'),
    ));
    add_theme_support('editor-font-sizes', array(
        array('name' => __('Small', 'babarida-dive'), 'slug' => 'small', 'size' => 13),
        array('name' => __('Normal', 'babarida-dive'), 'slug' => 'normal', 'size' => 16),
        array('name' => __('Medium', 'babarida-dive'), 'slug' => 'medium', 'size' => 20),
        array('name' => __('Large', 'babarida-dive'), 'slug' => 'large', 'size' => 28),
        array('name' => __('Huge', 'babarida-dive'), 'slug' => 'huge', 'size' => 42),
    ));
}
add_action('after_setup_theme', 'bdc_gutenberg_colors');

// ============================================================
// EXCERPT LENGTH
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
    if (is_front_page()) $classes[] = 'home';
    if (is_singular()) $classes[] = 'singular';
    if (wp_is_mobile()) $classes[] = 'mobile';
    return $classes;
}
add_filter('body_class', 'bdc_body_classes');

// ============================================================
// PWA SUPPORT
// ============================================================
function bdc_pwa_headers() {
    header('Service-Worker-Allowed: /');
}
add_action('send_headers', 'bdc_pwa_headers');

// ============================================================
// ACTIVATION HOOK
// ============================================================
function bdc_activate() {
    // Flush rewrite rules
    flush_rewrite_rules();
    // Create essential pages if not exist
    $pages = array(
        'check-in' => array('title' => 'Check-In', 'template' => 'templates/check-in.php'),
        'booking'  => array('title' => 'Book Now', 'template' => 'templates/booking-form.php'),
    );
    foreach ($pages as $slug => $page) {
        if (!get_page_by_path($slug)) {
            $id = wp_insert_post(array(
                'post_title'  => $page['title'],
                'post_name'   => $slug,
                'post_status' => 'publish',
                'post_type'   => 'page',
            ));
            if ($id && !empty($page['template'])) {
                update_post_meta($id, '_wp_page_template', $page['template']);
            }
        }
    }
}
register_activation_hook(__FILE__, 'bdc_activate');

function bdc_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'bdc_deactivate');
