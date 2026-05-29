<?php defined('ABSPATH') || exit;
 $roles = array(
    'bdc_general_manager' => __('General Manager', 'babarida-dive'),
    'bdc_booking_staff'   => __('Booking Staff', 'babarida-dive'),
    'bdc_dive_guide'      => __('Dive Guide', 'babarida-dive'),
    'bdc_hotel_partner'   => __('Hotel Partner', 'babarida-dive'),
    'bdc_liveaboard_partner' => __('Liveaboard Partner', 'babarida-dive'),
    'bdc_content_editor'  => __('Content Editor', 'babarida-dive'),
    'bdc_finance_staff'   => __('Finance Staff', 'babarida-dive'),
);
?>
<div class="wrap">
    <h1 style="font-family:Playfair Display,serif;"><?php esc_html_e('Role Management', 'babarida-dive'); ?></h1>
    <p style="color:var(--mid-gray);margin-bottom:20px;"><?php esc_html_e('Custom roles for Babarida Dive Center. Roles are registered on theme activation.', 'babarida-dive'); ?></p>
    <table class="wp-list-table widefat striped">
        <thead><tr><th>Role</th><th>Display Name</th><th>Users Count</th><th>Capabilities</th></tr></thead>
        <tbody>
            <?php foreach ($roles as $slug => $name) :
                $role = get_role($slug);
                $users = get_users(array('role' => $slug, 'count_total' => true));
                $count = is_wp_error($users) ? 0 : $users;
            ?>
            <tr>
                <td><code><?php echo esc_html($slug); ?></code></td>
                <td><strong><?php echo esc_html($name); ?></strong></td>
                <td><?php echo esc_html($count); ?></td>
                <td style="font-size:12px;"><?php echo $role ? esc_html(implode(', ', array_keys($role->capabilities))) : '-'; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="bdc-card" style="margin-top:24px;">
        <h3><?php esc_html_e('Re-register Roles', 'babarida-dive'); ?></h3>
        <p style="color:var(--mid-gray);font-size:13px;"><?php esc_html_e('Use this if roles are missing after an update.', 'babarida-dive'); ?></p>
        <?php if (isset($_GET['bdc_reregister_roles']) && check_admin_referer('bdc_roles_nonce')) {
            BDC_Role_Manager::init();
            echo '<div class="notice notice-success"><p>' . esc_html__('Roles re-registered successfully.', 'babarida-dive') . '</p></div>';
        } ?>
        <p><a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=bdc-roles&bdc_reregister_roles=1'), 'bdc_roles_nonce')); ?>" class="button"><?php esc_html_e('Re-register All Roles', 'babarida-dive'); ?></a></p>
    </div>
</div>
