<?php
/**
 * Partners Section Template Part
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

 $partners = get_posts(array('post_type' => 'bdc_partner', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC'));
?>

<section class="section section-bg-ocean" id="partners">
    <div class="container">
        <div class="section-header reveal">
            <div class="section-label"><?php esc_html_e('Partners', 'babarida-dive'); ?></div>
            <h2 class="section-title"><?php esc_html_e('Our Partners', 'babarida-dive'); ?></h2>
        </div>
    </div>

    <div style="overflow:hidden;padding:20px 0;" class="reveal">
        <div class="partners-track">
            <?php if ($partners) :
                // Duplicate for infinite scroll
                $all_partners = array_merge($partners, $partners);
                foreach ($all_partners as $p) :
                    $link = get_post_meta($p->ID, 'partner_url', true);
                    $logo = get_post_thumbnail_id($p->ID);
                    if ($logo) :
                        $logo_url = wp_get_attachment_image_url($logo, 'full');
                        $tag = $link ? 'a' : 'div';
                        $href = $link ? ' href="' . esc_url($link) . '" target="_blank" rel="noopener"' : '';
                        echo '<' . $tag . $href . ' class="partner-logo" title="' . esc_attr($p->post_title) . '">';
                        echo '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr($p->post_title) . '" style="height:50px;width:auto;" loading="lazy">';
                        echo '</' . $tag . '>';
                    else :
                        echo '<div class="partner-logo" style="height:50px;display:flex;align-items:center;font-size:18px;font-weight:700;color:var(--mid-gray);white-space:nowrap;">' . esc_html($p->post_title) . '</div>';
                    endif;
                endforeach;
            else :
                // Fallback
                $fallback = array('SSI', 'PADI', 'Tourism Indonesia', 'Manado City', 'North Sulawesi Tourism', 'Dive Magazine', 'Ocean Conservation', 'Marine Stewardship');
                $all_fb = array_merge($fallback, $fallback);
                foreach ($all_fb as $fb) :
                    echo '<div class="partner-logo" style="height:50px;display:flex;align-items:center;font-size:16px;font-weight:600;color:var(--mid-gray);white-space:nowrap;padding:0 20px;">' . esc_html($fb) . '</div>';
                endforeach;
            endif; ?>
        </div>
    </div>
</section>
