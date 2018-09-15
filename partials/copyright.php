<?php
// Generate a copyright string in the form:
// “Copyright © <START_YEAR>–<END_YEAR> Harvard Group for New Music”
if (!function_exists('hgnm_copyright')) {
  function hgnm_copyright() {
    global $wpdb;
    $copyright_dates = $wpdb->get_results("
      SELECT
      YEAR(min(post_date_gmt)) AS firstdate,
      YEAR(max(post_date_gmt)) AS lastdate
      FROM
      $wpdb->posts
      WHERE
      post_status = 'publish'
    ");
    $rightsholder = get_bloginfo('name');
    $output = '';
    if($copyright_dates) {
      $copyright = "Copyright &copy; " . $copyright_dates[0]->firstdate;
      if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
        $copyright .= '-' . $copyright_dates[0]->lastdate;
      }
      $copyright .= ' ' . $rightsholder;
      $output = $copyright;
    }
    return $output;
  }
}

echo hgnm_copyright();
?>
