<?php
/**
 * Main Index Template (Fallback)
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
                <span><?php esc_html_e('Blog', 'babarida-dive'); ?></span>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <div class="section-header reveal">
                <h1 class="section-title"><?php esc_html_e('Latest News & Updates', 'babarida-dive'); ?></h1>
            </div>

            <?php if (have_posts()) : ?>
            <div class="archive-grid">
                <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class('card reveal'); ?>>
                    <div class="card-img">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : the_post_thumbnail('bdc-card'); else : ?>
                            <img src="<?php echo esc_url(BDC_URI . '/assets/images/placeholder.jpg'); ?>" alt="<?php esc_attr_e('No image', 'babarida-dive'); ?>">
                            <?php endif; ?>
                        </a>
                        <?php if (get_post_type() === 'post') : ?>
                        <div class="card-img-overlay"></div>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <?php
                        $cats = get_the_category();
                        if ($cats) : ?>
                            <span style="font-size:12px;color:var(--bright-blue);font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">
                                <?php echo esc_html($cats[0]->name); ?>
                            </span>
                        <?php endif; ?>
                        <h2 class="card-title" style="margin-top:6px;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p class="card-text"><?php echo get_the_excerpt(); ?></p>
                        <div class="card-footer">
                            <span style="font-size:13px;color:var(--mid-gray);"><?php echo get_the_date(); ?></span>
                            <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline"><?php esc_html_e('Read More', 'babarida-dive'); ?></a>
                        </div>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>

            <div class="pagination">
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => '&laquo;',
                    'next_text' => '&raquo;',
                ));
                ?>
            </div>
            <?php else : ?>
            <p class="text-center" style="padding:60px 0;color:var(--mid-gray);"><?php esc_html_e('No posts found.', 'babarida-dive'); ?></p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
