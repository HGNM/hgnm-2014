<?php

get_header();

		if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post();
			
				// Get composer ID to look for
				$testID = get_the_ID();
				
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
				                      'value'  => $testID,
							)
						)
					)
				);
				
				// custom filter to replace '=' with 'LIKE'
				function my_posts_where( $where ) {
					$where = str_replace("meta_key = 'programme_%_composer'", "meta_key LIKE 'programme_%_composer'", $where);
					return $where;
				}
				 
				add_filter('posts_where', 'my_posts_where');
				
				// Get archived concerts
				$concerts = get_posts(
					array(
						'suppress_filters' => FALSE,
						'numberposts' => -1,
						'post_type' => 'concert',
						'meta_key' => 'dtstart',
						'orderby' => 'dtstart',
						'order' => 'ASC',
						'meta_query' => array(
							array(
								'key' => 'programme_%_composer',
				                      'value'  => $testID,
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
				
				// Create post-class string. Sets class of 'no-secondary' if no sidebar content exists
				$postclass = 'p-section';
				if ( !( has_post_thumbnail() || get_field('url') || $upcomingcolloquia || $upcomingconcerts ) ){ $postclass = $postclass . ' no-secondary'; }
				
				?>
			
				<article id="post-<?php the_ID(); ?>" <?php post_class($postclass); ?>>
					<h2 class="post-title fname"><?php the_title(); ?></h2>
					<section class="primary entry">
						<?php the_content(); ?>
					</section>
					<?php if ( has_post_thumbnail() || get_field('url') || $upcomingcolloquia || $upcomingconcerts ) : ?>
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
							
							// Display Next Colloquium
							if ($upcomingcolloquia) {
								echo '<div class="colloquia"><h3>Next Colloquium</h3>';
								foreach ($upcomingcolloquia as $item) {
									$dtstart = DateTime::createFromFormat('d/m/Y G:i', (get_field('dtstart', $item->ID) . ' 12:00'));
									echo '<h4>' . $dtstart->format('l, j F') . '</h4>';
									echo '<p>Talk at 12pm in the Davison Room, Harvard University Music Building.</p>';
									break;
								}
								echo '</div>';
							}
							
							// Display Next Concerts
							if ($upcomingconcerts) {
								echo '<div class="concerts"><h3>Upcoming Concerts</h3><ul>';
								foreach ($upcomingconcerts as $item) : ?>
									<li class="vevent clearfix">
										<a href="<?php echo get_permalink($item->ID) ?>" class="url">
											<?php $dtstart = DateTime::createFromFormat('d/m/Y G:i', (get_field('dtstart', $item->ID) . ' 20:00')); ?>
											<h4 class="dtstart"><time class="value-title" datetime="<?php echo $dtstart->format('Y-m-d\TH:i:sO'); ?>" title="<?php echo $dtstart->format('Y-m-d\TH:i:sO'); ?>">
												<?php echo '<span class="month">' . $dtstart->format('M') . '</span> <span class="day">' . $dtstart->format('j'); ?>
											</time></h4>
											<div class="details">
												<?php echo '<p class="summary">' . get_the_title($item->ID) . '</p>'; ?>
												<p class="location vcard"><?php the_field('location', $item->ID); ?></p>
											</div>
										</a>
									</li>
								<?php endforeach;
								echo '</div>';
							}
							
							?>
							
						</section> <!-- .secondary -->
					<?php endif; ?>
				</article><!-- #post -->
			<?php endwhile; ?>
		<?php else: ?>
		<?php endif;

get_footer();

?>