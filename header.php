<?php
/**
 * Theme header. Initialises HTML file based on HTML5 Boilerplate; includes page title and menu.
 */
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
      <?php if (function_exists('is_tag') && is_tag()) {
    echo 'Tag Archive for &quot;'.$tag.'&quot; - ';
} elseif (is_post_type_archive('concert')) {
    // If there is a year query, e.g. '?y=2012', get it and use it as a variable, else set it to the current year
    if (get_query_var('y')) {
        if (filter_var(get_query_var('y'), FILTER_VALIDATE_INT, array('options' => array('min_range' => 0, 'max_range' => 9999,))) !== false) {
            $yearquery = get_query_var('y');
        }
    } else {
        // Set correct year query from current date when no query_var present
        if (date('m') > 8) {
            $yearquery = date('Y') - 1;
        } else {
            $yearquery = date('Y') - 2;
        }
    }
    // Set pretty season range
    // Format 'YYYY–YY' unless turn of century, in which case 'YYYY–YYYY'
    if (($yearquery % 100) == 99) {
        $seasontitle = $yearquery . '–' . ($yearquery + 1);
    } else {
        $seasontitle = $yearquery . '–' . str_pad((($yearquery + 1) % 100), 2, '0', STR_PAD_LEFT);
    }
    echo $seasontitle . ' Event Archives - ';
} elseif (is_post_type_archive('colloquium')) {
    echo 'Upcoming Events - ';
} elseif (is_singular('colloquium')) {
    $colldt = DateTime::createFromFormat('d/m/Y', get_field('dtstart'));
    echo 'Colloquium: ' . get_the_title() . ', ' . $colldt->format('n/j/Y') . ' — ';
} elseif (is_singular('concert')) {
    $concdt = DateTime::createFromFormat('d/m/Y', get_field('dtstart'));
    echo get_the_title() . ', ' . $concdt->format('n/j/Y') . ' — ';
} elseif (is_post_type_archive('member')) {
    echo 'Composers - ';
} elseif (is_archive()) {
    wp_title('');
    echo ' Archive - ';
} elseif (is_search()) {
    echo 'Search for &quot;'.wp_specialchars($s).'&quot; - ';
} elseif (!(is_404()) && (is_single()) || (is_page())) {
    wp_title('');
    echo ' - ';
} elseif (is_404()) {
    echo 'Not Found - ';
}
            if (is_home()) {
                bloginfo('name');
                echo ' - ';
                bloginfo('description');
            } else {
                bloginfo('name');
            } ?>
    </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <link rel="shortcut icon" sizes="16x16 32x32 48x48 64x64" href="http://hgnm.org/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="<?php _e(get_stylesheet_directory_uri() . '/img/favicon-152.png'); ?>">
    <meta name="msapplication-TileColor" content="#30ff8a">
    <meta name="msapplication-TileImage" content="<?php _e(get_stylesheet_directory_uri() . '/img/favicon-144.png'); ?>">

    <link href="<?php _e(get_stylesheet_directory_uri() . '/font/DalaFloda-Bold-Web.woff2'); ?>" rel="preload" as="font" type="font/woff2" crossorigin>
    <link href="<?php _e(get_stylesheet_directory_uri() . '/font/hgnm.woff2'); ?>" rel="preload" as="font" type="font/woff2" crossorigin>
    <link href="<?php _e(get_stylesheet_directory_uri() . '/img/halftone.png'); ?>" rel="preload" as="image" type="image/png" crossorigin>

    <script async src="<?php _e(get_stylesheet_directory_uri() . '/js/vendor/modernizr-3.6.0.min.js'); ?>"></script>

    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?> lang="en">
    <div id="page" class="site">

      <header id="masthead" class="site-header js-header clearfix">

        <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
          <?php // Finds characters that are not uppercase and wraps them in a
                // span of class 'site-title__lowercase'
                // N.B. slightly hacky use of ctype_upper and ctype_lower in
                // conjunction. This allows us to wrap all non-uppercase
                // characters, but creates new spans at non-letter characters
                // such as spaces.
                        $title = get_bloginfo('name');
                        $i = 0;
                        while ($i < strlen($title)) {
                            if (!ctype_upper($title[$i])) {
                                $startpos = $i;
                                while ($i < (strlen($title) - 1) && ctype_lower($title[$i+1])) {
                                    $i++;
                                }
                                $endpos = $i+1;
                                $j = $startpos;
                                echo '<span class="site-title__lowercase">';
                                while ($j >= $startpos && $j < $endpos) {
                                    echo $title[$j];
                                    $j++;
                                }
                                echo '</span>';
                            } else {
                                echo $title[$i];
                            }
                            $i++;
                        }
                    ?>
        </a></h1>

        <nav id="menu" class="menu js-menu">
                <?php wp_nav_menu(array( 'theme_location' => 'primary', 'container' => 'false', 'menu_class' => '' )); ?>
        </nav>

      </header>
      <div id="torso">
