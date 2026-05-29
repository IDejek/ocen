<?php
/**
 * Admin Dashboard Page
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

function bdc_admin_dashboard_page() {
    add_menu_page(
        __('Babarida Dashboard', 'babarida-dive'),
        __('Babarida DC', 'babarida-dive'),
        'manage_options',
        'bdc-dashboard',
        'bdc_render_dashboard',
        'dashicons-water',
        2
    );

    // Sub-pages
    $subpages = array(
        'bdc-bookings'     => array(__('Bookings', 'babarida-dive'), __('Bookings', 'babarida-dive'), 'bdc_view_bookings', 'bdc_render_bookings_admin'),
        'bdc-analytics'    => array(__('Analytics', 'babarida-dive'), __('Analytics', 'babarida-dive'), 'bdc_view_reports', 'bdc_render_analytics'),
        'bdc-pricing'      => array(__('Pricing', 'babarida-dive'), __('Pricing', 'babarida-dive'), 'manage_options', 'bdc_render_pricing_admin'),
        'bdc-customers'    => array(__('Customers', 'babarida-dive'), __('Customers', 'babarida-dive'), 'bdc_view_bookings', 'bdc_render_customers_admin'),
        'bdc-seo'          => array(__('SEO', 'babarida-dive'), __('SEO', 'babarida-dive'), 'bdc_manage_seo', 'bdc_render_seo_admin'),
        'bdc-weather'      => array(__('Weather', 'babarida-dive'), __('Weather', 'babarida-dive'), 'manage_options', 'bdc_render_weather_admin'),
        'bdc-activity-log' => array(__('Activity Log', 'babarida-dive'), __('Activity Log', 'babarida-dive'), 'manage_options', 'bdc_render_activity_log'),
        'bdc-chat'         => array(__('Staff Chat', 'babarida-dive'), __('Staff Chat', 'babarida-dive'), 'read', 'bdc_render_chat_admin'),
        'bdc-newsletter'   => array(__('Newsletter', 'babarida-dive'), __('Newsletter', 'babarida-dive'), 'manage_options', 'bdc_render_newsletter_admin'),
        'bdc-backup'       => array(__('Backup', 'babarida-dive'), __('Backup', 'babarida-dive'), 'manage_options', 'bdc_render_backup_admin'),
        'bdc-system'       => array(__('System Health', 'babarida-dive'), __('System Health', 'babarida-dive'), 'manage_options', 'bdc_render_system_admin'),
        'bdc-roles'        => array(__('Roles', 'babarida-dive'), __('Roles', 'babarida-dive'), 'manage_options', 'bdc_render_roles_admin'),
    );

    foreach ($subpages as $slug => $page) {
        add_submenu_page('bdc-dashboard', $page[0], $page[1], $page[2], $slug, $page[3]);
    }
}
add_action('admin_menu', 'bdc_admin_dashboard_page');

function bdc_render_dashboard() {
    $widgets = BDC_Dashboard::get_widgets();
    $recent = BDC_Dashboard::get_recent_bookings(5);
    $popular = BDC_Dashboard::get_popular_destinations();
    ?>
    <div class="bdc-admin-wrap">
        <div class="bdc-admin-main" style="margin-left:0;">
            <div class="bdc-admin-topbar">
                <h1><?php esc_html_e('Dashboard', 'babarida-dive'); ?></h1>
                <span style="color:var(--mid-gray);font-size:14px;"><?php echo esc_html(current_time('F j, Y g:i A')); ?></span>
            </div>

            <div class="bdc-stat-grid">
                <?php foreach ($widgets as $w) : ?>
                <div class="bdc-stat-card">
                    <div class="stat-icon" style="background:<?php echo esc_attr($w['color']); ?>;">
                        <span class="dashicons dashicons-<?php echo esc_attr($w['icon']); ?>"></span>
                    </div>
                    <div class="stat-value"><?php echo esc_html($w['value']); ?></div>
                    <div class="stat-label"><?php echo esc_html($w['label']); ?></div>
                    <div class="stat-change <?php echo $w['up'] ? 'up' : 'down'; ?>">
                        <?php echo $w['up'] ? '↑' : '↓'; ?> <?php echo esc_html($w['change']); ?> vs last period
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;">
                <div class="bdc-card">
                    <h3><?php esc_html_e('Recent Bookings', 'babarida-dive'); ?></h3>
                    <?php if ($recent) : ?>
                    <table class="bdc-table">
                        <thead><tr><th>ID</th><th>Guest</th><th>Trip</th><th>Date</th><th>Status</th></tr></thead>
                        <tbody>
                            <?php foreach ($recent as $b) :
                                $status = get_post_meta($b->ID, 'status', true);
                            ?>
                            <tr>
                                <td><a href="<?php echo esc_url(get_edit_post_link($b->ID)); ?>">BDC-<?php echo $b->ID; ?></a></td>
                                <td><?php echo esc_html(get_post_meta($b->ID, 'name', true)); ?></td>
                                <td><?php echo esc_html(get_post_meta($b->ID, 'trip_type', true)); ?></td>
                                <td><?php echo esc_html(get_post_meta($b->ID, 'date', true)); ?></td>
                                <td><span class="bdc-badge bdc-badge-<?php echo esc_attr($status); ?>"><?php echo esc_html(ucfirst($status)); ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else : ?>
                    <p style="color:var(--mid-gray);"><?php esc_html_e('No bookings yet.', 'babarida-dive'); ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <div class="bdc-card">
                        <h3><?php esc_html_e('Popular Destinations', 'babarida-dive'); ?></h3>
                        <?php if ($popular) : ?>
                        <?php foreach ($popular as $p) : ?>
                        <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #f0f0f0;">
                            <span style="font-weight:500;"><?php echo esc_html(ucfirst($p->dest)); ?></span>
                            <span style="color:var(--bright-blue);font-weight:600;"><?php echo esc_html($p->count); ?> <?php esc_html_e('bookings', 'babarida-dive'); ?></span>
                        </div>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <p style="color:var(--mid-gray);"><?php esc_html_e('No data yet.', 'babarida-dive'); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="bdc-card" style="margin-top:24px;">
                        <h3><?php esc_html_e('Quick Actions', 'babarida-dive'); ?></h3>
                        <div style="display:flex;flex-direction:column;gap:8px;">
                            <a href="<?php echo esc_url(admin_url('post-new.php?post_type=bdc_trip')); ?>" class="button button-primary" style="text-align:center;"><?php esc_html_e('Add New Trip', 'babarida-dive'); ?></a>
                            <a href="<?php echo esc_url(admin_url('post-new.php?post_type=bdc_liveaboard')); ?>" class="button" style="text-align:center;"><?php esc_html_e('Add Liveaboard', 'babarida-dive'); ?></a>
                            <a href="<?php echo esc_url(admin_url('edit.php?post_type=bdc_booking')); ?>" class="button" style="text-align:center;"><?php esc_html_e('View All Bookings', 'babarida-dive'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

// Stubs for sub-pages
function bdc_render_bookings_admin() { include BDC_ADMIN . 'bookings.php'; }
function bdc_render_analytics() { include BDC_ADMIN . 'analytics.php'; }
function bdc_render_pricing_admin() { include BDC_ADMIN . 'pricing.php'; }
function bdc_render_customers_admin() { include BDC_ADMIN . 'customers.php'; }
function bdc_render_seo_admin() { include BDC_ADMIN . 'seo-panel.php'; }
function bdc_render_weather_admin() { include BDC_ADMIN . 'weather-panel.php'; }
function bdc_render_activity_log() { include BDC_ADMIN . 'activity-log.php'; }
function bdc_render_chat_admin() { include BDC_ADMIN . 'chat.php'; }
function bdc_render_newsletter_admin() { include BDC_ADMIN . 'newsletter.php'; }
function bdc_render_backup_admin() { include BDC_ADMIN . 'backup.php'; }
function bdc_render_system_admin() { include BDC_ADMIN . 'system-health.php'; }
function bdc_render_roles_admin() { include BDC_ADMIN . 'roles.php'; }
