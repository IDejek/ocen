<?php
/**
 * Media Management Admin
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

function bdc_render_media_mgmt() {
    // This integrates with the WordPress Media Library
    // Custom functionality for organizing dive center media
    ?>
    <div class="wrap">
        <h1 style="font-family:Playfair Display,serif;"><?php esc_html_e('Media Management', 'babarida-dive'); ?></h1>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;margin-top:20px;">
            <div class="bdc-card">
                <h3><?php esc_html_e('Hero Media', 'babarida-dive'); ?></h3>
                <p style="font-size:13px;color:var(--mid-gray);margin-bottom:12px;"><?php esc_html_e('Manage hero section video and image from Customize > Hero Section.', 'babarida-dive'); ?></p>
                <a href="<?php echo esc_url(admin_url('customize.php?autofocus[control]=bdc_hero_video')); ?>" class="button"><?php esc_html_e('Edit Hero', 'babarida-dive'); ?></a>
            </div>
            <div class="bdc-card">
                <h3><?php esc_html_e('Media Library', 'babarida-dive'); ?></h3>
                <p style="font-size:13px;color:var(--mid-gray);margin-bottom:12px;"><?php esc_html_e('Access all uploaded images, videos, and documents.', 'babarida-dive'); ?></p>
                <a href="<?php echo esc_url(admin_url('upload.php')); ?>" class="button"><?php esc_html_e('Open Library', 'babarida-dive'); ?></a>
            </div>
            <div class="bdc-card">
                <h3><?php esc_html_e('Image Optimization', 'babarida-dive'); ?></h3>
                <p style="font-size:13px;color:var(--mid-gray);margin-bottom:12px;"><?php esc_html_e('The theme applies lazy loading, WebP-ready attributes, and responsive srcset automatically.', 'babarida-dive'); ?></p>
                <span class="button button-primary" disabled><?php esc_html_e('Auto-Optimized', 'babarida-dive'); ?></span>
            </div>
        </div>
    </div>
    <?php
}
