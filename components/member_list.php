<?php
if (!function_exists('member_list')) {
    /**
     * Display a list of links to members with their photos
     * @param  array  $opts Options array
     */
    function member_list(array $opts)
    {
        $members = $opts['members'];
        $heading = array_key_exists('heading', $opts) ? $opts['heading'] : 'Composers';
        $show_image = array_key_exists('show_image', $opts) ? $opts['show_image'] : true;
        $classes = is_front_page() ? 'composers fp-section' : 'composers p-section';

        echo  '<section class="' . $classes . '">' .
            '<h2>' . $heading . '</h2>' .
            '<ul class="clearfix">';

        foreach ($members as $post) {
            component('member_list_item', array(
        "ID" => $post->ID,
        "show_image" => $show_image
      ));
        }

        echo    '</ul>' .
          '</section>';
    }
}

member_list($opts);
