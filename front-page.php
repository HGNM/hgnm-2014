<?php

get_header();

		// Get home page blurb
		if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="fp-blurb" <?php post_class('fp-section'); ?>>
					<div class="entry"><?php the_content(); ?></div>
				</article><!-- #post -->
			<?php endwhile; ?>
		<?php else: ?>
		<?php endif;
		
		// Get upcoming concerts
		$today = date('Ymd', strtotime('-1 day'));
		$concerts = get_posts(
			array(
				'numberposts' => 1,
				'post_type' => 'concert',
				'meta_key' => 'dtstart',
				'order' => 'ASC',
				'meta_query' => array(
					array(
						'key' => 'dtstart',
                        'value'  => $today,
                        'compare'  => '>'
					)
				)
			)
		);
		// Get upcoming colloquia
		$colloquia = get_posts(
			array(
				'numberposts' => 3,
				'post_type' => 'colloquium',
				'meta_key' => 'dtstart',
				'order' => 'ASC',
				'meta_query' => array(
					array(
						'key' => 'dtstart',
                        'value'  => $today,
                        'compare'  => '>'
					)
				)
			)
		);
		
		// Display upcoming events
		if($concerts || $colloquia) : ?>
			<section id="fp-events" class="fp-section">
				<h2>Next Events</h2>
				<ul>
					<?php if($concerts) : ?>
						<li>
							<h3>Next Concert</h3>
							<?php foreach($concerts as $concert): ?>
								<div class="vevent">
									<?php $dtstart = DateTime::createFromFormat('d/m/Y', get_field('dtstart', $concert->ID)); ?>
									<h4 class="dtstart"><time class="value" datetime="<?php echo $dtstart->format('Y-m-d'); ?>">
										<?php echo '<span class="month">' . $dtstart->format('M') . '</span> <span class="day">' . $dtstart->format('j'); ?>
									</time></h4>
									<?php echo '<p>' . get_the_title($concert->ID) . '</p>'; ?>
									<p><?php the_field('location', $concert->ID); ?></p>
								</div>
							<?php endforeach; ?>
						</li>
					<?php endif; ?>
					<?php if($colloquia) : ?>
						<li>
						<h3>Upcoming Colloquia</h3>
						<ul>
						<?php foreach($colloquia as $colloquium): ?>
							<li>
							<?php $dtstart = DateTime::createFromFormat('d/m/Y', get_field('dtstart', $colloquium->ID)); ?>
							<h4><time class="value" datetime="<?php echo $dtstart->format('Y-m-d'); ?>">
								<?php echo $dtstart->format('m/j'); ?>
							</time></h4>
							<?php echo get_the_title($colloquium->ID); ?>
							</li>
						<?php endforeach; ?>
						</ul>
						<p>All colloquia are at 12pm in the Davison Room, <a href="http://www.map.harvard.edu/?ctrx=759617&ctry=2962591&level=10&layers=Campus%20Base%20and%20Buildings,Bike%20Facilities,Map%20Text" target="_blank">Harvard University Music Building</a></p>
						</li>
					<?php endif; ?>
				</ul>
			</section>
		<?php endif;
		
		// Get composers names, photos and permalinks
		$posts = get_posts(array(
			'numberposts' => -1,
			'post_type' => 'member',
			'meta_key' => 'dtend',
			'meta_value' => '',
			'orderby' => 'title',
			'order' => 'ASC'
		));
		if($posts)
		{
			echo '<section id="fp-composers" class="fp-section"><h2>Composers</h2><ul class="clearfix">';
			foreach($posts as $post)
			{
				$imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
				echo '<li><a href="' . get_permalink($post->ID) . '">';
				if(has_post_thumbnail()) {
					echo '<img src="' . $imgsrc[0] . '" alt="' . get_the_title($post->ID) . '">';
				}
				echo '<span>' . get_the_title($post->ID) . '</span>' . '</a></li>';
			}
			echo '</ul></section>';
		}

get_footer();

?>