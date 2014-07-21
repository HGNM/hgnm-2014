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