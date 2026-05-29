<?php
/**
 * Hero Section Template Part
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

 $video = get_theme_mod('bdc_hero_video', '');
 $image = get_theme_mod('bdc_hero_image', '');
 $title = get_theme_mod('bdc_hero_title', get_bloginfo('name'));
 $slogan = get_theme_mod('bdc_hero_slogan', 'The quality of your dive adventure depends on who guides you!');
?>

<section class="hero" id="hero" aria-label="<?php esc_attr_e('Hero', 'babarida-dive'); ?>">
    <?php if ($video) : ?>
    <video class="hero-video" autoplay muted loop playsinline preload="metadata" poster="<?php echo esc_url($image); ?>">
        <source src="<?php echo esc_url($video); ?>" type="video/mp4">
    </video>
    <?php endif; ?>

    <div class="hero-fallback" <?php if ($image) : ?>style="background-image:url('<?php echo esc_url($image); ?>');background-size:cover;background-position:center;"<?php endif; ?>></div>

    <div class="hero-content">
        <h1 class="hero-title"><?php echo esc_html($title); ?></h1>
        <p class="hero-slogan"><?php echo esc_html($slogan); ?></p>
    </div>

    <div class="hero-scroll" aria-hidden="true">
        <span><?php esc_html_e('Scroll', 'babarida-dive'); ?></span>
        <div class="hero-scroll-line"></div>
    </div>
</section>
