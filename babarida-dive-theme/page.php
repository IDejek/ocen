<?php
/**
 * Page Template
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;
get_header();

// Check for custom page templates
 $template = get_page_template_slug();
if ($template && file_exists($template)) {
    // Let WordPress handle the custom template
}

 $page_id = get_the_ID();
 $hide_title = get_post_meta($page_id, '_bdc_hide_title', true);
?>

<main id="main-content" role="main">
    <?php if (has_post_thumbnail() && !$hide_title) : ?>
    <div class="single-hero">
        <?php the_post_thumbnail('bdc-fullwidth'); ?>
        <div class="single-hero-overlay">
            <div class="container">
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
                <span><?php the_title(); ?></span>
            </div>
        </div>
    </div>

    <article class="single-content">
        <div class="container">
            <?php if (!has_post_thumbnail() && !$hide_title) : ?>
            <h1 class="section-title mb-4"><?php the_title(); ?></h1>
            <?php endif; ?>
            <?php the_content(); ?>
        </div>
    </article>
</main>

<?php get_footer(); ?>
