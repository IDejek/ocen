<?php
defined('ABSPATH') || exit;

class BDC_System_Health {

    public static function get_status() {
        global $wpdb;
        $status = array(
            'php_version'    => PHP_VERSION,
            'wp_version'     => get_bloginfo('version'),
            'theme_version'  => BDC_VERSION,
            'memory_limit'   => ini_get('memory_limit'),
            'max_execution'  => ini_get('max_execution_time'),
            'db_size'        => self::get_db_size(),
            'upload_dir'     => self::get_upload_size(),
            'plugins_active' => count(get_option('active_plugins', array())),
        );

        // Check critical
        $status['php_ok'] = version_compare(PHP_VERSION, '8.0', '>=');
        $status['memory_ok'] = intval(ini_get('memory_limit')) >= 256;
        $status['ssl_ok'] = is_ssl() || strpos(home_url(), 'https://') === 0;

        return $status;
    }

    private static function get_db_size() {
        global $wpdb;
        $result = $wpdb->get_row("SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) as size FROM information_schema.TABLES WHERE table_schema = DB_NAME()");
        return $result ? $result->size . ' MB' : 'Unknown';
    }

    private static function get_upload_size() {
        $upload_dir = wp_upload_dir();
        $path = $upload_dir['basedir'];
        if (!is_dir($path)) return '0 MB';
        $size = 0;
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $file) {
            $size += $file->getSize();
        }
        return round($size / 1024 / 1024, 2) . ' MB';
    }
}
