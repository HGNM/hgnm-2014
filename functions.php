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

// Remove hentry from post_class
function isa_remove_hentry_class( $classes ) {
  $classes = array_diff( $classes, array( 'hentry' ) );
  return $classes;
}
add_filter( 'post_class', 'isa_remove_hentry_class' );

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

/*	==============================================
	CUSTOM COLUMNS IN ADMIN
	============================================== */
// Get date start
function get_dtstart($post_ID) {
    $dtstart = get_field('dtstart', $post_ID);
    if ($dtstart) {
        $startdate = DateTime::createFromFormat('d/m/Y', $dtstart);
        return $startdate->format('Y/m/d')	;
    }
}
// Add new column
function hgnm_columns_head($defaults) {
	$columns = array_slice($defaults, 0, 2, true) +
    array("dtstart" => "Event Start Date") +
    array_slice($defaults, 2, count($defaults) - 1, true) ;
    return $columns;
}
// Show the start date
function hgnm_columns_content($column_name, $post_ID) {
    if ($column_name == 'dtstart') {
        $post_date = get_dtstart($post_ID);
        if ($post_date) {
            echo $post_date;
        }
    }
}
// Hook 
add_filter('manage_concert_posts_columns', 'hgnm_columns_head');
add_action('manage_concert_posts_custom_column', 'hgnm_columns_content', 10, 2);
add_filter('manage_colloquium_posts_columns', 'hgnm_columns_head');
add_action('manage_colloquium_posts_custom_column', 'hgnm_columns_content', 10, 2);
add_filter('manage_miscevent_posts_columns', 'hgnm_columns_head');
add_action('manage_miscevent_posts_custom_column', 'hgnm_columns_content', 10, 2);
// Make sortable
add_filter( 'manage_edit-concert_sortable_columns', 'my_sortable_dtstart_column' );
add_filter( 'manage_edit-colloquium_sortable_columns', 'my_sortable_dtstart_column' );
add_filter( 'manage_edit-miscevent_sortable_columns', 'my_sortable_dtstart_column' );
function my_sortable_dtstart_column( $columns ) {
	$columns['dtstart'] = 'dtstart';
	return $columns;
}
// Fix orderby query
add_action( 'pre_get_posts', 'my_dtstart_orderby' );
function my_dtstart_orderby( $query ) {
	if( ! is_admin() )
		return;
		
	$screen = get_current_screen();
	if ($screen->base == 'edit') {
		if ( $screen->post_type == 'concert' || $screen->post_type == 'colloquium' || $screen->post_type == 'miscevent' ) {
			$orderby = $query->get( 'orderby');
			if( 'dtstart' == $orderby || 'menu_order title' != $orderby && 'date' != $orderby && 'title' != $orderby ) {
		        $query->set('meta_key','dtstart');
	    	    $query->set('orderby','meta_value_num');
			}
	    }
	}
}

// Add custom post types to dashboard ‘At a Glance’ module
add_action( 'dashboard_glance_items', 'cpad_at_glance_content_table_end' );
function cpad_at_glance_content_table_end() {
    $args = array(
        'public' => true,
        '_builtin' => false
    );
    $output = 'object';
    $operator = 'and';

    $post_types = get_post_types( $args, $output, $operator );
    foreach ( $post_types as $post_type ) {
        $num_posts = wp_count_posts( $post_type->name );
        $num = number_format_i18n( $num_posts->publish );
        $text = _n( $post_type->labels->singular_name, $post_type->labels->name, intval( $num_posts->publish ) );
        if ( current_user_can( 'edit_posts' ) ) {
            $output = '<a href="edit.php?post_type=' . $post_type->name . '">' . $num . ' ' . $text . '</a>';
            echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';
            } else {
            $output = '<span>' . $num . ' ' . $text . '</span>';
                echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';
            }
    }
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
}
add_action( 'after_switch_theme', 'options_setup' );

?>