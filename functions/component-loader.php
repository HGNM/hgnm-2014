<?php
if (!function_exists('component')) {
  /**
   * Load a template component
   * @param  string $name The name of a component file to load
   * @param  any    $opts Options to pass to component function
   */
  function component($name, $opts = '') {
    include(locate_template("components/$name.php", false, false));
  }
}
?>
