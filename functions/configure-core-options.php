<?php
// Set front page to display a “static” page
function set_front_page_to_home() {
  $homepage = get_page_by_title( 'Home' );
  if ( $homepage ) {
    update_option( 'page_on_front', $homepage->ID );
    update_option( 'show_on_front', 'page' );
  }
}
add_action( 'init', 'set_front_page_to_home');

// Setup core options on theme activation
function options_setup() {
	update_option( 'default_comment_status', 'closed' );
	update_option( 'default_ping_status', 'closed' );
	update_option( 'blogname', 'Harvard Group for New Music' );
	update_option( 'blogdescription', 'The community of graduate composers at Harvard University' );
	update_option( 'timezone_string', 'America/New_York' );
	update_option( 'permalink_structure', '/%postname%/' );
	update_option( 'show_on_front', 'page' );
	update_option( 'use_smilies', 0 );
  update_option( 'medium_size_w', 300 );
  update_option( 'medium_size_h', 550 );
}
add_action( 'after_switch_theme', 'options_setup' );
?>
