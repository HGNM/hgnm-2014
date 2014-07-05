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
		echo $yearquery;
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