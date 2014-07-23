<?php

get_header();

		if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('p-section primary entry'); ?>>
					<h2 class="post-title fname"><?php the_title(); ?></h2>
					<?php if (current_user_can('edit_post')) : ?>
						<a href="<?php echo get_edit_post_link(); ?>" class="edit-button">Edit</a>
					<?php endif; ?>
						<?php
						// SET TIMEZONE
						date_default_timezone_set('America/New_York');
						$dtstart = DateTime::createFromFormat('d/m/Y G:i', (get_field('dtstart') . ' 12:00'));
						
						// EVENT META — date, time & location
						?>
						<section class="event-meta">
							<p class="dtstart"><time class="value" datetime="<?php echo $dtstart->format('Y-m-d\TH:i:sO'); ?>">
								<?php echo $dtstart->format('l, j F Y, ga'); ?>
							</time></p>
							
							<p class="location">Davison Room, <a href="http://www.map.harvard.edu/?ctrx=759617&ctry=2962591&level=10&layers=Campus%20Base%20and%20Buildings,Bike%20Facilities,Map%20Text" target="_blank" class="icon-link-ext">Harvard University Music Building</a></p>

						</section>
						<?php the_content(); ?>
				</article>
			<?php endwhile; ?>
		<?php else: ?>
		<?php endif;

get_footer();

?>