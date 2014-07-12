<?php

get_header();

		if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post" <?php post_class('p-section'); ?>>
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
						<?php endif;
						
						// Get archived colloquia
						$colloquia = get_posts(
							array(
								'numberposts' => -1,
								'post_type' => 'colloquium',
								'meta_key' => 'dtstart',
								'orderby' => 'dtstart',
								'order' => 'ASC',
								'meta_query' => array(
									array(
										'key' => 'fname',
				                        'value'  => get_the_ID(),
									)
								)
							)
						);
						
						// Get archived concerts
						$concerts = get_posts(
							array(
								'numberposts' => -1,
								'post_type' => 'concert',
								'meta_key' => 'dtstart',
								'orderby' => 'dtstart',
								'order' => 'ASC',
								'meta_query' => array(
									array(
										'key' => 'fname',
				                        'value'  => get_the_ID(),
									)
								)
							)
						);
						
						$upcomingcolloquia = $colloquia;
						$pastcolloquia = $colloquia;
						$upcomingconcerts = $concerts;
						$pastconcerts = $concerts;
						date_default_timezone_set('America/New_York');
						
						// Unset array items in the past — COLLOQUIA
						foreach ($upcomingcolloquia as $key => $row) {
							$dtstart = get_field('dtstart', $row->ID) . ' 12:00';
							$dtstart = DateTime::createFromFormat('d/m/Y G:i', $dtstart);
							if (($dtstart->format('Ymd')) < date('Ymd')) {
								unset($upcomingcolloquia[$key]);
							}
						}
						
						// Unset array items in the future (or today) — COLLOQUIA
						foreach ($pastcolloquia as $key => $row) {
							$dtstart = get_field('dtstart', $row->ID) . ' 12:00';
							$dtstart = DateTime::createFromFormat('d/m/Y G:i', $dtstart);
							if (($dtstart->format('Ymd')) >= date('Ymd')) {
								unset($pastcolloquia[$key]);
							}
						}
						
						// Unset array items in the past — CONCERTS
						foreach ($upcomingconcerts as $key => $row) {
							$dtstart = get_field('dtstart', $row->ID) . ' 12:00';
							$dtstart = DateTime::createFromFormat('d/m/Y G:i', $dtstart);
							if (($dtstart->format('Ymd')) < date('Ymd')) {
								unset($upcomingconcerts[$key]);
							}
						}
						
						// Unset array items in the future (or today) — CONCERTS
						foreach ($pastconcerts as $key => $row) {
							$dtstart = get_field('dtstart', $row->ID) . ' 12:00';
							$dtstart = DateTime::createFromFormat('d/m/Y G:i', $dtstart);
							if (($dtstart->format('Ymd')) >= date('Ymd')) {
								unset($pastconcerts[$key]);
							}
						}
						
						// Display Upcoming Colloquia
						if ($upcomingcolloquia) {
							echo '<h3>Upcoming Colloquium</h3><ul>';
							foreach ($upcomingcolloquia as $item) {
								$dtstart = DateTime::createFromFormat('d/m/Y G:i', (get_field('dtstart', $item->ID) . ' 12:00'));
								echo '<li>' . $dtstart->format('l, j F') . '</li>';
							}
							echo '</ul>';
						}
						
						?>
						
					</section>
				</article><!-- #post -->
			<?php endwhile; ?>
		<?php else: ?>
		<?php endif;

get_footer();

?>