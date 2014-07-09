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
							<?php
							$programme = get_field('programme');
							$programmeplus = get_field('programme_plus');
							$count =  count($programme);
							$i = 0;
							$hasworks = 1; 
							while ($i < $count) {
								if (strlen($programme[$i]['work_title']) != 0) {
								}
								else {
									$hasworks = 0;
									break;
								}
								$i++;
							}
							if ($hasworks) {
								// Output if there is a complete list of work titles
								while (have_rows('programme')) {
									the_row();
									if (get_sub_field('composer')) {
										$composerid = get_sub_field('composer'); ?>
											<li>
												<strong class="composer"><a href="<?php echo esc_url( get_permalink($composerid->ID) ); ?>"><?php echo get_the_title($composerid->ID); ?></a><br /></strong>
												<em class="work_title"><?php the_sub_field('work_title'); ?></em>
											</li>
										<?php }
									}
								}
							else {
								// Output if incomplete list of work titles
								$n = 0;
								echo 'Works by ';
								while ($n < $count) {
									if ($n < ($count - 2)) {
										$composerid = $programme[$n]['composer'];
										echo '<a href="' . esc_url( get_permalink($composerid->ID) ) . '">' . get_the_title($composerid->ID) . '</a>, ';
										$n++;
									}
									elseif ($n < ($count - 1)) {
										$composerid = $programme[$n]['composer'];
										echo '<a href="' . esc_url( get_permalink($composerid->ID) ) . '">' . get_the_title($composerid->ID) . '</a> and ';
										$n++;
									}
									else {
										$composerid = $programme[$n]['composer'];
										echo '<a href="' . esc_url( get_permalink($composerid->ID) ) . '">' . get_the_title($composerid->ID) . '.';
										$n++;
									}
								}
							}


							// OLD OUTPUT FOR REFERENCE WHILE BUILDING NEW ?><!-- <?php
							
							while( have_rows('programme') ): the_row(); ?>
								<?php if (get_sub_field('composer')) : ?>
									<?php $composerid = get_sub_field('composer'); ?>
									<?php if (get_sub_field('work_title')) : ?>
										<li>
											<strong class="composer"><a href="<?php echo esc_url( get_permalink($composerid->ID) ); ?>"><?php echo get_the_title($composerid->ID); ?></a><br /></strong>
											<em class="work_title"><?php the_sub_field('work_title'); ?></em>
										</li>
									<?php endif; ?>
									<?php if (!get_sub_field('work_title')) : ?>
										<a href="<?php echo esc_url( get_permalink($composerid->ID) ); ?>"><?php echo get_the_title($composerid->ID); ?></a>, 
									<?php endif; ?>
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
							
							-->
							
							
						</ul>
					</div><!-- .programme -->
				<?php endif; ?>
			</article><!-- #posts -->
			<?php endwhile; ?>
		<?php else: ?>
		<?php endif;

get_footer();

?>