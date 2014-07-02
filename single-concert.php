<?php

get_header();

		if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
			<article id="posts" <?php post_class('p-section'); ?>>
				<h2 class="post-title"><?php the_title(); ?></h2>
				<?php $dtstart = DateTime::createFromFormat('d/m/Y', get_field('dtstart')); ?>
				<p><time class="value" datetime="<?php echo $dtstart->format('Y-m-d'); ?>">
					<?php echo $dtstart->format('j F Y, ga'); ?>
				</time><br />
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
										<strong class="composer"><a href="<?php echo esc_url( get_permalink($composerid->ID) ); ?>"><?php echo get_the_title($composerid->ID); ?></a><br /></strong>
										<em class="work_title"><?php the_sub_field('work_title'); ?></em>
									</li>
								<?php endif; ?>
							<?php endwhile; ?>
							<?php while( have_rows('programme_plus') ): the_row(); ?>
								<?php if (get_sub_field('composer') && get_sub_field('work_title')) : ?>
									<li>
										<strong class="composer"><?php the_sub_field('composer'); ?><br /></strong>
										<em class="work_title"><?php the_sub_field('work_title'); ?></em>
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