<?php

get_header();

		if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post" <?php post_class(); ?>>
					<h2 class="post-title"><?php the_title(); ?></h2>
					<div class="entry"><?php the_content(); ?></div>
				</article><!-- #post -->
			<?php endwhile; ?>
		<?php else: ?>
		<?php endif;

get_footer();

?>