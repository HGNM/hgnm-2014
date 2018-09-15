<?php
if (!function_exists('colloquium_list')) {
  function colloquium_list($opts)
  {
    $show_map_link = array_key_exists('show_map_link', $opts) ? $opts['show_map_link'] : false;

    echo '<ul>';
    foreach($opts['colloquia'] as $colloquium) {
      component('colloquium_list_item', $colloquium->ID);
    }
    echo '</ul>';
    if ($show_map_link) {
      echo '<p class="map-popup">All colloquia are at 12pm in Room 6, <a href="https://www.google.com/maps/place/Music+Bldg,+Harvard+University,+Cambridge,+MA+02138/@42.3769058,-71.1170215,15z/data=!4m2!3m1!1s0x89e3774164253f4d:0x4139366065ac28ee" class="icon-location">Harvard University Music Building</a></p>';
    }
  }
}

colloquium_list($opts)
?>
