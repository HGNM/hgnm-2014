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
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		
		<script src="<?php _e (get_stylesheet_directory_uri() . '/js/vendor/modernizr-2.6.2.min.js'); ?>"></script>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<!--[if lt IE 7]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
        
		<header id="masthead" class="site-header js-header" role="banner">
		
        	<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php // Finds characters that are not uppercase and wraps them in a span of class 'lowercase'
					$title = get_bloginfo('name');
					$i = 0;
					while ($i < strlen($title)) {
						if (ctype_upper($title[$i])) {
							echo $title[$i];
							$j = $i + 1;
							if (!ctype_upper($title[$j])) {
								echo '<span class="lowercase">';
								while ($j < strlen($title)) {
									if (ctype_upper($title[$j])) {
										break 1;
									}
									else {
										echo $title[$j];
									}
									$j++;
								}
								echo '</span>';
							}
						}
						elseif ($i == 0 && !ctype_upper($title[$i])) { // Wraps initial lowercase segment where initial char not uppercase
							echo '<span class="lowercase">' . $title[$i];
							$k = $i + 1;
							while ($k < strlen($title)) {
								if (ctype_upper($title[$k])) {
									break 1;
								}
								else {
									echo $title[$k];
								}
								$k++;
							}
							echo '</span>';
						}
						$i++;
					}
				?>
				</a></h1>
				
			<nav id="menu" class="menu js-menu" role="navigation">
		        	<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'false', 'menu_class' => '' ) ); ?>
			</nav>
			
		</header>