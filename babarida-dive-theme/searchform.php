<?php
/**
 * Search Form
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;
?>
<form role="search" method="get" class="search-bar" action="<?php echo esc_url(home_url('/')); ?>" style="margin-bottom:0;">
    <div class="search-field" style="flex:2;">
        <label for="s"><?php esc_html_e('Search', 'babarida-dive'); ?></label>
        <input type="search" id="s" name="s" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="<?php esc_attr_e('Search destinations, trips, courses...', 'babarida-dive'); ?>">
    </div>
    <div class="search-field">
        <label for="post-type"><?php esc_html_e('Type', 'babarida-dive'); ?></label>
        <select id="post-type" name="post_type">
            <option value=""><?php esc_html_e('All', 'babarida-dive'); ?></option>
            <option value="bdc_trip" <?php selected(get_query_var('post_type'), 'bdc_trip'); ?>><?php esc_html_e('Trips', 'babarida-dive'); ?></option>
            <option value="bdc_liveaboard" <?php selected(get_query_var('post_type'), 'bdc_liveaboard'); ?>><?php esc_html_e('Liveaboards', 'babarida-dive'); ?></option>
            <option value="bdc_course" <?php selected(get_query_var('post_type'), 'bdc_course'); ?>><?php esc_html_e('Courses', 'babarida-dive'); ?></option>
            <option value="bdc_hotel" <?php selected(get_query_var('post_type'), 'bdc_hotel'); ?>><?php esc_html_e('Hotels', 'babarida-dive'); ?></option>
            <option value="post" <?php selected(get_query_var('post_type'), 'post'); ?>><?php esc_html_e('Blog', 'babarida-dive'); ?></option>
        </select>
    </div>
    <div class="search-field" style="display:flex;align-items:flex-end;">
        <button type="submit" class="btn btn-primary"><?php esc_html_e('Search', 'babarida-dive'); ?></button>
    </div>
</form>
