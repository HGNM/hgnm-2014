<?php

get_header();

		if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
			<article id="posts" <?php post_class(); ?>>
				<h2 class="post-title"><?php the_title(); ?></h2>
				<?php $dtstart = DateTime::createFromFormat('d/m/Y', get_field('dtstart')); ?>
				<time class="value" datetime="<?php echo $dtstart->format('Y-m-d'); ?>">
					<?php echo $dtstart->format('j F Y, ga'); ?>
				</time>
				<?php the_field('location') ?></p>
				<div class="entry"><?php if( get_field('summary') ): ?>
					<?php the_field('summary'); ?>
				<?php endif; ?></div>
				<?php if(have_rows('programme') || have_rows('programme_plus')): ?>
					<div class="programme">
						<h3>Programme</h3>
						<ul>
							<?php while( have_rows('programme') ): the_row(); ?>
								<?php if (get_sub_field('composer') && get_sub_field('work_title')) : ?>
									<li>
										<?php $composerid = get_sub_field('composer'); ?>
										<span class="composer"><a href="<?php echo esc_url( home_url( '/' . $composerid->post_type . '/' . $composerid->post_name . '/' ) ); ?>"><?php echo $composerid->post_title; ?></a> — </span>
										<span class="work_title"><?php the_sub_field('work_title'); ?></span>
									</li>
								<?php endif; ?>
							<?php endwhile; ?>
							<?php while( have_rows('programme_plus') ): the_row(); ?>
								<?php if (get_sub_field('composer') && get_sub_field('work_title')) : ?>
									<li>
										<span class="composer"><?php the_sub_field('composer'); ?> — </span>
										<span class="work_title"><?php the_sub_field('work_title'); ?></span>
									</li>
								<?php endif; ?>
							<?php endwhile; ?>
						</ul>
					</div><!-- .programme -->
				<?php endif; ?>
			</article><!-- #posts -->
			<?php endwhile; ?>
		<?php else: ?>
		<?php endif;

get_footer();

?>