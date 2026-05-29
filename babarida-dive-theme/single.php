<?php
/**
 * Single Post Template
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;
get_header();

 $post_type = get_post_type();
 $pt_labels = get_post_type_object($post_type);
?>

<main id="main-content" role="main">
    <?php if (has_post_thumbnail()) : ?>
    <div class="single-hero">
        <?php the_post_thumbnail('bdc-fullwidth'); ?>
        <div class="single-hero-overlay">
            <div class="container">
                <?php if ($pt_labels && $post_type !== 'post') : ?>
                <span style="font-size:13px;color:var(--tropical-yellow);font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;display:block;">
                    <?php echo esc_html($pt_labels->labels->singular_name); ?>
                </span>
                <?php endif; ?>
                <h1 class="single-hero-title"><?php the_title(); ?></h1>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="breadcrumb" style="<?php echo has_post_thumbnail() ? 'padding-top:24px;' : 'padding-top:calc(var(--topbar-h) + var(--header-h) + 24px);'; ?>">
        <div class="container">
            <div class="breadcrumb-list">
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'babarida-dive'); ?></a>
                <span class="breadcrumb-sep">/</span>
                <?php if ($post_type !== 'post' && $pt_labels) : ?>
                <a href="<?php echo esc_url(get_post_type_archive_link($post_type)); ?>"><?php echo esc_html($pt_labels->labels->name); ?></a>
                <span class="breadcrumb-sep">/</span>
                <?php endif; ?>
                <span><?php the_title(); ?></span>
            </div>
        </div>
    </div>

    <article class="single-content">
        <div class="container">
            <?php the_content(); ?>

            <!-- Price Display -->
            <?php
            $price = get_post_meta(get_the_ID(), 'price_usd', true);
            if ($price) : ?>
            <div class="glass-card mt-4" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
                <div>
                    <span style="font-size:13px;color:var(--mid-gray);text-transform:uppercase;letter-spacing:0.5px;"><?php esc_html_e('Starting from', 'babarida-dive'); ?></span>
                    <div style="font-size:32px;font-weight:700;color:var(--bright-blue);">$<?php echo esc_html(number_format($price, 0)); ?></div>
                    <span style="font-size:13px;color:var(--mid-gray);"><?php esc_html_e('per person', 'babarida-dive'); ?></span>
                </div>
                <div style="display:flex;gap:12px;">
                    <a href="https://wa.me/62895801960359?text=<?php echo urlencode('Hi, I\'m interested in: ' . get_the_title()); ?>" class="btn btn-yellow" target="_blank" rel="noopener">
                        <?php esc_html_e('Ask on WhatsApp', 'babarida-dive'); ?>
                    </a>
                    <button class="btn btn-primary" onclick="document.getElementById('booking-modal').classList.add('active');document.getElementById('booking-modal-overlay').classList.add('active');">
                        <?php esc_html_e('Book Now', 'babarida-dive'); ?>
                    </button>
                </div>
            </div>
            <?php endif; ?>

            <!-- Gallery -->
            <?php
            $gallery = get_post_meta(get_the_ID(), 'gallery', true);
            if ($gallery && is_array($gallery)) : ?>
            <div class="single-gallery">
                <?php foreach (array_slice($gallery, 0, 8) as $img_id) :
                    $img_url = wp_get_attachment_image_url($img_id, 'bdc-gallery');
                    if ($img_url) : ?>
                    <a href="<?php echo esc_url(wp_get_attachment_image_url($img_id, 'full')); ?>" data-lightbox="gallery">
                        <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', true)); ?>" loading="lazy">
                    </a>
                    <?php endif;
                endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Itinerary -->
            <?php
            $itinerary = get_post_meta(get_the_ID(), 'itinerary', true);
            if ($itinerary && is_array($itinerary)) : ?>
            <h2><?php esc_html_e('Itinerary', 'babarida-dive'); ?></h2>
            <?php foreach ($itinerary as $day) : ?>
            <div class="glass-card mb-2">
                <h3 style="font-size:18px;color:var(--bright-blue);margin-bottom:8px;"><?php echo esc_html($day['title'] ?? ''); ?></h3>
                <p style="font-size:14px;color:var(--dark-gray);line-height:1.7;"><?php echo esc_html($day['description'] ?? ''); ?></p>
            </div>
            <?php endforeach; endif; ?>

            <!-- Inclusions/Exclusions -->
            <?php
            $includes = get_post_meta(get_the_ID(), 'includes', true);
            $excludes = get_post_meta(get_the_ID(), 'excludes', true);
            if ($includes || $excludes) : ?>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-top:32px;">
                <?php if ($includes) : ?>
                <div class="glass-card">
                    <h3 style="font-size:18px;color:var(--success);margin-bottom:12px;"><?php esc_html_e('Includes', 'babarida-dive'); ?></h3>
                    <ul style="padding-left:0;">
                        <?php foreach ($includes as $item) : ?>
                        <li style="list-style:none;padding:6px 0;font-size:14px;color:var(--dark-gray);display:flex;align-items:center;gap:8px;">
                            <span style="color:var(--success);">✓</span> <?php echo esc_html($item); ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                <?php if ($excludes) : ?>
                <div class="glass-card">
                    <h3 style="font-size:18px;color:var(--danger);margin-bottom:12px;"><?php esc_html_e('Excludes', 'babarida-dive'); ?></h3>
                    <ul style="padding-left:0;">
                        <?php foreach ($excludes as $item) : ?>
                        <li style="list-style:none;padding:6px 0;font-size:14px;color:var(--dark-gray);display:flex;align-items:center;gap:8px;">
                            <span style="color:var(--danger);">✗</span> <?php echo esc_html($item); ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Share & Tags -->
            <div style="margin-top:40px;padding-top:24px;border-top:1px solid var(--light-gray);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;">
                <?php the_tags('<span style="font-size:13px;color:var(--mid-gray);">' . __('Tags:', 'babarida-dive') . '</span> ', '', ''); ?>
                <div style="display:flex;gap:8px;">
                    <span style="font-size:13px;color:var(--mid-gray);"><?php esc_html_e('Share:', 'babarida-dive'); ?></span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener" style="color:var(--bright-blue);font-size:14px;">Facebook</a>
                    <a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>" target="_blank" rel="noopener" style="color:var(--success);font-size:14px;">WhatsApp</a>
                </div>
            </div>

            <!-- Post Navigation -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-top:32px;">
                <div><?php previous_post_link('%link', '&larr; %title'); ?></div>
                <div style="text-align:right;"><?php next_post_link('%link', '%title &rarr;'); ?></div>
            </div>
        </div>
    </article>

    <!-- Related Items -->
    <?php
    $related_args = array(
        'post_type'      => $post_type,
        'posts_per_page' => 3,
        'post__not_in'   => array(get_the_ID()),
        'orderby'        => 'rand',
    );
    // If it's a trip, try to match by destination
    $dest_terms = get_the_terms(get_the_ID(), 'bdc_destination');
    if ($dest_terms && !is_wp_error($dest_terms)) {
        $related_args['tax_query'] = array(
            array('taxonomy' => 'bdc_destination', 'field' => 'slug', 'terms' => $dest_terms[0]->slug),
        );
    }
    $related = new WP_Query($related_args);
    if ($related->have_posts()) : ?>
    <section class="section" style="background:var(--off-white);">
        <div class="container">
            <div class="section-header reveal">
                <h2 class="section-title"><?php esc_html_e('You May Also Like', 'babarida-dive'); ?></h2>
            </div>
            <div class="archive-grid">
                <?php while ($related->have_posts()) : $related->the_post(); ?>
                <article class="card reveal">
                    <div class="card-img">
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('bdc-card'); ?></a>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p class="card-text"><?php echo get_the_excerpt(); ?></p>
                        <?php $rp = get_post_meta(get_the_ID(), 'price_usd', true); ?>
                        <?php if ($rp) : ?>
                        <div class="card-footer">
                            <span class="card-price">$<?php echo esc_html(number_format($rp, 0)); ?> <small>/ <?php esc_html_e('person', 'babarida-dive'); ?></small></span>
                            <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-primary"><?php esc_html_e('View', 'babarida-dive'); ?></a>
                        </div>
                        <?php endif; ?>
                    </div>
                </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Comments (for blog posts) -->
    <?php if ($post_type === 'post' && comments_open() || get_comments_number()) : ?>
    <section class="section">
        <div class="container" style="max-width:800px;">
            <?php comments_template(); ?>
        </div>
    </section>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
