<?php
/**
 * Liveaboards Section Template Part
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

 $boats = get_posts(array(
    'post_type'      => 'bdc_liveaboard',
    'posts_per_page' => 3,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
));
?>

<section class="section" id="liveaboards">
    <div class="container">
        <div class="section-header reveal">
            <div class="section-label"><?php esc_html_e('Liveaboards', 'babarida-dive'); ?></div>
            <h2 class="section-title"><?php esc_html_e('Our Liveaboards', 'babarida-dive'); ?></h2>
            <p class="section-desc"><?php esc_html_e('Embark on an unforgettable journey aboard our luxury liveaboard vessels, cruising through the world\'s most biodiverse waters.', 'babarida-dive'); ?></p>
        </div>

        <?php if ($boats) : ?>
            <?php foreach ($boats as $boat) :
                $cabins = get_post_meta($boat->ID, 'cabins', true);
                $length = get_post_meta($boat->ID, 'boat_length', true);
                $guests = get_post_meta($boat->ID, 'max_guests', true);
                $price  = get_post_meta($boat->ID, 'price_usd', true);
            ?>
            <div class="liveaboard-card reveal">
                <div class="liveaboard-img">
                    <?php if (has_post_thumbnail($boat->ID)) : the_post_thumbnail($boat->ID, 'bdc-fullwidth'); else : ?>
                    <img src="<?php echo esc_url(BDC_URI . '/assets/images/boat-placeholder.jpg'); ?>" alt="<?php echo esc_attr($boat->post_title); ?>" loading="lazy">
                    <?php endif; ?>
                </div>
                <div class="liveaboard-info">
                    <h3 class="liveaboard-name"><?php echo esc_html($boat->post_title); ?></h3>
                    <p class="liveaboard-desc"><?php echo wp_trim_words($boat->post_content, 30); ?></p>
                    <div class="liveaboard-specs">
                        <div class="liveaboard-spec">
                            <div class="liveaboard-spec-value"><?php echo esc_html($cabins ?: '--'); ?></div>
                            <div class="liveaboard-spec-label"><?php esc_html_e('Cabins', 'babarida-dive'); ?></div>
                        </div>
                        <div class="liveaboard-spec">
                            <div class="liveaboard-spec-value"><?php echo esc_html($length ? $length . 'm' : '--'); ?></div>
                            <div class="liveaboard-spec-label"><?php esc_html_e('Length', 'babarida-dive'); ?></div>
                        </div>
                        <div class="liveaboard-spec">
                            <div class="liveaboard-spec-value"><?php echo esc_html($guests ?: '--'); ?></div>
                            <div class="liveaboard-spec-label"><?php esc_html_e('Guests', 'babarida-dive'); ?></div>
                        </div>
                    </div>
                    <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
                        <?php if ($price) : ?>
                        <span style="font-size:24px;font-weight:700;color:var(--bright-blue);">$<?php echo esc_html(number_format($price, 0)); ?> <small style="font-size:13px;color:var(--mid-gray);font-weight:400;"><?php esc_html_e('/ night', 'babarida-dive'); ?></small></span>
                        <?php endif; ?>
                        <div style="margin-left:auto;display:flex;gap:10px;">
                            <a href="<?php echo esc_url(get_permalink($boat->ID)); ?>" class="btn btn-outline btn-sm"><?php esc_html_e('Details', 'babarida-dive'); ?></a>
                            <button class="btn btn-primary btn-sm" onclick="document.getElementById('booking-modal').classList.add('active');document.getElementById('booking-modal-overlay').classList.add('active');"><?php esc_html_e('Book', 'babarida-dive'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else : ?>
            <!-- Fallback static content -->
            <div class="liveaboard-card reveal">
                <div class="liveaboard-img">
                    <img src="<?php echo esc_url(BDC_URI . '/assets/images/boat-1.jpg'); ?>" alt="<?php esc_attr_e('Liveaboard vessel', 'babarida-dive'); ?>" loading="lazy">
                </div>
                <div class="liveaboard-info">
                    <h3 class="liveaboard-name"><?php esc_html_e('Babarida Explorer', 'babarida-dive'); ?></h3>
                    <p class="liveaboard-desc"><?php esc_html_e('Our flagship liveaboard offering luxury accommodations and premium diving across Bunaken, Bangka, and Lembeh straits. Featuring spacious cabins, sun deck, dive platform, and professional crew.', 'babarida-dive'); ?></p>
                    <div class="liveaboard-specs">
                        <div class="liveaboard-spec"><div class="liveaboard-spec-value">8</div><div class="liveaboard-spec-label"><?php esc_html_e('Cabins', 'babarida-dive'); ?></div></div>
                        <div class="liveaboard-spec"><div class="liveaboard-spec-value">28m</div><div class="liveaboard-spec-label"><?php esc_html_e('Length', 'babarida-dive'); ?></div></div>
                        <div class="liveaboard-spec"><div class="liveaboard-spec-value">16</div><div class="liveaboard-spec-label"><?php esc_html_e('Guests', 'babarida-dive'); ?></div></div>
                    </div>
                    <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
                        <span style="font-size:24px;font-weight:700;color:var(--bright-blue);">$250 <small style="font-size:13px;color:var(--mid-gray);font-weight:400;"><?php esc_html_e('/ night', 'babarida-dive'); ?></small></span>
                        <div style="margin-left:auto;display:flex;gap:10px;">
                            <a href="<?php echo esc_url(home_url('/liveaboards')); ?>" class="btn btn-outline btn-sm"><?php esc_html_e('Details', 'babarida-dive'); ?></a>
                            <button class="btn btn-primary btn-sm" onclick="document.getElementById('booking-modal').classList.add('active');document.getElementById('booking-modal-overlay').classList.add('active');"><?php esc_html_e('Book', 'babarida-dive'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="text-center mt-4 reveal">
            <a href="<?php echo esc_url(home_url('/liveaboards')); ?>" class="btn btn-outline"><?php esc_html_e('View All Liveaboards', 'babarida-dive'); ?></a>
        </div>
    </div>
</section>
