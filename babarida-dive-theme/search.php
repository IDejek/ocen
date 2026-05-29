<?php
/**
 * Search Results Template
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;
get_header();
?>

<main id="main-content" role="main">
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-list">
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'babarida-dive'); ?></a>
                <span class="breadcrumb-sep">/</span>
                <span><?php esc_html_e('Search Results', 'babarida-dive'); ?></span>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <div class="section-header reveal">
                <h1 class="section-title">
                    <?php printf(esc_html__('Search Results for: %s', 'babarida-dive'), '<span style="color:var(--bright-blue);">' . get_search_query() . '</span>'); ?>
                </h1>
                <p class="section-desc">
                    <?php
                    global $wp_query;
                    printf(esc_html(_n('%d result found.', '%d results found.', $wp_query->found_posts, 'babarida-dive')), $wp_query->found_posts);
                    ?>
                </p>
            </div>

            <?php get_search_form(); ?>

            <?php if (have_posts()) : ?>
            <div class="archive-grid" style="margin-top:40px;">
                <?php while (have_posts()) : the_post(); ?>
                <article class="card reveal">
                    <div class="card-img">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : the_post_thumbnail('bdc-card'); else : ?>
                            <img src="<?php echo esc_url(BDC_URI . '/assets/images/placeholder.jpg'); ?>" alt="">
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="card-body">
                        <span style="font-size:12px;color:var(--bright-blue);font-weight:600;text-transform:uppercase;"><?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name); ?></span>
                        <h2 class="card-title" style="margin-top:6px;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p class="card-text"><?php echo get_the_excerpt(); ?></p>
                        <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline"><?php esc_html_e('View', 'babarida-dive'); ?></a>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>
            <div class="pagination">
                <?php the_posts_pagination(array('mid_size' => 2, 'prev_text' => '&laquo;', 'next_text' => '&raquo;')); ?>
            </div>
            <?php else : ?>
            <div class="text-center" style="padding:60px 0;">
                <p style="color:var(--mid-gray);font-size:18px;"><?php esc_html_e('No results found. Try different keywords.', 'babarida-dive'); ?></p>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
