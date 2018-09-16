<?php
// Show a link to a member with their photo and name
if (!function_exists('member_list_item')) {
  function member_list_item($opts) {
    $ID = $opts['ID'];
    $show_image = array_key_exists('show_image', $opts) ? $opts['show_image'] : true;

    echo '<li><a href="' . get_permalink($ID) . '">';
    if ($show_image) {
      $imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id($ID), 'hgnm-thumb');
      if(!empty($imgsrc)) {
        echo '<img src="' . $imgsrc[0] . '" alt="' . get_the_title($ID) . '">';
      }
      else {
        echo '<img src="' . get_stylesheet_directory_uri() . '/img/fallback-200x200.gif" alt="' . get_the_title($ID) . '">';
      }
    }
    echo '<span>' . get_the_title($ID) . '</span>' . '</a></li>';
  }
}

member_list_item($opts)
?>
