<?php

get_header();

		if ( have_posts() ) : echo '<div id="posts">'; while ( have_posts() ) : the_post(); ?>

				<h2 class="post-title"><?php the_title(); ?></h2>
				<div class="entry"><?php the_content(); ?></div>
				
				<?php if( get_field('url') ): ?>
					<a href="<?php the_field('url'); ?>">Personal Website</a>
				<?php endif; ?>

		<?php endwhile; echo '</div>'; else: ?>
		<?php endif;

get_footer();

?>