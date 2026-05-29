<?php
defined('ABSPATH') || exit;

class BDC_Role_Manager {

    public static function init() {
        self::register_roles();
        add_filter('map_meta_cap', array(__CLASS__, 'map_meta_cap'), 10, 4);
    }

    public static function register_roles() {
        $roles = array(
            'bdc_general_manager' => array(
                'display_name' => __('General Manager', 'babarida-dive'),
                'capabilities' => array('read', 'bdc_view_bookings', 'bdc_manage_bookings', 'bdc_view_reports', 'bdc_manage_trips', 'bdc_view_analytics'),
            ),
            'bdc_booking_staff' => array(
                'display_name' => __('Booking Staff', 'babarida-dive'),
                'capabilities' => array('read', 'bdc_view_bookings', 'bdc_manage_bookings', 'bdc_send_notifications'),
            ),
            'bdc_dive_guide' => array(
                'display_name' => __('Dive Guide', 'babarida-dive'),
                'capabilities' => array('read', 'bdc_view_assigned_trips', 'bdc_view_guest_manifest'),
            ),
            'bdc_hotel_partner' => array(
                'display_name' => __('Hotel Partner', 'babarida-dive'),
                'capabilities' => array('read', 'bdc_manage_own_hotel', 'bdc_view_own_bookings'),
            ),
            'bdc_liveaboard_partner' => array(
                'display_name' => __('Liveaboard Partner', 'babarida-dive'),
                'capabilities' => array('read', 'bdc_manage_own_boat', 'bdc_view_own_schedule'),
            ),
            'bdc_content_editor' => array(
                'display_name' => __('Content Editor', 'babarida-dive'),
                'capabilities' => array('read', 'edit_posts', 'edit_pages', 'upload_files', 'bdc_manage_blog', 'bdc_manage_seo'),
            ),
            'bdc_finance_staff' => array(
                'display_name' => __('Finance Staff', 'babarida-dive'),
                'capabilities' => array('read', 'bdc_view_bookings', 'bdc_view_reports', 'bdc_manage_invoices', 'bdc_export_finance'),
            ),
        );

        foreach ($roles as $slug => $role) {
            remove_role($slug);
            add_role($slug, $role['display_name'], $role['capabilities']);
        }

        // Add custom caps to administrator
        $admin = get_role('administrator');
        $all_caps = array('bdc_view_bookings', 'bdc_manage_bookings', 'bdc_view_reports', 'bdc_manage_trips', 'bdc_view_analytics', 'bdc_send_notifications', 'bdc_view_assigned_trips', 'bdc_view_guest_manifest', 'bdc_manage_own_hotel', 'bdc_view_own_bookings', 'bdc_manage_own_boat', 'bdc_view_own_schedule', 'bdc_manage_blog', 'bdc_manage_seo', 'bdc_manage_invoices', 'bdc_export_finance', 'bdc_manage_settings', 'bdc_manage_system');
        foreach ($all_caps as $cap) $admin->add_cap($cap);
    }

    public static function map_meta_cap($caps, $cap, $user_id, $args) {
        if (strpos($cap, 'bdc_') === 0) {
            if (user_can($user_id, 'manage_options')) return array('manage_options');
        }
        return $caps;
    }
}
add_action('after_setup_theme', array('BDC_Role_Manager', 'init'));
