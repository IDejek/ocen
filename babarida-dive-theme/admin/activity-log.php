<?php defined('ABSPATH') || exit;
 $logs = BDC_Activity_Logger::get_logs();
?>
<div class="wrap">
    <h1 style="font-family:Playfair Display,serif;"><?php esc_html_e('Activity Log', 'babarida-dive'); ?></h1>
    <table class="wp-list-table widefat fixed striped" style="margin-top:20px;">
        <thead><tr><th>Time</th><th>Action</th><th>Details</th><th>User</th><th>IP</th></tr></thead>
        <tbody>
            <?php foreach ($logs as $l) :
                $user = get_user_by('id', get_post_meta($l->ID, 'user_id', true));
            ?>
            <tr>
                <td><?php echo esc_html(get_post_meta($l->ID, 'timestamp', true)); ?></td>
                <td><strong><?php echo esc_html(get_post_meta($l->ID, 'action', true)); ?></strong></td>
                <td><?php echo esc_html(get_post_meta($l->ID, 'details', true)); ?></td>
                <td><?php echo $user ? esc_html($user->display_name) : 'System'; ?></td>
                <td style="font-family:monospace;font-size:12px;"><?php echo esc_html(get_post_meta($l->ID, 'ip_address', true)); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
