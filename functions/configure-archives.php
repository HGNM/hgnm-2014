<?php
// Add ability to query custom year variable for use on archive page
function add_query_vars_filter($vars)
{
    $vars[] = "y";
    return $vars;
}
add_filter('query_vars', 'add_query_vars_filter');

// Create rewrite rules for pretty permalinks on archive pages
function archive_add_rewrite_rules()
{
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
function my_rewrite_flush()
{
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'my_rewrite_flush');
