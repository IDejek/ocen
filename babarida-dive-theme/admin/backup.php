<?php defined('ABSPATH') || exit;
if (isset($_GET['bdc_do_backup'])) {
    check_admin_referer('bdc_backup_nonce');
    $url = BDC_Backup_System::create_backup();
    BDC_Activity_Logger::log('Manual backup created');
    echo '<div class="notice notice-success"><p>' . sprintf(__('Backup created: %s', 'babarida-dive'), '<a href="' . esc_url($url) . '" target="_blank">' . esc_html($url) . '</a>') . '</p></div>';
}
?>
<div class="wrap">
    <h1 style="font-family:Playfair Display,serif;"><?php esc_html_e('Backup & Restore', 'babarida-dive'); ?></h1>
    <div class="bdc-card" style="margin-top:20px;">
        <h3><?php esc_html_e('Create Backup', 'babarida-dive'); ?></h3>
        <p style="color:var(--mid-gray);"><?php esc_html_e('Backs up all Babarida Dive Center custom tables (bookings, CRM, settings, etc.) to a SQL file.', 'babarida-dive'); ?></p>
        <p><a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=bdc-backup&bdc_do_backup=1'), 'bdc_backup_nonce')); ?>" class="button button-primary"><?php esc_html_e('Create Backup Now', 'babarida-dive'); ?></a></p>
        <p style="margin-top:16px;font-size:13px;color:var(--mid-gray);"><?php esc_html_e('Automated daily backups are also scheduled.', 'babarida-dive'); ?></p>
    </div>
</div>
