<?php
/**
 * Theme header. Initialises HTML file based on HTML5 Boilerplate; includes page title and menu.
 */
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>
			<?php if (function_exists('is_tag') && is_tag()) {
				echo 'Tag Archive for &quot;'.$tag.'&quot; - ';
			}
			elseif (is_post_type_archive('concert')) {
				// If there is a year query, e.g. '?y=2012', get it and use it as a variable, else set it to the current year
				if(get_query_var('y')) {
					if (filter_var(get_query_var('y'), FILTER_VALIDATE_INT, array('options' => array ('min_range' => 0, 'max_range' => 9999,))) !== FALSE) {
						$yearquery = get_query_var('y');
					}
				}
				else {
					// Set correct year query from current date when no query_var present
					if (date('m') > 8) {
						$yearquery = date('Y') - 1;
					}
					else {
						$yearquery = date('Y') - 2;
					}
				}
				// Set pretty season range
				// Format 'YYYY–YY' unless turn of century, in which case 'YYYY–YYYY'
				if (($yearquery % 100) == 99) {
					$seasontitle = $yearquery . '–' . ($yearquery + 1);
				}
				else {
					$seasontitle = $yearquery . '–' . str_pad((($yearquery + 1) % 100), 2, '0', STR_PAD_LEFT);
				}
				echo $seasontitle . ' Event Archives - ';
			}
			elseif (is_post_type_archive('colloquium')) {
				echo 'Upcoming Events - ';
			}
			elseif (is_post_type_archive('member')) {
				echo 'Composers - ';
			}
			elseif (is_archive()) {
				wp_title('');
				echo ' Archive - ';
			}
			elseif (is_search()) {
				echo 'Search for &quot;'.wp_specialchars($s).'&quot; - ';
			}
			elseif (!(is_404()) && (is_single()) || (is_page())) {
				wp_title('');
				echo ' - ';
			}
			elseif (is_404()) {
				echo 'Not Found - ';
			}
			if (is_home()) {
				bloginfo('name');
				echo ' - ';
				bloginfo('description');
			}
			else {
				bloginfo('name');
			} ?>
		</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php _e (get_stylesheet_directory_uri() . '/css/magnific-popup.css'); ?>" type="text/css" media="screen" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<link rel="shortcut icon" sizes="16x16 32x32 48x48 64x64" href="http://hgnm.org/favicon.ico">
		<link rel="apple-touch-icon-precomposed" href="<?php _e (get_stylesheet_directory_uri() . '/img/favicon-152.png'); ?>">
		<meta name="msapplication-TileColor" content="#30ff8a">
		<meta name="msapplication-TileImage" content="<?php _e (get_stylesheet_directory_uri() . '/img/favicon-144.png'); ?>">
		
		<script src="<?php _e (get_stylesheet_directory_uri() . '/js/vendor/modernizr-2.6.2.min.js'); ?>"></script>
		
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?> lang="en">
		<!--[if lt IE 7]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
		<div id="page" class="site">

			<header id="masthead" class="site-header js-header clearfix" role="banner">
			
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php // Finds characters that are not uppercase and wraps them in a span of class 'lowercase'
						$title = get_bloginfo('name');
						$i = 0;
						while ($i < strlen($title)) {
							if (!ctype_upper($title[$i])) {
								$startpos = $i;
								while ($i < strlen($title) && !ctype_upper($title[$i+1])) {
									$i++;
								}
								$endpos = $i+1;
								$j = $startpos;
								echo '<span class="lowercase">';
								while ($j >= $startpos && $j < $endpos) {
									echo $title[$j];
									$j++;
								}
								echo '</span>';
							}
							else {
								echo $title[$i];
							}
							$i++;
						}
					?>
				</a></h1>
	
				<nav id="menu" class="menu js-menu" role="navigation">
			        	<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'false', 'menu_class' => '' ) ); ?>
				</nav>
				
			</header>
			<div id="torso">