<?php
/*  ==============================================
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
?>
