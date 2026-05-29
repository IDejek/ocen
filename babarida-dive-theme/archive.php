<?php
/**
 * Archive Template
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;
get_header();

 $post_type = get_post_type();
 $pt_obj = get_post_type_object($post_type);
 $pt_name = $pt_obj ? $pt_obj->labels->name : __('Archive', 'babarida-dive');
 $pt_desc = $pt_obj ? $pt_obj->description : '';
?>

<main id="main-content" role="main">
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-list">
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'babarida-dive'); ?></a>
                <span class="breadcrumb-sep">/</span>
                <span><?php echo esc_html($pt_name); ?></span>
            </div>
        </div>
    </div>

    <!-- Archive Header -->
    <section class="section" style="padding-bottom:0;">
        <div class="container">
            <div class="section-header reveal">
                <h1 class="section-title"><?php echo esc_html($pt_name); ?></h1>
                <?php if ($pt_desc) : ?>
                <p class="section-desc"><?php echo esc_html($pt_desc); ?></p>
                <?php endif; ?>
            </div>

            <!-- Search & Filter Bar -->
            <div class="search-bar reveal" id="archive-filters">
                <div class="search-field">
                    <label><?php esc_html_e('Destination', 'babarida-dive'); ?></label>
                    <select id="filter-destination" name="destination">
                        <option value=""><?php esc_html_e('All', 'babarida-dive'); ?></option>
                        <?php
                        $dests = get_terms(array('taxonomy' => 'bdc_destination', 'hide_empty' => true));
                        if (!is_wp_error($dests)) :
                            foreach ($dests as $d) :
                                echo '<option value="' . esc_attr($d->slug) . '">' . esc_html($d->name) . '</option>';
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
                <div class="search-field">
                    <label><?php esc_html_e('Activity', 'babarida-dive'); ?></label>
                    <select id="filter-activity" name="activity">
                        <option value=""><?php esc_html_e('All', 'babarida-dive'); ?></option>
                        <?php
                        $acts = get_terms(array('taxonomy' => 'bdc_activity', 'hide_empty' => true));
                        if (!is_wp_error($acts)) :
                            foreach ($acts as $a) :
                                echo '<option value="' . esc_attr($a->slug) . '">' . esc_html($a->name) . '</option>';
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
                <div class="search-field">
                    <label><?php esc_html_e('Price Range', 'babarida-dive'); ?></label>
                    <input type="number" id="filter-price-min" name="price_min" placeholder="<?php esc_attr_e('Min', 'babarida-dive'); ?>" min="0">
                </div>
                <div class="search-field">
                    <label>&nbsp;</label>
                    <input type="number" id="filter-price-max" name="price_max" placeholder="<?php esc_attr_e('Max', 'babarida-dive'); ?>" min="0">
                </div>
                <div class="search-field" style="display:flex;align-items:flex-end;">
                    <button class="btn btn-primary" id="apply-filters"><?php esc_html_e('Filter', 'babarida-dive'); ?></button>
                </div>
            </div>
        </div>
    </section>

    <!-- Archive Grid -->
    <section class="section" style="padding-top:20px;">
        <div class="container">
            <div class="archive-grid" id="archive-grid">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/card', get_post_type()); ?>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p class="text-center" style="grid-column:1/-1;padding:60px 0;color:var(--mid-gray);">
                        <?php esc_html_e('No items found.', 'babarida-dive'); ?>
                    </p>
                <?php endif; ?>
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
        </div>
    </section>
</main>

<?php get_footer(); ?>
