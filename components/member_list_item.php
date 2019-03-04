<?php
if (!defined('HGNM_SQUARE_PLACEHOLDER_SRC')) {
    define(
        'HGNM_SQUARE_PLACEHOLDER_SRC',
        get_stylesheet_directory_uri() . '/img/fallback-200x200.gif'
    );
}

if (!function_exists('member_list_item')) {
    /**
     * A link to a member with their name and (optionally) photo
     * @param  array  $opts Options array
     * @return string       HTML string for the component
     */
    function member_list_item($opts)
    {
        $ID = $opts['ID'];
        $show_image = array_key_exists('show_image', $opts) ? $opts['show_image'] : true;
        $member_name = get_the_title($ID);

        $html = '<li><a href="' . get_permalink($ID) . '">';
        if ($show_image) {
            $img_id = get_post_thumbnail_id($ID);
            $alt_text = get_post_meta($img_id, '_wp_attachment_image_alt', true);
            $imgsrc = wp_get_attachment_image_src($img_id, 'hgnm-thumb');
            if (empty($imgsrc)) {
                $imgsrc = array(HGNM_SQUARE_PLACEHOLDER_SRC);
            }
            if (!$alt_text) {
                $alt_text = $member_name;
            }
            $html .= '<img src="' . HGNM_SQUARE_PLACEHOLDER_SRC . '" data-src="' . $imgsrc[0] . '" alt="' . $alt_text . '" class="lozad">';
        }
        $html .= "<span>$member_name</span></a></li>";
        return $html;
    }
}
