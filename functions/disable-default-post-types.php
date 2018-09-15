<?php
// Remove default post type & comments from admin menu
function remove_menus(){
  remove_menu_page( 'edit.php' );
  remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'remove_menus' );

// Remove default post type from admin toolbar
function remove_toolbar_item( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'new-post' );
}
add_action( 'admin_bar_menu', 'remove_toolbar_item', 999 );
?>
