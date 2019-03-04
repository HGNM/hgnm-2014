<?php
if (!function_exists('embed_card')) {
    function embed_card($opts)
    {
        global $wp_embed;
        $post = $opts['post'];
        $embed_link = get_sub_field('embed_link', false);

        if ($embed_link) {
            $performer_link =
            '<a href="' . get_the_permalink($post) . '">' .
                get_the_title($post) .
            '</a>';

            $composer = get_sub_field('composer');

            $composer_link =
            '<a href="' . get_the_permalink($composer) . '">' .
                get_the_title($composer) .
            '</a>';

            $heading =
            '<h4 class="embed-card__heading">' .
                $composer_link .
                ' / ' .
                $performer_link .
                '<br>' .
                '<em>' .
                    get_sub_field('work_title') .
                '</em>' .
            '</h4>';

            $iframe = $wp_embed->shortcode(array(
                'width' => 640,
                'height' => 390,
                'src' => $embed_link
            ));

            $html =
            '<span class="embed-card">' .
                $heading .
                component('responsive_embed', $iframe) .
            '</span>';

            return $html;
        } else {
            return null;
        }
    }
}
