<?php
// Ensure <title> display in case of empty loop on custom home page
function baw_hack_wp_title_for_home( $title ) {
  if( empty( $title ) && ( is_home() || is_front_page() ) ) {
    return __( 'Home', 'theme_domain' );
  }
  return $title;
}
add_filter( 'wp_title', 'baw_hack_wp_title_for_home' );

// Remove hentry from post_class
function isa_remove_hentry_class( $classes ) {
  $classes = array_diff( $classes, array( 'hentry' ) );
  return $classes;
}
add_filter( 'post_class', 'isa_remove_hentry_class' );

// Enqueue Google Fonts
function load_fonts() {
  wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Alegreya:400italic,400,700|Alegreya+Sans:400,700');
  wp_enqueue_style( 'googleFonts');
}
add_action('wp_print_styles', 'load_fonts');
?>
