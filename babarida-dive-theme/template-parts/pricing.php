<?php
/**
 * Pricing Section Template Part
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

// Generate next 12 months
 $months = array();
for ($m = 0; $m < 12; $m++) {
    $date = new DateTime('first day of +' . $m . ' month');
    $months[] = array(
        'key'  => $date->format('Y-m'),
        'label'=> $date->format('M Y'),
        'month'=> $date->format('n'),
        'year' => $date->format('Y'),
    );
}

// Determine season
function bdc_get_season($month) {
    if (in_array($month, array(6,7,8,9))) return array('peak', 'Peak Season', 'season-peak');
    if (in_array($month, array(4,5,10,11,12))) return array('high', 'High Season', 'season-high');
    return array('low', 'Low Season', 'season-low');
}
?>

<section class="section" id="pricing">
    <div class="container">
        <div class="section-header reveal">
            <div class="section-label"><?php esc_html_e('Pricing', 'babarida-dive'); ?></div>
            <h2 class="section-title"><?php esc_html_e('Monthly Price List', 'babarida-dive'); ?></h2>
            <p class="section-desc"><?php esc_html_e('Transparent pricing with seasonal variations. All prices in USD per person.', 'babarida-dive'); ?></p>
        </div>

        <!-- Currency Switcher -->
        <div class="flex justify-center gap-2 mb-4 reveal">
            <button class="pricing-tab active" data-currency="USD">USD</button>
            <button class="pricing-tab" data-currency="EUR">EUR</button>
            <button class="pricing-tab" data-currency="SGD">SGD</button>
            <button class="pricing-tab" data-currency="AUD">AUD</button>
            <button class="pricing-tab" data-currency="IDR">IDR</button>
        </div>

        <div class="pricing-table-wrap reveal">
            <table class="pricing-table" id="pricing-table">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Month', 'babarida-dive'); ?></th>
                        <th><?php esc_html_e('Season', 'babarida-dive'); ?></th>
                        <th><?php esc_html_e('Day Trip', 'babarida-dive'); ?></th>
                        <th><?php esc_html_e('Dive & Stay', 'babarida-dive'); ?></th>
                        <th><?php esc_html_e('Liveaboard', 'babarida-dive'); ?></th>
                        <th><?php esc_html_e('Dive Course', 'babarida-dive'); ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($months as $m) :
                        $season = bdc_get_season($m['month']);
                        // Get admin prices or use defaults
                        $day_trip = get_theme_mod('bdc_price_day_' . $m['key'], $season[0] === 'peak' ? 120 : ($season[0] === 'high' ? 95 : 75));
                        $dive_stay = get_theme_mod('bdc_price_stay_' . $m['key'], $season[0] === 'peak' ? 280 : ($season[0] === 'high' ? 220 : 170));
                        $liveaboard = get_theme_mod('bdc_price_live_' . $m['key'], $season[0] === 'peak' ? 350 : ($season[0] === 'high' ? 280 : 220));
                        $course = get_theme_mod('bdc_price_course_' . $m['key'], $season[0] === 'peak' ? 550 : ($season[0] === 'high' ? 480 : 420));
                    ?>
                    <tr>
                        <td><strong><?php echo esc_html($m['label']); ?></strong></td>
                        <td><span class="season-badge <?php echo esc_attr($season[2]); ?>"><?php echo esc_html($season[1]); ?></span></td>
                        <td class="price-cell" data-usd="<?php echo esc_attr($day_trip); ?>"><?php echo esc_html($day_trip); ?></td>
                        <td class="price-cell" data-usd="<?php echo esc_attr($dive_stay); ?>"><?php echo esc_html($dive_stay); ?></td>
                        <td class="price-cell" data-usd="<?php echo esc_attr($liveaboard); ?>"><?php echo esc_html($liveaboard); ?></td>
                        <td class="price-cell" data-usd="<?php echo esc_attr($course); ?>"><?php echo esc_html($course); ?></td>
                        <td><button class="btn btn-sm btn-yellow book-from-table" data-month="<?php echo esc_attr($m['key']); ?>"><?php esc_html_e('Book', 'babarida-dive'); ?></button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4 reveal">
            <button class="btn btn-outline" id="export-pricing-pdf"><?php esc_html_e('Export PDF', 'babarida-dive'); ?></button>
        </div>
    </div>
</section>
