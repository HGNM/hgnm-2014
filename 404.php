<?php

get_header();

		if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('p-section primary entry'); ?>>
					<h2 class="post-title fname"><?php the_title(); ?></h2>
					<?php if (current_user_can('edit_post')) : ?>
						<a href="<?php echo get_edit_post_link(); ?>" class="edit-button">Edit</a>
					<?php endif; ?>
						<?php the_content(); ?>
				</article>
			<?php endwhile; ?>
		<?php else: ?>
		<?php endif;

get_footer();

?>
