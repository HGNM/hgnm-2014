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
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_539c70b07c8ad',
	'title' => 'Colloquia',
	'fields' => array (
		array (
			'key' => 'field_539c7240c1191',
			'label' => 'Use speaker’s full name for title, e.g. “Chaya Czernowin”.',
			'name' => '',
			'type' => 'message',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'If the colloquium is a post-concert discussion, use the performer(s)’s full name, e.g. “ELISION Ensemble” or “Séverine Ballon”.',
			'esc_html' => 0,
			'new_lines' => 'wpautop',
		),
		array (
			'key' => 'field_539c70f2d0e16',
			'label' => 'Colloquium Type',
			'name' => 'colloquium_type',
			'type' => 'radio',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array (
				'HGNM Member' => 'HGNM Member',
				'Guest Speaker' => 'Guest Speaker',
				'Post-Concert Discussion' => 'Post-Concert Discussion',
			),
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'HGNM Member',
			'layout' => 'horizontal',
			'allow_null' => 0,
		),
		array (
			'key' => 'field_539c713ed0e17',
			'label' => 'HGNM Member',
			'name' => 'fname',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_539c70f2d0e16',
						'operator' => '==',
						'value' => 'HGNM Member',
					),
				),
			),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array (
				0 => 'member',
			),
			'taxonomy' => array (
			),
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'object',
			'ui' => 1,
		),
		array (
			'key' => 'field_539dcc5aba491',
			'label' => 'Which Concert?',
			'name' => 'concert_rel',
			'type' => 'post_object',
			'instructions' => 'Which concert does this colloquium follow and discuss?',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_539c70f2d0e16',
						'operator' => '==',
						'value' => 'Post-Concert Discussion',
					),
				),
			),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array (
				0 => 'concert',
			),
			'taxonomy' => array (
			),
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'object',
			'ui' => 1,
		),
		array (
			'key' => 'field_539c716dd0e18',
			'label' => 'Guest Speaker’s Personal Website',
			'name' => 'url',
			'type' => 'url',
			'instructions' => 'Website address for the guest speaker, e.g. http://www.fullname.com',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_539c70f2d0e16',
						'operator' => '==',
						'value' => 'Guest Speaker',
					),
				),
			),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placeholder' => 'http://',
			'default_value' => '',
		),
		array (
			'key' => 'field_539c7213c1190',
			'label' => 'Date',
			'name' => 'dtstart',
			'type' => 'date_picker',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'm/d/Y',
			'return_format' => 'd/m/Y',
			'first_day' => 1,
		),
		array (
			'key' => 'field_540cc8f474066',
			'label' => 'Colloquium Announcement Flyer',
			'name' => 'photo',
			'type' => 'image',
			'instructions' => 'Upload an image file of the colloquium announcement flyer',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'hgnm-main',
			'library' => 'all',
			'min_width' => 0,
			'min_height' => 0,
			'min_size' => 0,
			'max_width' => 0,
			'max_height' => 0,
			'max_size' => 0,
			'mime_types' => '',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'colloquium',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array (
		0 => 'the_content',
	),
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array (
	'key' => 'group_539c5c7f985b6',
	'title' => 'Concerts',
	'fields' => array (
		array (
			'key' => 'field_539c33340295e',
			'label' => 'Use the performer or ensemble name as the title of the concert, e.g. “ELISION Ensemble” or “hand werk”',
			'name' => '',
			'type' => 'message',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'esc_html' => 0,
			'new_lines' => 'wpautop',
		),
		array (
			'key' => 'field_539b14f937947',
			'label' => 'Event Details',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array (
			'key' => 'field_5397170b0edea',
			'label' => 'Concert Date',
			'name' => 'dtstart',
			'type' => 'date_picker',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'm/d/Y',
			'return_format' => 'd/m/Y',
			'first_day' => 1,
		),
		array (
			'key' => 'field_53d04a547f12b',
			'label' => 'Concert Time',
			'name' => 'start_time',
			'type' => 'time_picker',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'g:i a',
			'return_format' => 'G:i',
		),
		array (
			'key' => 'field_539b1547a8d9d',
			'label' => 'Venue',
			'name' => 'location',
			'type' => 'radio',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array (
				'Paine Hall<br />Harvard University' => 'Paine Hall',
			),
			'other_choice' => 1,
			'save_other_choice' => 1,
			'default_value' => 'Paine Hall<br />Harvard University',
			'layout' => 'horizontal',
			'allow_null' => 0,
			'return_format' => 'value',
		),
		array (
			'key' => 'field_54021a0e5e714',
			'label' => 'Is the concert a Goldberg or Fromm residency?',
			'name' => 'support',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array (
				'Neither' => 'Neither',
				'Fromm' => 'Fromm',
				'Goldberg' => 'Goldberg',
			),
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'Neither',
			'layout' => 'horizontal',
			'allow_null' => 0,
			'return_format' => 'value',
		),
		array (
			'key' => 'field_539b1d6612f14',
			'label' => 'Performer’s personal website',
			'name' => 'performer_url',
			'type' => 'url',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placeholder' => 'http://',
			'default_value' => '',
		),
		array (
			'key' => 'field_53bdd228648f6',
			'label' => 'Facebook Event URL',
			'name' => 'facebook_url',
			'type' => 'url',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placeholder' => 'http://',
			'default_value' => '',
		),
		array (
			'key' => 'field_539c33ffb6444',
			'label' => 'Summary',
			'name' => 'summary',
			'type' => 'wysiwyg',
			'instructions' => 'Short description of the concert. Composers will be listed elsewhere, so focus on the ensemble, e.g. “HGNM welcome Australia’s leading performers of contemporary music in a programme of new works for wind, brass, guitar and percussion.”',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'toolbar' => 'basic',
			'media_upload' => 0,
			'tabs' => 'all',
			'delay' => 0,
		),
		array (
			'key' => 'field_539b14e037946',
			'label' => 'Programme Details',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array (
			'key' => 'field_539d881cf4335',
			'label' => 'Add audio/video',
			'name' => 'a_v',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'Show audio/video embedding options?',
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array (
			'key' => 'field_539c5e6fe8895',
			'label' => 'Programme',
			'name' => 'programme',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'min' => 0,
			'max' => 0,
			'layout' => 'row',
			'button_label' => 'Add Piece',
			'sub_fields' => array (
				array (
					'key' => 'field_539c5e9ee8896',
					'label' => 'Composer',
					'name' => 'composer',
					'type' => 'post_object',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'post_type' => array (
						0 => 'member',
					),
					'taxonomy' => array (
					),
					'allow_null' => 0,
					'multiple' => 0,
					'return_format' => 'object',
					'ui' => 1,
				),
				array (
					'key' => 'field_539c5ecde8897',
					'label' => 'Work Title',
					'name' => 'work_title',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => 'Work Title',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'formatting' => 'none',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_539c5fecf141d',
					'label' => 'Embed Link',
					'name' => 'embed_link',
					'type' => 'oembed',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_539d881cf4335',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'width' => '',
					'height' => '',
				),
				array (
					'key' => 'field_539d89b16e59c',
					'label' => 'Audio or Video?',
					'name' => 'a_or_v',
					'type' => 'radio',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_539d881cf4335',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array (
						'none' => 'n/a',
						'Audio' => 'Audio',
						'Video' => 'Video',
					),
					'other_choice' => 0,
					'save_other_choice' => 0,
					'default_value' => 'none',
					'layout' => 'vertical',
					'allow_null' => 0,
					'return_format' => 'value',
				),
			),
			'collapsed' => '',
		),
		array (
			'key' => 'field_539d86606956b',
			'label' => 'Works by non-members',
			'name' => 'programme_plus',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'min' => 0,
			'max' => 0,
			'layout' => 'row',
			'button_label' => 'Add Piece',
			'sub_fields' => array (
				array (
					'key' => 'field_55f98c9a8065a',
					'label' => 'Composer',
					'name' => 'composer',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => 'Composer’s Full Name',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_55f98cbc8065b',
					'label' => 'Work Title',
					'name' => 'work_title',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => 'Work Title',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_55f98cdf8065c',
					'label' => 'Embed Link',
					'name' => 'embed_link',
					'type' => 'oembed',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_539d881cf4335',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'width' => '',
					'height' => '',
				),
				array (
					'key' => 'field_55f98d128065d',
					'label' => 'Audio or Video?',
					'name' => 'a_or_v',
					'type' => 'radio',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_539d881cf4335',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array (
						'none' => 'n/a',
						'Audio' => 'Audio',
						'Video' => 'Video',
					),
					'other_choice' => 0,
					'save_other_choice' => 0,
					'default_value' => '',
					'layout' => 'vertical',
					'allow_null' => 0,
					'return_format' => 'value',
				),
			),
			'collapsed' => '',
		),
		array (
			'key' => 'field_539c36c46b3ff',
			'label' => 'Archive Material',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array (
			'key' => 'field_539c36e56b400',
			'label' => 'Programme PDF',
			'name' => 'programme_pdf',
			'type' => 'file',
			'instructions' => 'Upload a PDF of the concert programme once it is available.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'library' => 'all',
			'return_format' => 'array',
			'min_size' => 0,
			'max_size' => 0,
			'mime_types' => '',
		),
		array (
			'key' => 'field_539c47977df0c',
			'label' => 'Poster PDF',
			'name' => 'poster_pdf',
			'type' => 'file',
			'instructions' => 'Upload a PDF of the concert poster once it is available.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'library' => 'all',
			'return_format' => 'array',
			'min_size' => 0,
			'max_size' => 0,
			'mime_types' => '',
		),
		array (
			'key' => 'field_53bfaf6f4ba4a',
			'label' => 'Concert Photos',
			'name' => 'gallery',
			'type' => 'gallery',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'min' => '',
			'max' => '',
			'preview_size' => 'thumbnail',
			'library' => 'uploadedTo',
			'min_width' => 0,
			'min_height' => 0,
			'min_size' => 0,
			'max_width' => 0,
			'max_height' => 0,
			'max_size' => 0,
			'mime_types' => '',
			'insert' => 'append',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'concert',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array (
		0 => 'the_content',
	),
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array (
	'key' => 'group_539d800c2d788',
	'title' => 'Editorial Guides (Members)',
	'fields' => array (
		array (
			'key' => 'field_539d801827585',
			'label' => 'Editorial Guidelines',
			'name' => '',
			'type' => 'message',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'Use the title field (above) for the member’s full name, e.g. “Joanna Smith”, and the field below for the member’s biography.

Further details should be provided on the right. The featured image field should be used to upload a portrait photograph.',
			'esc_html' => 0,
			'new_lines' => 'wpautop',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'member',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array (
	'key' => 'group_539c65c537059',
	'title' => 'Member Details',
	'fields' => array (
		array (
			'key' => 'field_539c65df88669',
			'label' => 'Became Member',
			'name' => 'dtstart',
			'type' => 'date_picker',
			'instructions' => 'Year in which this member joined HGNM [Use September 1]',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'm/d/Y',
			'return_format' => 'Ymd',
			'first_day' => 1,
		),
		array (
			'key' => 'field_539c66228866a',
			'label' => 'Year Graduated',
			'name' => 'dtend',
			'type' => 'date_picker',
			'instructions' => 'If no longer a current member, year in which this member left HGNM [Use July 1]',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'm/d/Y',
			'return_format' => 'Ymd',
			'first_day' => 1,
		),
		array (
			'key' => 'field_539c66498866b',
			'label' => 'Personal Website',
			'name' => 'url',
			'type' => 'url',
			'instructions' => 'Must start with http:// (or https://)',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placeholder' => 'http://',
			'default_value' => '',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'member',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'side',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array (
	'key' => 'group_53ba94605aef9',
	'title' => 'Other Events',
	'fields' => array (
		array (
			'key' => 'field_53ba9460600e2',
			'label' => 'Use the event title, e.g. “HGNM Conference: New Perspectives on New Music” or “HGNM Composers in Lyon”',
			'name' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
		array (
			'key' => 'field_53ba9460600fa',
			'label' => 'Event Start Date',
			'name' => 'dtstart',
			'type' => 'date_picker',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'm/d/Y',
			'return_format' => 'd/m/Y',
			'first_day' => 1,
		),
		array (
			'key' => 'field_53d01b4c3c002',
			'label' => 'Event Start Time',
			'name' => 'start_time',
			'type' => 'time_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'g:i a',
			'return_format' => 'G:i',
		),
		array (
			'key' => 'field_53ba9c39ef620',
			'label' => 'Event End Date',
			'name' => 'dtend',
			'type' => 'date_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'm/d/Y',
			'return_format' => 'd/m/Y',
			'first_day' => 1,
		),
		array (
			'key' => 'field_55fd83ce00f86',
			'label' => 'Event Details',
			'name' => 'details',
			'type' => 'flexible_content',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'button_label' => 'Add Content',
			'min' => '',
			'max' => '',
			'layouts' => array (
				array (
					'key' => '55fd83dd43b62',
					'name' => 'description',
					'label' => 'Description',
					'display' => 'row',
					'sub_fields' => array (
						array (
							'key' => 'field_55fd83ef00f87',
							'label' => 'Text',
							'name' => 'summary',
							'type' => 'wysiwyg',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'tabs' => 'all',
							'toolbar' => 'full',
							'media_upload' => 1,
							'delay' => 0,
						),
					),
					'min' => '',
					'max' => '',
				),
				array (
					'key' => '55fd842d00f88',
					'name' => 'location',
					'label' => 'Venue',
					'display' => 'row',
					'sub_fields' => array (
						array (
							'key' => 'field_55fd843b00f89',
							'label' => 'Venue Name',
							'name' => 'fn',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => 'e.g. ‘Goethe Institut, Boston’',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
							'readonly' => 0,
							'disabled' => 0,
						),
						array (
							'key' => 'field_55fd845500f8a',
							'label' => 'Street',
							'name' => 'street-address',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => 'e.g. ‘170 Beacon St’',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
							'readonly' => 0,
							'disabled' => 0,
						),
						array (
							'key' => 'field_55fd846b00f8b',
							'label' => 'City',
							'name' => 'locality',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => 'e.g. ‘Boston’',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
							'readonly' => 0,
							'disabled' => 0,
						),
						array (
							'key' => 'field_55fd848100f8c',
							'label' => 'State/Region',
							'name' => 'region',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => 'e.g. ‘MA’',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
							'readonly' => 0,
							'disabled' => 0,
						),
						array (
							'key' => 'field_55fd849100f8d',
							'label' => 'ZIP/Post Code',
							'name' => 'postal-code',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => 'e.g. ‘ 02116’',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
							'readonly' => 0,
							'disabled' => 0,
						),
						array (
							'key' => 'field_55fd84c000f8e',
							'label' => 'Country',
							'name' => 'country-name',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => 'e.g. ‘United States’',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
							'readonly' => 0,
							'disabled' => 0,
						),
					),
					'min' => '',
					'max' => '',
				),
				array (
					'key' => '55fd84d300f8f',
					'name' => 'link',
					'label' => 'External Link',
					'display' => 'row',
					'sub_fields' => array (
						array (
							'key' => 'field_55fd84df00f90',
							'label' => 'URL',
							'name' => 'url',
							'type' => 'url',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => 'http://',
						),
						array (
							'key' => 'field_55fd84fd00f91',
							'label' => 'Link Text',
							'name' => 'title',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => 'See event website',
							'placeholder' => '',
							'prepend' => '',
							'append' => '»',
							'maxlength' => '',
							'readonly' => 0,
							'disabled' => 0,
						),
					),
					'min' => '',
					'max' => '',
				),
				array (
					'key' => '55fd852200f92',
					'name' => 'photos',
					'label' => 'Photos',
					'display' => 'row',
					'sub_fields' => array (
						array (
							'key' => 'field_55fd852a00f93',
							'label' => 'Photo Gallery',
							'name' => 'gallery',
							'type' => 'gallery',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'min' => '',
							'max' => '',
							'preview_size' => 'hgnm-thumb',
							'library' => 'all',
							'min_width' => '',
							'min_height' => '',
							'min_size' => '',
							'max_width' => '',
							'max_height' => '',
							'max_size' => '',
							'mime_types' => '',
							'insert' => 'append',
						),
					),
					'min' => '',
					'max' => '',
				),
				array (
					'key' => '55fd859900f94',
					'name' => 'videos',
					'label' => 'Videos',
					'display' => 'row',
					'sub_fields' => array (
						array (
							'key' => 'field_55fd85a500f95',
							'label' => 'Videos',
							'name' => 'videos',
							'type' => 'repeater',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'min' => 0,
							'max' => 0,
							'layout' => 'table',
							'button_label' => 'Add Video',
							'sub_fields' => array (
								array (
									'key' => 'field_55fd85b500f96',
									'label' => 'Embed Link',
									'name' => 'embed_link',
									'type' => 'oembed',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array (
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'width' => '',
									'height' => '',
								),
							),
							'collapsed' => '',
						),
					),
					'min' => '',
					'max' => '',
				),
				array (
					'key' => '55fd860900f97',
					'name' => 'documents',
					'label' => 'Documents',
					'display' => 'row',
					'sub_fields' => array (
						array (
							'key' => 'field_55fd861800f98',
							'label' => 'Upload programmes, proceedings, posters etc.',
							'name' => 'document',
							'type' => 'repeater',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'min' => 0,
							'max' => 0,
							'layout' => 'table',
							'button_label' => 'Add Row',
							'sub_fields' => array (
								array (
									'key' => 'field_55fd862a00f99',
									'label' => 'File',
									'name' => 'file',
									'type' => 'file',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array (
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'return_format' => 'array',
									'library' => 'all',
									'min_size' => '',
									'max_size' => '',
									'mime_types' => '',
								),
								array (
									'key' => 'field_55fd864c00f9a',
									'label' => 'File Name',
									'name' => 'file_name',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array (
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
									'readonly' => 0,
									'disabled' => 0,
								),
							),
							'collapsed' => '',
						),
					),
					'min' => '',
					'max' => '',
				),
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'miscevent',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array (
		0 => 'the_content',
	),
	'active' => 1,
	'description' => '',
));

endif;

?>
