<?php
// Register custom menu
function register_my_menu() {
  register_nav_menu('primary',__( 'Primary Menu' ));
}
add_action( 'init', 'register_my_menu' );

function assign_menu_location() {
  $locations = get_nav_menu_locations();
  if(empty($locations) || $locations['primary'] == 0) {
    $menu = get_term_by('slug', 'main-menu', 'nav_menu');
    if(isset($menu)) {
      $locations['primary'] = $menu->term_id;
    }
    set_theme_mod('nav_menu_locations', $locations);
  }
}
add_action( 'init', 'assign_menu_location');
?>
