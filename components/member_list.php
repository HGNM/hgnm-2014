<?php
if (!function_exists('member_list')) {
  /**
   * Display a list of links to members with their photos
   * @param  array  $posts Member post objects to link to
   */
  function member_list(array $posts) {
    $classes = is_front_page() ? 'composers fp-section' : 'composers p-section';
    echo  '<section class="' . $classes . '">' .
            '<h2>Composers</h2>' .
            '<ul class="clearfix">';

    foreach($posts as $post) {
      component('member_photo_link', $post->ID);
    }

    echo    '</ul>' .
          '</section>';
  }
}

member_list($opts)
?>
