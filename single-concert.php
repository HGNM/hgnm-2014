<?php

get_header();

		if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
			<article id="posts" <?php body_class(); ?>>
				<h2 class="post-title"><?php the_title(); ?></h2>
				<div class="entry"><?php if( get_field('summary') ): ?>
					<?php the_field('summary'); ?>
				<?php endif; ?></div>
			</article><!-- #posts -->
			<?php endwhile; ?>
		<?php else: ?>
		<?php endif;

get_footer();

?>