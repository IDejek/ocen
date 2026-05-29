<?php
/**
 * Sidebar
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;
if (!is_active_sidebar('sidebar-1')) return;
?>

<aside class="archive-sidebar" role="complementary">
    <?php dynamic_sidebar('sidebar-1'); ?>

    <div class="glass-card" style="padding:24px;margin-top:24px;">
        <h4 style="font-size:16px;font-weight:700;margin-bottom:16px;"><?php esc_html_e('Filter by Price', 'babarida-dive'); ?></h4>
        <div class="form-group">
            <label class="form-label"><?php esc_html_e('Min Price (USD)', 'babarida-dive'); ?></label>
            <input type="number" class="form-input price-range" id="sidebar-price-min" min="0" placeholder="0">
        </div>
        <div class="form-group">
            <label class="form-label"><?php esc_html_e('Max Price (USD)', 'babarida-dive'); ?></label>
            <input type="number" class="form-input price-range" id="sidebar-price-max" min="0" placeholder="9999">
        </div>
    </div>

    <div class="glass-card" style="padding:24px;margin-top:24px;">
        <h4 style="font-size:16px;font-weight:700;margin-bottom:16px;"><?php esc_html_e('Need Help?', 'babarida-dive'); ?></h4>
        <p style="font-size:14px;color:var(--mid-gray);margin-bottom:16px;"><?php esc_html_e('Our team is ready to help you plan the perfect diving trip.', 'babarida-dive'); ?></p>
        <a href="https://wa.me/62895801960359" class="btn btn-yellow btn-sm" target="_blank" rel="noopener" style="width:100%;">
            <?php esc_html_e('Chat on WhatsApp', 'babarida-dive'); ?>
        </a>
    </div>
</aside>
