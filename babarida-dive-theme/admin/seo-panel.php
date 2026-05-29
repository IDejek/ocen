<?php defined('ABSPATH') || exit; ?>
<div class="wrap">
    <h1 style="font-family:Playfair Display,serif;"><?php esc_html_e('SEO Management', 'babarida-dive'); ?></h1>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-top:20px;">
        <div class="bdc-card">
            <h3><?php esc_html_e('Verification Codes', 'babarida-dive'); ?></h3>
            <p style="font-size:13px;color:var(--mid-gray);margin-bottom:16px;"><?php esc_html_e('Also configurable in Appearance > Customize > SEO Settings', 'babarida-dive'); ?></p>
            <div class="form-group"><label><strong>Google Search Console</strong></label><input type="text" value="<?php echo esc_attr(get_theme_mod('bdc_google_verification', '')); ?>" readonly style="width:100%;padding:8px;margin-top:4px;"></div>
            <div class="form-group"><label><strong>Bing Webmaster</strong></label><input type="text" value="<?php echo esc_attr(get_theme_mod('bdc_bing_verification', '')); ?>" readonly style="width:100%;padding:8px;margin-top:4px;"></div>
            <div class="form-group"><label><strong>Google Analytics 4</strong></label><input type="text" value="<?php echo esc_attr(get_theme_mod('bdc_ga4_id', '')); ?>" readonly style="width:100%;padding:8px;margin-top:4px;"></div>
        </div>
        <div class="bdc-card">
            <h3><?php esc_html_e('Sitemap & Indexing', 'babarida-dive'); ?></h3>
            <p style="margin-bottom:12px;"><a href="<?php echo esc_url(home_url('/sitemap.xml')); ?>" class="button" target="_blank"><?php esc_html_e('View Sitemap', 'babarida-dive'); ?></a></p>
            <p style="margin-bottom:12px;"><a href="<?php echo esc_url(home_url('/robots.txt')); ?>" class="button" target="_blank"><?php esc_html_e('View robots.txt', 'babarida-dive'); ?></a></p>
            <p style="margin-bottom:12px;"><a href="https://search.google.com/search-console" class="button" target="_blank"><?php esc_html_e('Open Google Search Console', 'babarida-dive'); ?></a></p>
            <p><a href="https://www.bing.com/webmasters" class="button" target="_blank"><?php esc_html_e('Open Bing Webmaster', 'babarida-dive'); ?></a></p>
        </div>
    </div>
</div>
