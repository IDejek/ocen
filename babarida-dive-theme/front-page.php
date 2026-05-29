<?php
/**
 * Front Page Template
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;
get_header();
?>

<main id="main-content" role="main">

    <!-- Hero Section -->
    <?php get_template_part('template-parts/hero'); ?>

    <!-- Welcome Section -->
    <?php get_template_part('template-parts/welcome'); ?>

    <!-- Destinations Section -->
    <?php get_template_part('template-parts/destinations'); ?>

    <!-- Liveaboards Section -->
    <?php get_template_part('template-parts/liveaboards'); ?>

    <!-- Weather & Ocean Conditions -->
    <section class="section section-bg-dark" id="weather-section">
        <div class="container">
            <div class="section-header reveal">
                <div class="section-label" style="color:var(--aqua);">
                    <span style="background:var(--aqua);"></span>
                    <?php esc_html_e('Ocean Conditions', 'babarida-dive'); ?>
                    <span style="background:var(--aqua);"></span>
                </div>
                <h2 class="section-title"><?php esc_html_e('Current Diving Conditions', 'babarida-dive'); ?></h2>
            </div>
            <div class="weather-bar reveal" id="weather-bar">
                <div class="weather-item">
                    <div class="weather-icon">☀️</div>
                    <div class="weather-value" id="w-temp">--°C</div>
                    <div class="weather-label"><?php esc_html_e('Air Temp', 'babarida-dive'); ?></div>
                </div>
                <div class="weather-item">
                    <div class="weather-icon">🌊</div>
                    <div class="weather-value" id="w-water">--°C</div>
                    <div class="weather-label"><?php esc_html_e('Water Temp', 'babarida-dive'); ?></div>
                </div>
                <div class="weather-item">
                    <div class="weather-icon">👁️</div>
                    <div class="weather-value" id="w-vis">-- m</div>
                    <div class="weather-label"><?php esc_html_e('Visibility', 'babarida-dive'); ?></div>
                </div>
                <div class="weather-item">
                    <div class="weather-icon">💨</div>
                    <div class="weather-value" id="w-wind">-- km/h</div>
                    <div class="weather-label"><?php esc_html_e('Wind Speed', 'babarida-dive'); ?></div>
                </div>
                <div class="weather-item">
                    <div class="weather-icon">↕️</div>
                    <div class="weather-value" id="w-tide">-- m</div>
                    <div class="weather-label"><?php esc_html_e('Tide', 'babarida-dive'); ?></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Hotels Section -->
    <?php get_template_part('template-parts/hotels'); ?>

    <!-- Pricing Section -->
    <?php get_template_part('template-parts/pricing'); ?>

    <!-- Map Section -->
    <?php get_template_part('template-parts/map'); ?>

    <!-- Testimonials Section -->
    <?php get_template_part('template-parts/testimonials'); ?>

    <!-- Partners Section -->
    <?php get_template_part('template-parts/partners'); ?>

</main>

<?php get_footer(); ?>
