<?php
/**
 * Welcome Section Template Part
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;
?>

<section class="section" id="welcome">
    <div class="container">
        <div class="welcome-grid">
            <div class="welcome-img reveal">
                <?php
                $welcome_img = get_theme_mod('bdc_welcome_image', '');
                if ($welcome_img) :
                    echo '<img src="' . esc_url($welcome_img) . '" alt="' . esc_attr__('Coral reef diving', 'babarida-dive') . '" loading="lazy">';
                else :
                    echo '<img src="' . esc_url(BDC_URI . '/assets/images/welcome-coral.jpg') . '" alt="' . esc_attr__('Coral reef diving', 'babarida-dive') . '" loading="lazy">';
                endif;
                ?>
                <div class="welcome-img-float">
                    <div class="wif-number"><?php echo esc_html(get_theme_mod('bdc_years_count', '15')); ?>+</div>
                    <div class="wif-label"><?php esc_html_e('Years Experience', 'babarida-dive'); ?></div>
                </div>
            </div>

            <div class="welcome-content reveal reveal-delay-2">
                <div class="section-label"><?php esc_html_e('Welcome', 'babarida-dive'); ?></div>
                <h2 class="welcome-title"><?php esc_html_e('Welcome to Babarida Dive Center', 'babarida-dive'); ?></h2>
                <p class="welcome-quote">"<?php esc_html_e('Unchain Your Adventure, Go Scuba Diving.!', 'babarida-dive'); ?>"</p>
                <p class="welcome-text">
                    <?php esc_html_e('Our team is intimately familiar with Bunaken, Siladen, Bangka, and Lembeh and has worked together for years, creating safe, smooth, and unforgettable experiences for divers of all levels.', 'babarida-dive'); ?>
                </p>

                <div class="welcome-features">
                    <div class="welcome-feature">
                        <i data-lucide="ship" style="width:20px;height:20px;"></i>
                        <?php esc_html_e('Liveaboard Cruises', 'babarida-dive'); ?>
                    </div>
                    <div class="welcome-feature">
                        <i data-lucide="compass" style="width:20px;height:20px;"></i>
                        <?php esc_html_e('Dive Safaris', 'babarida-dive'); ?>
                    </div>
                    <div class="welcome-feature">
                        <i data-lucide="waves" style="width:20px;height:20px;"></i>
                        <?php esc_html_e('Water Sports', 'babarida-dive'); ?>
                    </div>
                    <div class="welcome-feature">
                        <i data-lucide="sun" style="width:20px;height:20px;"></i>
                        <?php esc_html_e('Day Trips', 'babarida-dive'); ?>
                    </div>
                    <div class="welcome-feature">
                        <i data-lucide="award" style="width:20px;height:20px;"></i>
                        <?php esc_html_e('SSI Courses', 'babarida-dive'); ?>
                    </div>
                    <div class="welcome-feature">
                        <i data-lucide="fish" style="width:20px;height:20px;"></i>
                        <?php esc_html_e('Snorkeling', 'babarida-dive'); ?>
                    </div>
                </div>

                <p class="welcome-text" style="font-size:15px;">
                    <?php esc_html_e('We offer these services in two of the most biodiverse marine areas on the planet. Choose your destination and start planning your next trip.', 'babarida-dive'); ?>
                </p>

                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    <a href="#destinations" class="btn btn-primary"><?php esc_html_e('Explore Destinations', 'babarida-dive'); ?></a>
                    <a href="#liveaboards" class="btn btn-outline"><?php esc_html_e('View Liveaboards', 'babarida-dive'); ?></a>
                </div>
            </div>
        </div>
    </div>
</section>
