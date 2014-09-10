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
							
							<p class="location map-popup">Davison Room, <a href="https://www.google.com/maps/place/Music+Bldg,+Harvard+University,+Cambridge,+MA+02138/@42.3769058,-71.1170215,15z/data=!4m2!3m1!1s0x89e3774164253f4d:0x4139366065ac28ee" class="icon-location">Harvard University Music Building</a></p>

						</section>
						<?php the_content(); ?>
				</article>
			<?php endwhile; ?>
		<?php else: ?>
		<?php endif;

get_footer();

?>