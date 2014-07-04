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
		<!-- <?php echo get_query_var('y'); ?> -->
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		
		<script src="<?php _e (get_stylesheet_directory_uri() . '/js/vendor/modernizr-2.6.2.min.js'); ?>"></script>
		
				<!-- Extra calls for development purposes (links to stylesheets etc. when accessing localhost remotely) -->
				<link rel="stylesheet" href="<?php _e (home_url('/wp-content/themes/hgnm-2014/style.css')); ?>" type="text/css" media="screen" />
				<script src="<?php _e (home_url('/wp-content/themes/hgnm-2014/js/vendor/modernizr-2.6.2.min.js')); ?>"></script>
				<!-- End dev calls -->
		
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<!--[if lt IE 7]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
		<div id="page" class="hfeed site">

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