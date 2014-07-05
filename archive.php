<?php

get_header();

		// If there is a year query, e.g. '?y=2012', get it and use it as a variable, else set it to the current year
		if(get_query_var('y')) {
			if (filter_var(get_query_var('y'), FILTER_VALIDATE_INT, array('options' => array ('min_range' => 0, 'max_range' => 9999,))) !== FALSE) {
				$yearquery = get_query_var('y');
			}
		}
		else {
			$yearquery = date('Y');
		}
		
		// Set season date variables
		$seasonstart = $yearquery . '0901';
		$seasonend = ($yearquery + 1) . '0831';
		$season = array($seasonstart,$seasonend);
		
		// Check queries to see if it is for a season starting more than a year in the future. N.B. The *next* season will return as false.
		if ($seasonstart > date('Ymd', strtotime(date('Ymd', mktime()) . ' + 365 day')) ) {
			// What should happen if someone wants to see into the future?
			echo 'Welcome to the future!';
		}
		elseif ($seasonstart > date('Ymd')) {
			// What should happen if it is the *next* season
			echo 'Coming up next year!';
		}
		elseif ($seasonstart < 19840900) {
			// What should happen if it is before HGNM was founded?
			echo 'Hold your horses, HGNM didn’t even exist then!';
		}
		else {
			// OK, now we’re talking. Check if posts exist?
		}
		
		// Display archive title in format 'Archives YYYY–YY' unless turn of century, in which case 'Archives YYYY–YYYY'
		if (($yearquery % 100) == 99) {
			echo '<h2>Archives: ' . $yearquery . '–' . ($yearquery + 1) . '</h2>';
		}
		else {
			echo '<h2>Archives: ' . $yearquery . '–' . (($yearquery + 1) % 100) . '</h2>';
		}
		
		if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('p-section primary entry'); ?>>
					<h2 class="post-title fname"><?php the_title(); ?></h2>
						<?php the_content(); ?>
				</article>
			<?php endwhile; ?>
		<?php else: ?>
		<?php endif;

get_footer();

?>