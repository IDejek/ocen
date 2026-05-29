<?php defined('ABSPATH') || exit;
 $today = BDC_Booking_System::get_booking_stats('today');
 $month = BDC_Booking_System::get_booking_stats('month');
 $year  = BDC_Booking_System::get_booking_stats('year');
?>
<div class="wrap">
    <h1 style="font-family:Playfair Display,serif;"><?php esc_html_e('Analytics & Reports', 'babarida-dive'); ?></h1>
    <div style="display:flex;gap:12px;margin:20px 0;">
        <button class="button button-primary" onclick="bdcShowReport('daily')"><?php esc_html_e('Daily', 'babarida-dive'); ?></button>
        <button class="button" onclick="bdcShowReport('weekly')"><?php esc_html_e('Weekly', 'babarida-dive'); ?></button>
        <button class="button" onclick="bdcShowReport('monthly')"><?php esc_html_e('Monthly', 'babarida-dive'); ?></button>
        <button class="button" onclick="bdcShowReport('annual')"><?php esc_html_e('Annual', 'babarida-dive'); ?></button>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:24px;">
        <div class="bdc-card" style="text-align:center;">
            <div style="font-size:13px;color:var(--mid-gray);text-transform:uppercase;letter-spacing:1px;"><?php esc_html_e('Today', 'babarida-dive'); ?></div>
            <div style="font-size:36px;font-weight:700;color:var(--bright-blue);margin:8px 0;"><?php echo esc_html($today['total']); ?></div>
            <div style="font-size:14px;color:var(--mid-gray);"><?php esc_html_e('bookings', 'babarida-dive'); ?></div>
            <div style="font-size:20px;font-weight:600;color:var(--success);margin-top:8px;">$<?php echo number_format($today['revenue'], 0); ?></div>
            <div style="font-size:12px;color:var(--mid-gray);"><?php esc_html_e('revenue', 'babarida-dive'); ?></div>
        </div>
        <div class="bdc-card" style="text-align:center;">
            <div style="font-size:13px;color:var(--mid-gray);text-transform:uppercase;letter-spacing:1px;"><?php esc_html_e('This Month', 'babarida-dive'); ?></div>
            <div style="font-size:36px;font-weight:700;color:var(--bright-blue);margin:8px 0;"><?php echo esc_html($month['total']); ?></div>
            <div style="font-size:14px;color:var(--mid-gray);"><?php esc_html_e('bookings', 'babarida-dive'); ?></div>
            <div style="font-size:20px;font-weight:600;color:var(--success);margin-top:8px;">$<?php echo number_format($month['revenue'], 0); ?></div>
            <div style="font-size:12px;color:var(--mid-gray);"><?php esc_html_e('revenue', 'babarida-dive'); ?></div>
        </div>
        <div class="bdc-card" style="text-align:center;">
            <div style="font-size:13px;color:var(--mid-gray);text-transform:uppercase;letter-spacing:1px;"><?php esc_html_e('This Year', 'babarida-dive'); ?></div>
            <div style="font-size:36px;font-weight:700;color:var(--bright-blue);margin:8px 0;"><?php echo esc_html($year['total']); ?></div>
            <div style="font-size:14px;color:var(--mid-gray);"><?php esc_html_e('bookings', 'babarida-dive'); ?></div>
            <div style="font-size:20px;font-weight:600;color:var(--success);margin-top:8px;">$<?php echo number_format($year['revenue'], 0); ?></div>
            <div style="font-size:12px;color:var(--mid-gray);"><?php esc_html_e('revenue', 'babarida-dive'); ?></div>
        </div>
    </div>
    <div class="bdc-card">
        <h3><?php esc_html_e('Booking Status Breakdown (This Month)', 'babarida-dive'); ?></h3>
        <div style="display:grid;grid-template-columns:repeat(6,1fr);gap:12px;margin-top:16px;">
            <?php foreach (array('pending','confirmed','paid','checked-in','completed','cancelled') as $s) : ?>
            <div style="text-align:center;padding:16px;background:var(--off-white);border-radius:12px;">
                <div style="font-size:24px;font-weight:700;color:var(--near-black);"><?php echo esc_html($month[$s] ?? 0); ?></div>
                <div style="font-size:12px;color:var(--mid-gray);text-transform:capitalize;"><?php echo esc_html($s); ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
