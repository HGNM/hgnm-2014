<?php
// Fix empty <title>s, remove .hentry from posts, enqueue Google Fonts
include('functions/template-tweaks.php');

// Register template component loading method
include('functions/component-loader.php');

// Register custom menu
include('functions/custom-menu.php');

// Customise admin log-in page
include('functions/custom-login-page.php');

// Set up custom post types
include('functions/custom-post-types.php');

// Disable default post type and comments
include('functions/disable-default-post-types.php');

// Set-up custom columns and post sorting in backend
include('functions/custom-post-type-admin.php');

// Register custom image sizes
if ( function_exists( 'add_image_size' ) ) {
  add_image_size('hgnm-thumb', 200, 200, true);
  add_image_size('hgnm-main', 600, 400, true);
}

// Configure archive year query and permalink rewrites
include('functions/configure-archives.php');

// Configure core options
include('functions/configure-core-options.php');

// Initialize the theme update checker
require 'functions/theme-update-checker.php';
$example_update_checker = new ThemeUpdateChecker(
  'hgnm-2014',
  'https://raw.githubusercontent.com/HGNM/hgnm-2014/master/package.json'
);

// Set up Advanced Custom Fields field groups
include('functions/acf-field-groups.php');

 // Disable wp-emoji
include('functions/disable-wp-emoji.php');

?>
