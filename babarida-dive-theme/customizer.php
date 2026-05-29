<?php
/**
 * WordPress Customizer Integration
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

function bdc_customizer($wp_customize) {

    // ---- Hero Section ----
    $wp_customize->add_section('bdc_hero', array(
        'title'    => __('Hero Section', 'babarida-dive'),
        'priority' => 30,
    ));
    $wp_customize->add_setting('bdc_hero_video', array('default' => '', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control('bdc_hero_video', array('label' => __('Hero Video URL (MP4)', 'babarida-dive'), 'section' => 'bdc_hero', 'type' => 'url'));
    $wp_customize->add_setting('bdc_hero_image', array('default' => '', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'bdc_hero_image', array('label' => __('Hero Fallback Image', 'babarida-dive'), 'section' => 'bdc_hero')));
    $wp_customize->add_setting('bdc_hero_title', array('default' => 'Babarida Dive Center', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('bdc_hero_title', array('label' => __('Hero Title', 'babarida-dive'), 'section' => 'bdc_hero', 'type' => 'text'));
    $wp_customize->add_setting('bdc_hero_slogan', array('default' => 'The quality of your dive adventure depends on who guides you!', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('bdc_hero_slogan', array('label' => __('Hero Slogan', 'babarida-dive'), 'section' => 'bdc_hero', 'type' => 'text'));

    // ---- Contact Info ----
    $wp_customize->add_section('bdc_contact', array('title' => __('Contact Information', 'babarida-dive'), 'priority' => 31));
    $wp_customize->add_setting('bdc_whatsapp', array('default' => '+62895801960359', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('bdc_whatsapp', array('label' => __('WhatsApp Number', 'babarida-dive'), 'section' => 'bdc_contact'));
    $wp_customize->add_setting('bdc_email', array('default' => 'info@babaridadive.com', 'sanitize_callback' => 'sanitize_email'));
    $wp_customize->add_control('bdc_email', array('label' => __('Email Address', 'babarida-dive'), 'section' => 'bdc_contact'));
    $wp_customize->add_setting('bdc_phone', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('bdc_phone', array('label' => __('Phone Number', 'babarida-dive'), 'section' => 'bdc_contact'));
    $wp_customize->add_setting('bdc_address', array('default' => 'Bunaken Marine Park, Manado, North Sulawesi, Indonesia', 'sanitize_callback' => 'sanitize_textarea_field'));
    $wp_customize->add_control('bdc_address', array('label' => __('Address', 'babarida-dive'), 'section' => 'bdc_contact', 'type' => 'textarea'));

    // ---- Social Media ----
    $wp_customize->add_section('bdc_social', array('title' => __('Social Media', 'babarida-dive'), 'priority' => 32));
    $socials = array('instagram', 'facebook', 'youtube', 'tiktok', 'tripadvisor');
    foreach ($socials as $s) {
        $wp_customize->add_setting('bdc_' . $s, array('default' => '', 'sanitize_callback' => 'esc_url_raw'));
        $wp_customize->add_control('bdc_' . $s, array('label' => ucfirst($s) . ' URL', 'section' => 'bdc_social', 'type' => 'url'));
    }

    // ---- SEO Settings ----
    $wp_customize->add_section('bdc_seo', array('title' => __('SEO Settings', 'babarida-dive'), 'priority' => 33));
    $wp_customize->add_setting('bdc_google_verification', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('bdc_google_verification', array('label' => __('Google Search Console Verification Code', 'babarida-dive'), 'section' => 'bdc_seo'));
    $wp_customize->add_setting('bdc_bing_verification', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('bdc_bing_verification', array('label' => __('Bing Webmaster Verification', 'babarida-dive'), 'section' => 'bdc_seo'));
    $wp_customize->add_setting('bdc_ga4_id', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('bdc_ga4_id', array('label' => __('Google Analytics 4 ID', 'babarida-dive'), 'section' => 'bdc_seo'));
    $wp_customize->add_setting('bdc_gtm_id', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('bdc_gtm_id', array('label' => __('Google Tag Manager ID', 'babarida-dive'), 'section' => 'bdc_seo'));
    $wp_customize->add_setting('bdc_og_image', array('default' => '', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'bdc_og_image', array('label' => __('Default OG Image', 'babarida-dive'), 'section' => 'bdc_seo')));

    // ---- Payment Settings ----
    $wp_customize->add_section('bdc_payment', array('title' => __('Payment Settings', 'babarida-dive'), 'priority' => 34));
    $wp_customize->add_setting('bdc_midtrans_key', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('bdc_midtrans_key', array('label' => __('Midtrans Server Key', 'babarida-dive'), 'section' => 'bdc_payment', 'type' => 'password'));
    $wp_customize->add_setting('bdc_stripe_key', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('bdc_stripe_key', array('label' => __('Stripe Publishable Key', 'babarida-dive'), 'section' => 'bdc_payment'));
    $wp_customize->add_setting('bdc_stripe_secret', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('bdc_stripe_secret', array('label' => __('Stripe Secret Key', 'babarida-dive'), 'section' => 'bdc_payment', 'type' => 'password'));
    $wp_customize->add_setting('bdc_paypal_client', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('bdc_paypal_client', array('label' => __('PayPal Client ID', 'babarida-dive'), 'section' => 'bdc_payment'));
    $wp_customize->add_setting('bdc_xendit_key', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('bdc_xendit_key', array('label' => __('Xendit API Key', 'babarida-dive'), 'section' => 'bdc_payment', 'type' => 'password'));
    $wp_customize->add_setting('bdc_bank_accounts', array('default' => '', 'sanitize_callback' => 'sanitize_textarea_field'));
    $wp_customize->add_control('bdc_bank_accounts', array('label' => __('Bank Transfer Details (one per line: Bank Name|Account Number|Account Name)', 'babarida-dive'), 'section' => 'bdc_payment', 'type' => 'textarea'));

    // ---- Weather API ----
    $wp_customize->add_section('bdc_weather', array('title' => __('Weather API', 'babarida-dive'), 'priority' => 35));
    $wp_customize->add_setting('bdc_weather_api_key', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('bdc_weather_api_key', array('label' => __('OpenWeatherMap API Key', 'babarida-dive'), 'section' => 'bdc_weather'));
    $wp_customize->add_setting('bdc_weather_lat', array('default' => '1.6231', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('bdc_weather_lat', array('label' => __('Latitude', 'babarida-dive'), 'section' => 'bdc_weather'));
    $wp_customize->add_setting('bdc_weather_lon', array('default' => '124.7636', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('bdc_weather_lon', array('label' => __('Longitude', 'babarida-dive'), 'section' => 'bdc_weather'));

    // Output Google verification in head
    if (get_theme_mod('bdc_google_verification')) {
        $wp_customize->get_setting('bdc_google_verification')->transport = 'postMessage';
    }
}
add_action('customize_register', 'bdc_customizer');

// Output SEO meta in head
function bdc_customizer_head() {
    if ($gv = get_theme_mod('bdc_google_verification')) {
        echo '<meta name="google-site-verification" content="' . esc_attr($gv) . '">' . "\n";
    }
    if ($bv = get_theme_mod('bdc_bing_verification')) {
        echo '<meta name="msvalidate.01" content="' . esc_attr($bv) . '">' . "\n";
    }
    if ($ga = get_theme_mod('bdc_ga4_id')) {
        echo "<script async src=\"https://www.googletagmanager.com/gtag/js?id=" . esc_attr($ga) . "\"></script>\n";
        echo "<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','" . esc_attr($ga) . "');</script>\n";
    }
    if ($gtm = get_theme_mod('bdc_gtm_id')) {
        echo "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','" . esc_attr($gtm) . "');</script>\n";
    }
}
add_action('wp_head', 'bdc_customizer_head', 1);
