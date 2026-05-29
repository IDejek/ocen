<?php
/**
 * 404 Error Page
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;
get_header();
?>

<main id="main-content" role="main">
    <div class="page-404">
        <div>
            <h1>404</h1>
            <h2><?php esc_html_e('Page Not Found', 'babarida-dive'); ?></h2>
            <p style="color:var(--mid-gray);font-size:16px;margin-bottom:32px;max-width:400px;margin-left:auto;margin-right:auto;">
                <?php esc_html_e('The page you\'re looking for doesn\'t exist or has been moved. Let\'s get you back on track.', 'babarida-dive'); ?>
            </p>
            <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary"><?php esc_html_e('Go Home', 'babarida-dive'); ?></a>
                <a href="<?php echo esc_url(home_url('/destinations')); ?>" class="btn btn-outline"><?php esc_html_e('Explore Destinations', 'babarida-dive'); ?></a>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
