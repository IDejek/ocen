<?php
/**
 * Theme Header
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main-content"><?php esc_html_e('Skip to main content', 'babarida-dive'); ?></a>

<!-- Preloader -->
<div id="preloader" aria-hidden="true">
    <div class="preloader-waves">
        <div class="preloader-wave"></div>
        <div class="preloader-wave"></div>
        <div class="preloader-wave"></div>
    </div>
    <div class="preloader-logo"><?php echo esc_html(get_bloginfo('name')); ?></div>
    <div class="preloader-sub"><?php esc_html_e('Dive Center', 'babarida-dive'); ?></div>
    <div class="preloader-bar"><div class="preloader-bar-fill"></div></div>
</div>

<!-- Top Bar -->
<div class="topbar" id="topbar" role="banner">
    <div class="topbar-left">
        <a href="<?php echo esc_url(home_url('/check-in')); ?>" class="checkin-btn">
            <i data-lucide="clipboard-check" style="width:14px;height:14px;"></i>
            <?php esc_html_e('Check-In', 'babarida-dive'); ?>
        </a>
    </div>
    <div class="topbar-center" id="world-clocks" aria-label="<?php esc_attr_e('World clocks', 'babarida-dive'); ?>">
        <!-- Populated by clocks.js -->
    </div>
    <div class="topbar-right">
        <a href="https://wa.me/62895801960359" class="topbar-link" target="_blank" rel="noopener" aria-label="<?php esc_attr_e('Contact via WhatsApp', 'babarida-dive'); ?>">
            <i data-lucide="message-circle" style="width:14px;height:14px;"></i>
        </a>
        <a href="mailto:info@babaridadive.com" class="topbar-link" aria-label="<?php esc_attr_e('Send email', 'babarida-dive'); ?>">
            <i data-lucide="mail" style="width:14px;height:14px;"></i>
        </a>
        <div class="lang-switch" role="group" aria-label="<?php esc_attr_e('Language switcher', 'babarida-dive'); ?>">
            <button class="active" data-lang="en">EN</button>
            <button data-lang="id">ID</button>
        </div>
    </div>
</div>

<!-- Main Header -->
<header class="main-header" id="main-header" role="navigation">
    <div class="nav-inner">
        <?php if (has_custom_logo()) : ?>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
                <?php the_custom_logo(); ?>
            </a>
        <?php else : ?>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
                <div class="nav-logo-text">
                    <?php echo esc_html(get_bloginfo('name')); ?>
                    <small><?php esc_html_e('Dive Center', 'babarida-dive'); ?></small>
                </div>
            </a>
        <?php endif; ?>

        <nav aria-label="<?php esc_attr_e('Primary navigation', 'babarida-dive'); ?>">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'nav-menu',
                'walker'         => new BDC_Mega_Menu_Walker(),
                'fallback_cb'    => 'bdc_fallback_menu',
                'depth'          => 3,
            ));
            ?>
        </nav>

        <button class="nav-toggle" id="nav-toggle" aria-label="<?php esc_attr_e('Toggle menu', 'babarida-dive'); ?>" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>

<!-- Mobile Overlay -->
<div class="mobile-overlay" id="mobile-overlay"></div>

<?php
function bdc_fallback_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'babarida-dive') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/destinations/bunaken')) . '">Bunaken</a></li>';
    echo '<li><a href="' . esc_url(home_url('/destinations/siladen')) . '">Siladen</a></li>';
    echo '<li><a href="' . esc_url(home_url('/destinations/bangka')) . '">Bangka</a></li>';
    echo '<li><a href="' . esc_url(home_url('/destinations/lembeh')) . '">Lembeh</a></li>';
    echo '<li><a href="' . esc_url(home_url('/liveaboards')) . '">' . esc_html__('Liveaboards', 'babarida-dive') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/blog')) . '">' . esc_html__('Blog', 'babarida-dive') . '</a></li>';
    echo '</ul>';
}
