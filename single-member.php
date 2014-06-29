<?php

get_header();

		if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post" <?php post_class(); ?>>
					<h2 class="post-title fname"><?php the_title(); ?></h2>
					<section class="primary entry">
						<?php the_content(); ?>
					</section>
					<section class="secondary">
						<?php if( has_post_thumbnail() ): ?>
							<div class="featured-img">
								<?php echo get_the_post_thumbnail($post->ID, 'medium'); ?>
							</div>
						<?php endif; ?>
						<?php if( get_field('url') ): ?>
							<div class="url">
								<a href="<?php the_field('url'); ?>">Personal Website</a>
							</div>
						<?php endif; ?>
					</section>
				</article><!-- #post -->
			<?php endwhile; ?>
		<?php else: ?>
		<?php endif;

get_footer();

?>