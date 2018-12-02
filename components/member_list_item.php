<?php
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

        $html = '<li><a href="' . get_permalink($ID) . '">';
        if ($show_image) {
            $imgsrc = wp_get_attachment_image_src(get_post_thumbnail_id($ID), 'hgnm-thumb');
            if (!empty($imgsrc)) {
                $html .= '<img src="' . $imgsrc[0] . '" alt="' . get_the_title($ID) . '">';
            } else {
                $html .= '<img src="' . get_stylesheet_directory_uri() . '/img/fallback-200x200.gif" alt="' . get_the_title($ID) . '">';
            }
        }
        $html .= '<span>' . get_the_title($ID) . '</span>' . '</a></li>';
        return $html;
    }
}
