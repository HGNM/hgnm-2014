<?php
if (!function_exists('component')) {
  function component($name) {
    include(locate_template("components/$name", false, false));
  }
}
?>
