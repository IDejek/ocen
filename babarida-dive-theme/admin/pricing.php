<?php defined('ABSPATH') || exit; ?>
<div class="wrap">
    <h1 style="font-family:Playfair Display,serif;"><?php esc_html_e('Dynamic Pricing', 'babarida-dive'); ?></h1>
    <p style="color:var(--mid-gray);margin-bottom:20px;"><?php esc_html_e('Set base prices per trip type. Seasonal multipliers are applied automatically: Peak (Jun-Sep) x1.35, High (Apr-May, Oct-Dec) x1.15, Low (Jan-Mar) x1.0', 'babarida-dive'); ?></p>
    <form method="post" action="">
        <?php wp_nonce_field('bdc_pricing_nonce', 'bdc_pricing_nonce_field'); ?>
        <input type="hidden" name="bdc_save_pricing" value="1">
        <table class="wp-list-table widefat striped">
            <thead><tr><th>Trip Type</th><th>Base Price (USD)</th><th>Low Season</th><th>High Season</th><th>Peak Season</th></tr></thead>
            <tbody>
                <?php
                $types = array('day_trip' => 'Day Trip', 'dive_stay' => 'Dive & Stay', 'liveaboard' => 'Liveaboard', 'course' => 'Dive Course', 'snorkeling' => 'Snorkeling', 'watersport' => 'Water Sport');
                foreach ($types as $key => $label) :
                    $base = get_option('bdc_base_price_' . $key, 100);
                ?>
                <tr>
                    <td><strong><?php echo esc_html($label); ?></strong></td>
                    <td><input type="number" name="price_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($base); ?>" style="width:100px;padding:6px;"> USD</td>
                    <td>$<?php echo esc_html(number_format($base)); ?></td>
                    <td>$<?php echo esc_html(number_format($base * 1.15)); ?></td>
                    <td>$<?php echo esc_html(number_format($base * 1.35)); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p style="margin-top:16px;"><button type="submit" class="button button-primary"><?php esc_html_e('Save Prices', 'babarida-dive'); ?></button></p>
    </form>
    <?php
    if (isset($_POST['bdc_save_pricing'])) {
        check_admin_referer('bdc_pricing_nonce', 'bdc_pricing_nonce_field');
        foreach ($types as $key => $label) {
            if (isset($_POST['price_' . $key])) update_option('bdc_base_price_' . $key, intval($_POST['price_' . $key]));
        }
        echo '<div class="notice notice-success"><p>' . esc_html__('Prices saved.', 'babarida-dive') . '</p></div>';
    }
    ?>
</div>
