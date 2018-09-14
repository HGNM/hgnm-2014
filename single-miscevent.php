<?php

get_header();

		if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post();
			$postclass = 'p-section vevent';
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class($postclass); ?>>
				<h2 class="post-title summary"><?php the_title(); ?></h2>
				<?php if (current_user_can('edit_posts')) : ?>
					<a href="<?php echo get_edit_post_link(); ?>" class="edit-button">Edit</a>
				<?php endif; ?>

				<?php
				
				// SET START TIME VARIABLE
				if (get_field('start_time')) {
					$start_time = get_field('start_time');
				}
				// SET TIMEZONE
				date_default_timezone_set('America/New_York');
				
				// SET START DATE VARIABLE
				if ($start_time && ! get_field('dtend')) {
					$dtstart = DateTime::createFromFormat('d/m/Y G:i', (get_field('dtstart') . ' ' . $start_time));
				}
				else {
					$dtstart = DateTime::createFromFormat('d/m/Y G:i', (get_field('dtstart') . ' 20:00'));
				}
				
				// SET END DATE VARIABLE
				if (get_field('dtend')) {
					$dtend = DateTime::createFromFormat('d/m/Y G:i', (get_field('dtend') . ' 20:00'));
				}
				
				// EVENT META — date, time & location
				?>
				<section class="event-meta">
					<p class="dtstart"><time class="value" datetime="<?php echo $dtstart->format('Y-m-d\TH:i:sO'); ?>">
					<?php if (get_field('dtstart') && get_field('dtend')) {
						// if dtend is set
						if ($dtstart == $dtend) {
							// if dtstart and dtend are the same, just show dtstart
							echo $dtstart->format('l, j F Y');
						}
						elseif ($dtstart < $dtend) {
							if ($dtstart->format('mY') == $dtend->format('mY')) {
								// if same month and same year
								echo $dtstart->format('l, j') . ' – ' . $dtend->format('l, j F Y');
							}
							elseif ($dtstart->format('Y') == $dtend->format('Y')) {
								// if same year
								echo $dtstart->format('l, j F') . ' – ' . $dtend->format('l, j F Y');
							}
							else {
								// if different years
								echo $dtstart->format('l, j F Y') . ' – ' . $dtend->format('l, j F Y');
							}
						}
					}
					elseif (get_field('dtstart') && $start_time) {
						// if start_time is set but not dtend
						echo $dtstart->format('l, j F Y, g:ia');
					}
					elseif (get_field('dtstart')) {
						// if only dtstart is set
						echo $dtstart->format('l, j F Y');
					} ?>
					</time></p>
					
					
					<?php
					// Display event location using microformat hCard
					if( have_rows('details') ) {
						while ( have_rows('details') ) {
							the_row();
							if( get_row_layout() == 'location' ) {
								echo '<p class="location">';
								if (get_sub_field('fn')) { echo '<span class="fn org">' . get_sub_field('fn') . '</span>'; }
								if ( get_sub_field('street-address') || get_sub_field('locality') || get_sub_field('region') || get_sub_field('postal-code') || get_sub_field('country-name') ) {
									echo '<span class="adr">';
									if (get_sub_field('street-address')) { echo '<br /><span class="street-address">' . get_sub_field('street-address') . '</span>'; }
									if (get_sub_field('locality')) {
										echo '<br /><span class="locality">' . get_sub_field('locality') . '</span>';
										if (get_sub_field('region')) {
											echo ', ';
										}
									}
									if (get_sub_field('region')) { echo '<span class="region">' . get_sub_field('region') . '</span>'; }
									if (get_sub_field('postal-code')) { echo ' <span class="postal-code">' . get_sub_field('postal-code') . '</span>'; }
									if (get_sub_field('country-name')) { echo '<br /><span class="country-name">' . get_sub_field('country-name') . '</span>'; }
									echo '</span>';
								}
								echo '</p>';
							}
						}
					}
					?>

				</section> <!-- event meta -->

				<?php
				if( have_rows('details') ) {
					while ( have_rows('details') ) {
						the_row();
						// SUMMARY FIELD
						if( get_row_layout() == 'description' ) : ?>
							<section class="description">
								<h3>About this event</h3>
								<?php the_sub_field('summary'); ?>
							</section>
						<?php endif;
						
						// EXTERNAL LINK
						if ( get_row_layout() == 'link' ) {
							echo '<section class="external-links"><ul><li><a href="' . get_sub_field('url') . '" class="url">' . get_sub_field('title') . ' »</a></li></ul></section>';
						}
						
						// ARCHIVE CONTENT
						if ( get_row_layout() == 'documents' ) {
							if( have_rows('document') ) {
								echo '<section class="archive-docs"><h3>Related Files</h3><ul>';
								while ( have_rows('document') ) {
									the_row();
									if ( get_sub_field('file') && get_sub_field('file_name') ) {
										$document = get_sub_field('file');
										echo '<li><span class="icon icon-download" aria-hidden="true"></span><a href="' . esc_url($document['url']) . '">' . get_sub_field('file_name') . '</a></li>';
									}
								}
								echo '</ul></section>';
							}
						}
						
						// VIDEOS
						if ( get_row_layout() == 'videos' ) {
							if( have_rows('videos') ) {
								echo '<section class="multimedia"><h3>Media</h3><ul class="video clearfix">';
								while ( have_rows('videos') ) {
									the_row();
									if ( get_sub_field('embed_link') ) {
										$embed = get_sub_field('embed_link');
										echo '<li><span class="embed-container">' . $embed . '</span></li>';
									}
								}
								echo '</ul></section>';
							}
						}
						
						// PHOTOS
						if ( get_row_layout() == 'photos' ) {
							$images = get_sub_field('gallery');
							if( $images ): ?>
							<section class="gallery">
								<h3>Photos</h3>
							    <ul class="popup-gallery clearfix">
							        <?php foreach( $images as $image ): ?>
							            <li>
							            	<a href="<?php echo $image['sizes']['large']; ?>" title="<?php echo $image['title']; ?>">
							            		 <img src="<?php echo $image['sizes']['hgnm-thumb']; ?>" alt="<?php echo $image['alt']; ?>" />
							            	</a>
							            </li>
							        <?php endforeach; ?>
							    </ul>
						    </section>
							<?php endif;
						}
					}
				}
				?>
								
				<section class="archive-link">
				<?php
				//ARCHIVE LINK - shows link to archive for season that includes this concert
					if ( $dtstart->format('m') > 8 ) {
						$yearquery = $dtstart->format('Y');
					}
					else {
						$yearquery = ( $dtstart->format('Y') - 1 );
					}
					if (($yearquery % 100) == 99) {
						$seasontitle = $yearquery . '–' . ($yearquery + 1);
					}
					else {
						$seasontitle = $yearquery . '–' . str_pad((($yearquery + 1) % 100), 2, '0', STR_PAD_LEFT);
					}
					echo '<a href="' . get_post_type_archive_link('concert') . $yearquery . '/">See all events in the ' . $seasontitle . ' season »</a>';
				?>
				</section>
				
			</article><!-- #post-ID .vevent -->
			<?php endwhile; ?>
		<?php else: ?>
		<?php endif;

get_footer();

?>