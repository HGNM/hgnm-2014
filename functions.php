<?php

// Ensure <title> display in case of empty loop on custom home page
add_filter( 'wp_title', 'baw_hack_wp_title_for_home' );
function baw_hack_wp_title_for_home( $title )
{
  if( empty( $title ) && ( is_home() || is_front_page() ) ) {
    return __( 'Home', 'theme_domain' ) . ' | ' . get_bloginfo( 'title' );
  }
  return $title;
}

// Register custom menu
register_nav_menu( 'primary', 'Primary Menu' );


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
add_theme_support( 'post-thumbnails', array( 'member', 'concert' ) );


// Get URL query and use it to display posts from a given academic year
// ?y=2013 will return posts between 1 September 2013 and 31 August 2014
add_action('pre_get_posts', 'my_pre_get_posts');
 
function my_pre_get_posts( $query )
{
	// validate
	if( is_admin() )
	{
		return;
	}
 
	if( !$query->is_main_query() )
	{
		return;
	}
 
	// get original meta query
	$meta_query = $query->get('meta_query');
 
        // allow the url to alter the query
        if( !empty($_GET['y']) )
        {
        	$dtstart = $_GET['y'];
        	$yearstart = $dtstart . '0901';
        	$yearend = ($dtstart + 1) . '0831';
        	$academicyear = array($yearstart,$yearend);
 
        	//Add our meta query to the original meta queries
	    	$meta_query[] = array(
                'key'		=> 'dtstart',
                'value'		=> $academicyear,
                'compare'	=> 'BETWEEN'
            );
        }
        // if no query, get current year
        else {
        	$dtstart = date("Y");
        	$yearstart = $dtstart . '0901';
        	$yearend = ($dtstart + 1) . '0831';
        	$academicyear = array($yearstart,$yearend);
 
        	//Add our meta query to the original meta queries
	    	$meta_query[] = array(
                'key'		=> 'dtstart',
                'value'		=> $academicyear,
                'compare'	=> 'BETWEEN'
            );
        }
 
	// update the meta query args
	$query->set('meta_query', $meta_query);
 
	// always return
	return;
 
}

?>