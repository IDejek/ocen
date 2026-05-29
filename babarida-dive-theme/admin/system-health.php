<?php defined('ABSPATH') || exit;
 $health = BDC_System_Health::get_status();
?>
<div class="wrap">
    <h1 style="font-family:Playfair Display,serif;"><?php esc_html_e('System Health', 'babarida-dive'); ?></h1>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:20px;">
        <?php
        $items = array(
            array('label' => 'PHP Version', 'value' => $health['php_version'], 'ok' => $health['php_ok']),
            array('label' => 'WordPress', 'value' => $health['wp_version'], 'ok' => true),
            array('label' => 'Theme', 'value' => 'v' . $health['theme_version'], 'ok' => true),
            array('label' => 'Memory Limit', 'value' => $health['memory_limit'], 'ok' => $health['memory_ok']),
            array('label' => 'Max Execution', 'value' => $health['max_execution'] . 's', 'ok' => true),
            array('label' => 'Database Size', 'value' => $health['db_size'], 'ok' => true),
            array('label' => 'Upload Size', 'value' => $health['upload_dir'], 'ok' => true),
            array('label' => 'Active Plugins', 'value' => $health['plugins_active'], 'ok' => true),
            array('label' => 'SSL', 'value' => $health['ssl_ok'] ? 'Active' : 'Inactive', 'ok' => $health['ssl_ok']),
        );
        foreach ($items as $item) :
        ?>
        <div class="bdc-card" style="display:flex;align-items:center;gap:12px;">
            <div style="width:12px;height:12px;border-radius:50%;background:<?php echo $item['ok'] ? '#10B981' : '#EF4444'; ?>;flex-shrink:0;"></div>
            <div>
                <div style="font-size:12px;color:var(--mid-gray);"><?php echo esc_html($item['label']); ?></div>
                <div style="font-weight:600;"><?php echo esc_html($item['value']); ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
