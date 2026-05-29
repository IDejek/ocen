<?php
/**
 * Generic Card Template Part (used for AJAX and archive grids)
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

 $price = get_post_meta(get_the_ID(), 'price_usd', true);
 $badge = get_post_meta(get_the_ID(), 'badge_text', true);
?>

<article <?php post_class('card reveal'); ?>>
    <div class="card-img">
        <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) : the_post_thumbnail('bdc-card'); else : ?>
            <img src="<?php echo esc_url(BDC_URI . '/assets/images/placeholder.jpg'); ?>" alt="<?php esc_attr_e('No image', 'babarida-dive'); ?>" loading="lazy">
            <?php endif; ?>
        </a>
        <?php if ($badge) : ?><div class="card-badge"><?php echo esc_html($badge); ?></div><?php endif; ?>
        <div class="card-img-overlay"></div>
    </div>
    <div class="card-body">
        <?php
        $terms = get_the_terms(get_the_ID(), 'bdc_destination');
        if ($terms && !is_wp_error($terms)) :
        ?>
        <span style="font-size:12px;color:var(--bright-blue);font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">
            <?php echo esc_html($terms[0]->name); ?>
        </span>
        <?php endif; ?>
        <h3 class="card-title" style="margin-top:6px;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <p class="card-text"><?php echo get_the_excerpt(); ?></p>
        <?php if ($price) : ?>
        <div class="card-footer">
            <span class="card-price">$<?php echo esc_html(number_format((float)$price, 0)); ?> <small><?php esc_html_e('/ person', 'babarida-dive'); ?></small></span>
            <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-primary"><?php esc_html_e('View', 'babarida-dive'); ?></a>
        </div>
        <?php else : ?>
        <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline mt-2"><?php esc_html_e('Learn More', 'babarida-dive'); ?></a>
        <?php endif; ?>
    </div>
</article>
