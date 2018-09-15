<?php
// Show a link to a member with their photo and name
if (!function_exists('member_function_link')) {
  function member_function_link($ID)
  {
    $imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id($ID), 'hgnm-thumb');
    echo '<li><a href="' . get_permalink($ID) . '">';
    if(!empty($imgsrc)) {
      echo '<img src="' . $imgsrc[0] . '" alt="' . get_the_title($ID) . '">';
    }
    else {
      echo '<img src="' . get_stylesheet_directory_uri() . '/img/fallback-200x200.gif" alt="' . get_the_title($ID) . '">';
    }
    echo '<span>' . get_the_title($ID) . '</span>' . '</a></li>';
  }
}

member_function_link($opts)

?>
