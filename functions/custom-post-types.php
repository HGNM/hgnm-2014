<?php
/*
This file is included in functions.php and sets up the custom post types used
by the hgnm-2014 theme: composer, concert, colloquium, miscevent
 */
// Register Member Custom Post Type
function member_post_type()
{
    $labels = array(
        'name'                => _x('Members', 'Post Type General Name', 'text_domain'),
        'singular_name'       => _x('Member', 'Post Type Singular Name', 'text_domain'),
        'menu_name'           => __('Members', 'text_domain'),
        'parent_item_colon'   => __('Parent Item:', 'text_domain'),
        'all_items'           => __('All Members', 'text_domain'),
        'view_item'           => __('View Member', 'text_domain'),
        'add_new_item'        => __('Add New Member', 'text_domain'),
        'add_new'             => __('Add New', 'text_domain'),
        'edit_item'           => __('Edit Member', 'text_domain'),
        'update_item'         => __('Update Member', 'text_domain'),
        'search_items'        => __('Search Members', 'text_domain'),
        'not_found'           => __('Not found', 'text_domain'),
        'not_found_in_trash'  => __('Not found in Trash', 'text_domain'),
    );
    $rewrite = array(
        'slug'                => 'composer',
        'with_front'          => true,
        'pages'               => true,
        'feeds'               => true,
    );
    $args = array(
        'label'               => __('member', 'text_domain'),
        'description'         => __('Entry containing information about an HGNM member', 'text_domain'),
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
    register_post_type('member', $args);
}

// Hook into the 'init' action
add_action('init', 'member_post_type', 0);

// Register Concert Custom Post Type
function concert_post_type()
{
    $labels = array(
        'name'                => _x('Concerts', 'Post Type General Name', 'text_domain'),
        'singular_name'       => _x('Concert', 'Post Type Singular Name', 'text_domain'),
        'menu_name'           => __('Concerts', 'text_domain'),
        'parent_item_colon'   => __('Parent Item:', 'text_domain'),
        'all_items'           => __('All Concerts', 'text_domain'),
        'view_item'           => __('View Concert', 'text_domain'),
        'add_new_item'        => __('Add New Concert', 'text_domain'),
        'add_new'             => __('Add New', 'text_domain'),
        'edit_item'           => __('Edit Concert', 'text_domain'),
        'update_item'         => __('Update Concert', 'text_domain'),
        'search_items'        => __('Search Concerts', 'text_domain'),
        'not_found'           => __('Not found', 'text_domain'),
        'not_found_in_trash'  => __('Not found in Trash', 'text_domain'),
    );
    $rewrite = array(
        'slug'                => 'concert',
        'with_front'          => true,
        'pages'               => true,
        'feeds'               => true,
    );
    $args = array(
        'label'               => __('concert', 'text_domain'),
        'description'         => __('Entry containing information about an HGNM concert', 'text_domain'),
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
    register_post_type('concert', $args);
}

// Hook into the 'init' action
add_action('init', 'concert_post_type', 0);

// Register Colloquium Custom Post Type
function colloquium_post_type()
{
    $labels = array(
        'name'                => _x('Colloquia', 'Post Type General Name', 'text_domain'),
        'singular_name'       => _x('Colloquium', 'Post Type Singular Name', 'text_domain'),
        'menu_name'           => __('Colloquia', 'text_domain'),
        'parent_item_colon'   => __('Parent Item:', 'text_domain'),
        'all_items'           => __('All Colloquia', 'text_domain'),
        'view_item'           => __('View Colloquium', 'text_domain'),
        'add_new_item'        => __('Add New Colloquium', 'text_domain'),
        'add_new'             => __('Add New', 'text_domain'),
        'edit_item'           => __('Edit Colloquium', 'text_domain'),
        'update_item'         => __('Update Colloquium', 'text_domain'),
        'search_items'        => __('Search Colloquia', 'text_domain'),
        'not_found'           => __('Not found', 'text_domain'),
        'not_found_in_trash'  => __('Not found in Trash', 'text_domain'),
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
    register_post_type('colloquium', $args);
}

// Hook into the 'init' action
add_action('init', 'colloquium_post_type', 0);

// Register Miscellaneous Event Post Type
function miscevent_post_type()
{
    $labels = array(
        'name'                => _x('Misc. Events', 'Post Type General Name', 'text_domain'),
        'singular_name'       => _x('Misc. Event', 'Post Type Singular Name', 'text_domain'),
        'menu_name'           => __('Misc. Events', 'text_domain'),
        'parent_item_colon'   => __('Parent Item:', 'text_domain'),
        'all_items'           => __('All Misc. Events', 'text_domain'),
        'view_item'           => __('View Misc. Event', 'text_domain'),
        'add_new_item'        => __('Add New Misc. Event', 'text_domain'),
        'add_new'             => __('Add New', 'text_domain'),
        'edit_item'           => __('Edit Misc. Event', 'text_domain'),
        'update_item'         => __('Update Misc. Event', 'text_domain'),
        'search_items'        => __('Search Misc. Events', 'text_domain'),
        'not_found'           => __('Not found', 'text_domain'),
        'not_found_in_trash'  => __('Not found in Trash', 'text_domain'),
    );
    $rewrite = array(
        'slug'                => 'other-events',
        'with_front'          => true,
        'pages'               => true,
        'feeds'               => true,
    );
    $args = array(
        'label'               => __('miscevent', 'text_domain'),
        'description'         => __('Miscellaneous HGNM events that don’t fall into the concert/colloquium category', 'text_domain'),
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
    register_post_type('miscevent', $args);
}

// Hook into the 'init' action
add_action('init', 'miscevent_post_type', 0);

/*  =======================================
    ADD FEATURED IMAGE TO CUSTOM POST TYPES
        =======================================  */
// Enable Featured Image for Custom Post Types
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails', array( 'member', 'concert', 'miscevent' ));
}

/*  ==================================
    ADD CUSTOM POST TYPES TO DASHBOARD
        ==================================  */
// Add custom post types to dashboard ‘At a Glance’ module
add_action('dashboard_glance_items', 'cpad_at_glance_content_table_end');
function cpad_at_glance_content_table_end()
{
    $args = array(
        'public' => true,
        '_builtin' => false
    );
    $output = 'object';
    $operator = 'and';

    $post_types = get_post_types($args, $output, $operator);
    foreach ($post_types as $post_type) {
        $num_posts = wp_count_posts($post_type->name);
        $num = number_format_i18n($num_posts->publish);
        $text = _n($post_type->labels->singular_name, $post_type->labels->name, intval($num_posts->publish));
        if (current_user_can('edit_posts')) {
            $output = '<a href="edit.php?post_type=' . $post_type->name . '">' . $num . ' ' . $text . '</a>';
            echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';
        } else {
            $output = '<span>' . $num . ' ' . $text . '</span>';
            echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';
        }
    }
}

// Show custom icons in ‘At a Glance’ module
add_action('admin_head', 'style_dashboard_glance_items');
function style_dashboard_glance_items()
{
    echo '<style>
    #dashboard_right_now .composer-count a:before,
    #dashboard_right_now .composer-count span:before {
      content: "\f337";
    }
    #dashboard_right_now .concert-count a:before,
    #dashboard_right_now .concert-count span:before {
      content: "\f127";
    }
    #dashboard_right_now .colloquium-count a:before,
    #dashboard_right_now .colloquium-count span:before {
      content: "\f125";
    }
    #dashboard_right_now .miscevent-count a:before,
    #dashboard_right_now .miscevent-count span:before {
      content: "\f145";
    }
  </style>';
}
