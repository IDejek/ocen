<?php
/**
 * Destinations Section Template Part
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

 $destinations = array(
    array(
        'name' => 'Bunaken',
        'slug' => 'bunaken',
        'sub'  => __('Wall Diving Paradise', 'babarida-dive'),
        'img'  => get_theme_mod('bdc_dest_bunaken_img', BDC_URI . '/assets/images/dest-bunaken.jpg'),
        'sites'=> get_theme_mod('bdc_dest_bunaken_sites', '25+'),
        'depth'=> __('5-40m', 'babarida-dive'),
        'vis'  => __('15-30m', 'babarida-dive'),
    ),
    array(
        'name' => 'Siladen',
        'slug' => 'siladen',
        'sub'  => __('Pristine Reef Gardens', 'babarida-dive'),
        'img'  => get_theme_mod('bdc_dest_siladen_img', BDC_URI . '/assets/images/dest-siladen.jpg'),
        'sites'=> get_theme_mod('bdc_dest_siladen_sites', '12+'),
        'depth'=> __('3-30m', 'babarida-dive'),
        'vis'  => __('20-35m', 'babarida-dive'),
    ),
    array(
        'name' => 'Bangka',
        'slug' => 'bangka',
        'sub'  => __('Dramatic Underwater Landscapes', 'babarida-dive'),
        'img'  => get_theme_mod('bdc_dest_bangka_img', BDC_URI . '/assets/images/dest-bangka.jpg'),
        'sites'=> get_theme_mod('bdc_dest_bangka_sites', '18+'),
        'depth'=> __('5-35m', 'babarida-dive'),
        'vis'  => __('15-25m', 'babarida-dive'),
    ),
    array(
        'name' => 'Lembeh',
        'slug' => 'lembeh',
        'sub'  => __('World\'s Best Muck Diving', 'babarida-dive'),
        'img'  => get_theme_mod('bdc_dest_lembeh_img', BDC_URI . '/assets/images/dest-lembeh.jpg'),
        'sites'=> get_theme_mod('bdc_dest_lembeh_sites', '30+'),
        'depth'=> __('3-25m', 'babarida-dive'),
        'vis'  => __('10-20m', 'babarida-dive'),
    ),
);
?>

<section class="section section-bg-ocean" id="destinations">
    <div class="container">
        <div class="section-header reveal">
            <div class="section-label"><?php esc_html_e('Destinations', 'babarida-dive'); ?></div>
            <h2 class="section-title"><?php esc_html_e('Explore Our Dive Destinations', 'babarida-dive'); ?></h2>
            <p class="section-desc"><?php esc_html_e('Four extraordinary locations, each offering a unique diving experience in the heart of the Coral Triangle.', 'babarida-dive'); ?></p>
        </div>

        <div class="dest-grid">
            <?php foreach ($destinations as $i => $dest) : ?>
            <a href="<?php echo esc_url(home_url('/' . $dest['slug'])); ?>" class="dest-card reveal reveal-delay-<?php echo $i + 1; ?>" aria-label="<?php echo esc_attr($dest['name']); ?>">
                <img src="<?php echo esc_url($dest['img']); ?>" alt="<?php echo esc_attr($dest['name'] . ' - ' . $dest['sub']); ?>" loading="lazy">
                <div class="dest-card-overlay">
                    <div class="dest-card-name"><?php echo esc_html($dest['name']); ?></div>
                    <div class="dest-card-sub"><?php echo esc_html($dest['sub']); ?></div>
                    <div class="dest-card-stats">
                        <div class="dest-card-stat">
                            <strong><?php echo esc_html($dest['sites']); ?></strong>
                            <?php esc_html_e('Dive Sites', 'babarida-dive'); ?>
                        </div>
                        <div class="dest-card-stat">
                            <strong><?php echo esc_html($dest['depth']); ?></strong>
                            <?php esc_html_e('Depth Range', 'babarida-dive'); ?>
                        </div>
                        <div class="dest-card-stat">
                            <strong><?php echo esc_html($dest['vis']); ?></strong>
                            <?php esc_html_e('Visibility', 'babarida-dive'); ?>
                        </div>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
