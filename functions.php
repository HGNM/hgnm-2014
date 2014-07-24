<?php

// Ensure <title> display in case of empty loop on custom home page
add_filter( 'wp_title', 'baw_hack_wp_title_for_home' );
function baw_hack_wp_title_for_home( $title )
{
  if( empty( $title ) && ( is_home() || is_front_page() ) ) {
    return __( 'Home', 'theme_domain' );
  }
  return $title;
}

// Register custom menu
if ( function_exists( 'register_nav_menu' ) ) {
	register_nav_menu( 'primary', 'Primary Menu' );
}

// Enqueue Google Fonts
 function load_fonts() {
            wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Alegreya:400italic,400,700|Alegreya+Sans:400,700');
            wp_enqueue_style( 'googleFonts');
        }
    
    add_action('wp_print_styles', 'load_fonts');

// Function for dynamic copyright date in footer
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

// Register Member Custom Post Type
function member_post_type() {

	$labels = array(
		'name'                => _x( 'Members', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Member', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Members', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Members', 'text_domain' ),
		'view_item'           => __( 'View Member', 'text_domain' ),
		'add_new_item'        => __( 'Add New Member', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'edit_item'           => __( 'Edit Member', 'text_domain' ),
		'update_item'         => __( 'Update Member', 'text_domain' ),
		'search_items'        => __( 'Search Members', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                => 'composer',
		'with_front'          => true,
		'pages'               => true,
		'feeds'               => true,
	);
	$args = array(
		'label'               => __( 'member', 'text_domain' ),
		'description'         => __( 'Entry containing information about an HGNM member', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-id-alt',
		'can_export'          => true,
		'has_archive'         => 'composers',
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'capability_type'     => 'post',
	);
	register_post_type( 'member', $args );

}

// Hook into the 'init' action
add_action( 'init', 'member_post_type', 0 );

// Register Concert Custom Post Type
function concert_post_type() {

	$labels = array(
		'name'                => _x( 'Concerts', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Concert', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Concerts', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Concerts', 'text_domain' ),
		'view_item'           => __( 'View Concert', 'text_domain' ),
		'add_new_item'        => __( 'Add New Concert', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'edit_item'           => __( 'Edit Concert', 'text_domain' ),
		'update_item'         => __( 'Update Concert', 'text_domain' ),
		'search_items'        => __( 'Search Concerts', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                => 'concert',
		'with_front'          => true,
		'pages'               => true,
		'feeds'               => true,
	);
	$args = array(
		'label'               => __( 'concert', 'text_domain' ),
		'description'         => __( 'Entry containing information about an HGNM concert', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-format-audio',
		'can_export'          => true,
		'has_archive'         => 'archives',
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'capability_type'     => 'post',
	);
	register_post_type( 'concert', $args );

}

// Hook into the 'init' action
add_action( 'init', 'concert_post_type', 0 );

// Register Colloquium Custom Post Type
function colloquium_post_type() {

	$labels = array(
		'name'                => _x( 'Colloquia', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Colloquium', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Colloquia', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Colloquia', 'text_domain' ),
		'view_item'           => __( 'View Colloquium', 'text_domain' ),
		'add_new_item'        => __( 'Add New Colloquium', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'edit_item'           => __( 'Edit Colloquium', 'text_domain' ),
		'update_item'         => __( 'Update Colloquium', 'text_domain' ),
		'search_items'        => __( 'Search Colloquia', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                => 'colloquium',
		'with_front'          => true,
		'pages'               => true,
		'feeds'               => true,
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-format-chat',
		'can_export'          => true,
		'has_archive'         => 'events',
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'capability_type'     => 'post',
	);
	register_post_type( 'colloquium', $args );

}

// Hook into the 'init' action
add_action( 'init', 'colloquium_post_type', 0 );

// Register Miscellaneous Event Post Type
function miscevent_post_type() {

	$labels = array(
		'name'                => _x( 'Misc. Events', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Misc. Event', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Misc. Events', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Misc. Events', 'text_domain' ),
		'view_item'           => __( 'View Misc. Event', 'text_domain' ),
		'add_new_item'        => __( 'Add New Misc. Event', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'edit_item'           => __( 'Edit Misc. Event', 'text_domain' ),
		'update_item'         => __( 'Update Misc. Event', 'text_domain' ),
		'search_items'        => __( 'Search Misc. Events', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                => 'other-events',
		'with_front'          => true,
		'pages'               => true,
		'feeds'               => true,
	);
	$args = array(
		'label'               => __( 'miscevent', 'text_domain' ),
		'description'         => __( 'Miscellaneous HGNM events that don’t fall into the concert/colloquium category', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-calendar',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'capability_type'     => 'post',
	);
	register_post_type( 'miscevent', $args );

}

// Hook into the 'init' action
add_action( 'init', 'miscevent_post_type', 0 );

// Remove default post type & comments from admin menu
function remove_menus(){
  remove_menu_page( 'edit.php' );
  remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'remove_menus' );

// Remove default post type from admin toolbar
add_action( 'admin_bar_menu', 'remove_toolbar_item', 999 );

function remove_toolbar_item( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'new-post' );
}

// Enable Featured Image for Member Custom Post Type
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails', array( 'member', 'concert', 'miscevent' ) );
}

// Register custom image sizes
if ( function_exists( 'add_image_size' ) ) {
	add_image_size('hgnm-thumb', 200, 200, true);
	add_image_size('hgnm-main', 600, 400, true);
}

// Add ability to query custom year variable for use on archive page
function add_query_vars_filter( $vars ){
  $vars[] = "y";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );

// Create rewrite rules for pretty permalinks on archive pages
function archive_add_rewrite_rules() {
	add_rewrite_rule(
		'^archives/([0-9]{4})/?$',
		'index.php?y=$matches[1]&post_type=concert',
		'top'
	);
	add_rewrite_rule(
		'^events/?$',
		'index.php?post_type=colloquium',
		'top'
	);
}
add_action('init', 'archive_add_rewrite_rules');

// Flush rewrite rules after theme is activated
function my_rewrite_flush() {
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'my_rewrite_flush' );

?>