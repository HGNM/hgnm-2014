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

// Set front page to display a “static” page
function set_front_page_to_home() {
  $homepage = get_page_by_title( 'Home' );
  if ( $homepage ) {
    update_option( 'page_on_front', $homepage->ID );
    update_option( 'show_on_front', 'page' );
  }
}
add_action( 'init', 'set_front_page_to_home');

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

// Customise WordPress login.php
function hgnm_login_css() { ?>
  <style type="text/css">
  body.login {
    background: #333;
  }
  body.login div#login h1 a {
    background-image: url(<?php echo get_bloginfo( 'template_directory' ) ?>/img/login-logo.png);
    background-size: 200px 75px;
    width: 200px;
  }
  body.login p#backtoblog, body.login p#nav {
    text-align: center;
  }
  </style>
  <link rel="shortcut icon" href="<?php echo home_url(); ?>/favico.ico"/>
  <?php }
add_action( 'login_enqueue_scripts', 'hgnm_login_css' );

// Use website URL for admin log-in logo link
function hgnm_url_login(){
  return home_url();
}
add_filter('login_headerurl', 'hgnm_url_login');

// Replace ‘Powered by WordPress’ logo alt text with site title
function hgnm_login_logo_title() {
  return get_bloginfo();
}
add_filter( 'login_headertitle', 'hgnm_login_logo_title' );

// Set up custom post types
include('functions-custom-post-types.php');

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
  if( ! function_exists('get_current_screen') )
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
  update_option( 'medium_size_w', 300 );
  update_option( 'medium_size_h', 550 );
}
add_action( 'after_switch_theme', 'options_setup' );

/* ==========================================
            THEME UPDATE CHECKER
   ========================================== */
// Initialize the update checker.
require 'theme-update-checker.php';
$example_update_checker = new ThemeUpdateChecker(
    'hgnm-2014',
    'https://raw.githubusercontent.com/HGNM/hgnm-2014/master/package.json'
);

/* ==========================================
   SET UP ADVANCED CUSTOM FIELDS FIELD GROUPS
   ========================================== */
include('functions-acf-field-groups.php');

/* ==========================================
   DISABLE WP-EMOJI
   ========================================== */
include('functions-disable-wp-emoji.php');

?>
