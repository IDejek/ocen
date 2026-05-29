<?php defined('ABSPATH') || exit;
 $weather = BDC_Weather_API::get_current();
?>
<div class="wrap">
    <h1 style="font-family:Playfair Display,serif;"><?php esc_html_e('Weather & Ocean Conditions', 'babarida-dive'); ?></h1>
    <div class="bdc-card" style="margin-top:20px;">
        <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:20px;text-align:center;">
            <div><div style="font-size:32px;font-weight:700;color:var(--bright-blue);"><?php echo esc_html($weather['temp']); ?>°C</div><div style="color:var(--mid-gray);font-size:13px;"><?php esc_html_e('Air Temp', 'babarida-dive'); ?></div></div>
            <div><div style="font-size:32px;font-weight:700;color:var(--bright-blue);"><?php echo esc_html($weather['water']); ?>°C</div><div style="color:var(--mid-gray);font-size:13px;"><?php esc_html_e('Water Temp', 'babarida-dive'); ?></div></div>
            <div><div style="font-size:32px;font-weight:700;color:var(--bright-blue);"><?php echo esc_html($weather['visibility']); ?>m</div><div style="color:var(--mid-gray);font-size:13px;"><?php esc_html_e('Visibility', 'babarida-dive'); ?></div></div>
            <div><div style="font-size:32px;font-weight:700;color:var(--bright-blue);"><?php echo esc_html($weather['wind']); ?>km/h</div><div style="color:var(--mid-gray);font-size:13px;"><?php esc_html_e('Wind', 'babarida-dive'); ?></div></div>
            <div><div style="font-size:32px;font-weight:700;color:var(--bright-blue);"><?php echo esc_html($weather['tide']); ?>m</div><div style="color:var(--mid-gray);font-size:13px;"><?php esc_html_e('Tide', 'babarida-dive'); ?></div></div>
        </div>
        <p style="text-align:center;margin-top:16px;color:var(--mid-gray);"><?php esc_html_e('Condition:', 'babarida-dive'); ?> <?php echo esc_html(ucfirst($weather['condition'])); ?></p>
        <p style="text-align:center;font-size:12px;color:var(--mid-gray);"><?php esc_html_e('Cached for 30 minutes. Configure API key in Customize > Weather API.', 'babarida-dive'); ?></p>
    </div>
</div>
