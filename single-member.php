<?php

get_header();

		if ( have_posts() ) : echo '<div id="posts">'; while ( have_posts() ) : the_post(); ?>

				<h2 class="post-title"><?php the_title(); ?></h2>
				<div class="entry"><?php the_content(); ?></div>

		<?php endwhile; echo '</div>'; else: ?>
		<?php endif;

get_footer();

?>