<?php
/**
 * Mega Menu Walker
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

class BDC_Mega_Menu_Walker extends Walker_Nav_Menu {

    private $mega_parents = array('bunaken', 'siladen', 'bangka', 'lembeh', 'liveaboards');

    function start_lvl(&$output, $depth = 0, $args = null) {
        if ($depth === 0) {
            $output .= '<div class="mega-menu">';
        } else {
            $output .= '';
        }
    }

    function end_lvl(&$output, $depth = 0, $args = null) {
        if ($depth === 0) {
            $output .= '</div>';
        }
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        if ($depth === 0) {
            $output .= '<li' . $class_names . '>';
            $atts = array();
            $atts['href'] = !empty($item->url) ? $item->url : '';
            $atts['aria-haspopup'] = in_array($item->object_slug, $this->mega_parents) ? 'true' : 'false';
            $atts['aria-expanded'] = 'false';
            $attributes = '';
            foreach ($atts as $attr => $value) {
                if (!empty($value)) $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
            }
            $output .= '<a' . $attributes . '>';
            $output .= apply_filters('the_title', $item->title, $item->ID);
            if (in_array($item->object_slug, $this->mega_parents)) {
                $output .= ' <i data-lucide="chevron-down" style="width:14px;height:14px;opacity:0.6;"></i>';
            }
            $output .= '</a>';
        } else {
            // Mega menu items
            $icon = get_post_meta($item->object_id, 'menu_icon', true);
            $icon = $icon ? $icon : 'arrow-right';
            $output .= '<a href="' . esc_attr($item->url) . '">';
            $output .= '<span class="mm-icon"><i data-lucide="' . esc_attr($icon) . '" style="width:18px;height:18px;"></i></span>';
            $output .= '<span class="mm-text"><strong>' . esc_html($item->title) . '</strong>';
            if (!empty($item->attr_title)) $output .= '<span>' . esc_html($item->attr_title) . '</span>';
            $output .= '</span></a>';
        }
    }

    function end_el(&$output, $item, $depth = 0, $args = null) {
        if ($depth === 0) {
            $output .= '</li>';
        }
    }
}
