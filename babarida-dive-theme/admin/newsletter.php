<?php defined('ABSPATH') || exit;
 $count = BDC_Newsletter::get_subscriber_count();
?>
<div class="wrap">
    <h1 style="font-family:Playfair Display,serif;"><?php esc_html_e('Newsletter', 'babarida-dive'); ?></h1>
    <div class="bdc-card" style="margin-top:20px;text-align:center;">
        <div style="font-size:48px;font-weight:700;color:var(--bright-blue);"><?php echo esc_html($count); ?></div>
        <div style="color:var(--mid-gray);"><?php esc_html_e('Total Subscribers', 'babarida-dive'); ?></div>
    </div>
    <div class="bdc-card" style="margin-top:20px;">
        <h3><?php esc_html_e('Send Campaign', 'babarida-dive'); ?></h3>
        <div class="form-group"><label><?php esc_html_e('Subject', 'babarida-dive'); ?></label><input type="text" id="newsletter-subject" class="regular-text" style="width:100%;"></div>
        <div class="form-group"><label><?php esc_html_e('Content (HTML)', 'babarida-dive'); ?></label><textarea id="newsletter-body" rows="8" style="width:100%;"></textarea></div>
        <div style="display:flex;gap:8px;">
            <button class="button" id="newsletter-test"><?php esc_html_e('Send Test', 'babarida-dive'); ?></button>
            <button class="button button-primary" id="newsletter-send-all"><?php esc_html_e('Send to All', 'babarida-dive'); ?></button>
        </div>
    </div>
</div>
