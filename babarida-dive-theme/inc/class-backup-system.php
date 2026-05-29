<?php
defined('ABSPATH') || exit;

class BDC_Backup_System {

    public static function create_backup() {
        global $wpdb;
        $tables = $wpdb->get_results("SHOW TABLES LIKE '{$wpdb->prefix}bdc_%'", ARRAY_N);
        $sql = "-- BDC Backup " . date('Y-m-d H:i:s') . "\n\n";
        foreach ($tables as $table) {
            $table_name = $table[0];
            $create = $wpdb->get_row("SHOW CREATE TABLE `$table_name`", ARRAY_N);
            $sql .= "DROP TABLE IF EXISTS `$table_name`;\n" . $create[1] . ";\n\n";
            $rows = $wpdb->get_results("SELECT * FROM `$table_name`", ARRAY_A);
            if ($rows) {
                foreach ($rows as $row) {
                    $values = array_map(function($v) use ($wpdb) { return is_null($v) ? 'NULL' : $wpdb->_real_escape($v); }, array_values($row));
                    $sql .= "INSERT INTO `$table_name` VALUES ('" . implode("','", $values) . "');\n";
                }
            }
            $sql .= "\n";
        }

        $upload_dir = wp_upload_dir();
        $filename = 'bdc-backup-' . date('Y-m-d-His') . '.sql';
        $filepath = $upload_dir['basedir'] . '/bdc-backups/' . $filename;
        if (!file_exists($upload_dir['basedir'] . '/bdc-backups/')) {
            mkdir($upload_dir['basedir'] . '/bdc-backups/', 0755, true);
        }
        file_put_contents($filepath, $sql);
        return $upload_dir['baseurl'] . '/bdc-backups/' . $filename;
    }

    public static function schedule_backups() {
        if (!wp_next_scheduled('bdc_daily_backup')) {
            wp_schedule_event(time(), 'daily', 'bdc_daily_backup');
        }
        add_action('bdc_daily_backup', function() {
            self::create_backup();
            BDC_Activity_Logger::log('Automated daily backup completed');
        });
    }
}
BDC_Backup_System::schedule_backups();
