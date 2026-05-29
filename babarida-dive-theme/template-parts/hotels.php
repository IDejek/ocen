<?php
/**
 * Hotels Section Template Part
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

 $hotels = get_posts(array('post_type' => 'bdc_hotel', 'posts_per_page' => 6, 'orderby' => 'menu_order', 'order' => 'ASC'));
?>

<section class="section section-bg-ocean" id="hotels">
    <div class="container">
        <div class="section-header reveal">
            <div class="section-label"><?php esc_html_e('Accommodation', 'babarida-dive'); ?></div>
            <h2 class="section-title"><?php esc_html_e('Recommended Hotels in Manado', 'babarida-dive'); ?></h2>
            <p class="section-desc"><?php esc_html_e('Hand-picked hotels and resorts for your stay before and after your diving adventure.', 'babarida-dive'); ?></p>
        </div>

        <?php if ($hotels) : ?>
        <div class="hotels-grid">
            <?php foreach ($hotels as $hotel) :
                $price = get_post_meta($hotel->ID, 'price_usd', true);
                $rating = get_post_meta($hotel->ID, 'star_rating', true);
            ?>
            <article class="card reveal">
                <div class="card-img">
                    <a href="<?php echo esc_url(get_permalink($hotel->ID)); ?>">
                        <?php the_post_thumbnail($hotel->ID, 'bdc-card'); ?>
                    </a>
                    <?php if ($rating) : ?>
                    <div class="card-badge"><?php echo str_repeat('★', (int)$rating); ?></div>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <h3 class="card-title"><a href="<?php echo esc_url(get_permalink($hotel->ID)); ?>"><?php echo esc_html($hotel->post_title); ?></a></h3>
                    <p class="card-text"><?php echo wp_trim_words($hotel->post_content, 20); ?></p>
                    <?php if ($price) : ?>
                    <div class="card-footer">
                        <span class="card-price">$<?php echo esc_html(number_format($price, 0)); ?> <small><?php esc_html_e('/ night', 'babarida-dive'); ?></small></span>
                        <a href="<?php echo esc_url(get_permalink($hotel->ID)); ?>" class="btn btn-sm btn-outline"><?php esc_html_e('View', 'babarida-dive'); ?></a>
                    </div>
                    <?php endif; ?>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php else : ?>
        <div class="hotels-grid">
            <?php for ($i = 1; $i <= 3; $i++) : ?>
            <article class="card reveal reveal-delay-<?php echo $i; ?>">
                <div class="card-img">
                    <img src="<?php echo esc_url(BDC_URI . '/assets/images/hotel-' . $i . '.jpg'); ?>" alt="<?php printf(esc_attr__('Hotel %d', 'babarida-dive'), $i); ?>" loading="lazy">
                    <div class="card-badge">★★★★</div>
                </div>
                <div class="card-body">
                    <h3 class="card-title"><?php printf(esc_html__('Premium Hotel %d', 'babarida-dive'), $i); ?></h3>
                    <p class="card-text"><?php esc_html_e('Comfortable accommodation near Manado city center with easy access to the dive center.', 'babarida-dive'); ?></p>
                    <div class="card-footer">
                        <span class="card-price">$<?php echo $i * 30 + 40; ?> <small><?php esc_html_e('/ night', 'babarida-dive'); ?></small></span>
                        <a href="mailto:info@babaridadive.com?subject=<?php esc_attr_e('Hotel Inquiry', 'babarida-dive'); ?>" class="btn btn-sm btn-outline"><?php esc_html_e('Inquire', 'babarida-dive'); ?></a>
                    </div>
                </div>
            </article>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
