<?php
/**
 * Newsletter Section Template Part
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;
?>

<section class="section newsletter-section">
    <div class="container">
        <div class="newsletter-inner reveal">
            <h2 class="newsletter-title"><?php esc_html_e('Stay Updated', 'babarida-dive'); ?></h2>
            <p class="newsletter-desc"><?php esc_html_e('Subscribe to receive diving tips, special offers, and news from North Sulawesi.', 'babarida-dive'); ?></p>
            <form class="newsletter-form" id="newsletter-form" novalidate>
                <?php wp_nonce_field('bdc_nonce', 'newsletter_nonce'); ?>
                <input type="email" id="newsletter-email" placeholder="<?php esc_attr_e('Enter your email address', 'babarida-dive'); ?>" required aria-label="<?php esc_attr_e('Email address', 'babarida-dive'); ?>">
                <button type="submit" class="btn btn-yellow"><?php esc_html_e('Subscribe', 'babarida-dive'); ?></button>
            </form>
            <p style="font-size:12px;color:rgba(255,255,255,0.4);margin-top:12px;"><?php esc_html_e('No spam. Unsubscribe anytime.', 'babarida-dive'); ?></p>
        </div>
    </div>
</section>
