<?php

get_header();

		if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post();
			$postclass = 'p-section vevent';
			if (get_field('summary')) { $postclass = $postclass . ' has-summary'; }
			if (get_field('programme')) { $postclass = $postclass . ' has-programme'; }
			if (get_field('poster_pdf') || get_field('programme_pdf')) { $postclass = $postclass . ' has-docs'; }
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class($postclass); ?>>
				<h2 class="post-title summary"><?php the_title(); ?></h2>
				<?php if (get_field('support')) {
					if(get_field('support') == 'Fromm') {
						echo '<p class="support">Supported by the Fromm Music Foundation</p>';
					}
					if(get_field('support') == 'Goldberg') {
						echo '<p class="support">The Thelma E. Goldberg Concert</p>';
					}
				} ?>
				<?php if (current_user_can('edit_post')) : ?>
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
				if ($start_time) {
					$dtstart = DateTime::createFromFormat('d/m/Y G:i', (get_field('dtstart') . ' ' . $start_time));
				}
				else {
					$dtstart = DateTime::createFromFormat('d/m/Y G:i', (get_field('dtstart') . ' 20:00'));
				}

				// EVENT META — date, time & location
				?>
				<section class="event-meta">
					<p class="dtstart"><time class="value" datetime="<?php echo $dtstart->format('Y-m-d\TH:i:sO'); ?>">
						<?php echo $dtstart->format('l, j F Y, g:ia'); ?>
					</time></p>

					<p class="location"><?php the_field('location') ?></p>

					<?php if ($dtstart->format('Ymd') > date('Ymd')) : ?>
						<p class="tickets"><span class="price">free</span> & open to the public</p>
					<?php endif; ?>
				</section>

				<?php
				// SUMMARY FIELD
				if( get_field('summary') ): ?>
				<section class="description">
					<?php the_field('summary'); ?>
				</section>
				<?php endif; ?>

				<?php
				// PROGRAMME CONTENT
				if(have_rows('programme') || have_rows('programme_plus')): ?>
					<section class="programme">
						<h3>Program</h3>
							<?php
							// Get programme data from custom fields
							$programme = get_field('programme');
							$programmeplus = get_field('programme_plus');

							// Create empty array to populate with programme data
							$fullprogramme = array();

							// For each programme item create an array and append it to the $fullprogramme array
							foreach ($programme as $item) {
								$id = $item['composer'];
								$composer = get_the_title($id->ID);
								$url = get_permalink($id->ID);
								$work_title = $item['work_title'];
								$embed_link = $item['embed_link'];
								$a_or_v = $item['a_or_v'];
								$row = array(array('composer' => $composer, 'url' => $url, 'work_title' => $work_title, 'embed_link' => $embed_link, 'a_or_v' => $a_or_v));
								$fullprogramme = array_merge($fullprogramme, $row);
							}

							// For each programme plus item create an array and append it to the $fullprogramme array
							foreach ($programmeplus as $item) {
								$composer = $item['composer'];
								$url = '';
								$work_title = $item['work_title'];
								$embed_link = $item['embed_link'];
								$a_or_v = $item['a_or_v'];
								$row = array(array('composer' => $composer, 'url' => $url, 'work_title' => $work_title, 'embed_link' => $embed_link, 'a_or_v' => $a_or_v));
								$fullprogramme = array_merge($fullprogramme, $row);
							}

							// Set up list of names to sort by
							foreach ( $fullprogramme as $key => $row ) {
								$column_id[$key]=$row['composer'];
							}

							// Sort programme by composer name
							array_multisort($column_id, SORT_STRING, $fullprogramme);


							// Count programme items
							$count =  count($fullprogramme);

							// Test to see if there’s a complete list of work titles
							$i = 0;
							$hasworks = 1;
							while ($i < $count) {
								if (strlen($fullprogramme[$i]['work_title']) != 0) {
								}
								else {
									$hasworks = 0;
									break;
								}
								$i++;
							}

							// Output if there is a complete list of work titles
							// Format: 	<li>
							//				<strong class="composer">COMPOSER-NAME</strong><br />
							// 				<em class="work_title">WORK-TITLE</em>
							//			</li>
							// With a link wrapped around COMPOSER-NAME where present
							if ($hasworks) {
								echo '<ul>';
								foreach ($fullprogramme as $item) {
									echo '<li><strong class="composer">';
									if ($item['url']) {
										echo '<a href="' . esc_url( $item['url'] ) . '">';
										echo $item['composer'] . '</a>';
									}
									else {
										echo $item['composer'];
									}
									echo '</strong> <em class="work_title">' . $item['work_title'] . '</em>';
									echo '</li>';
								}
								echo '</ul>';
							}

							else {
								// Output if incomplete list of work titles
								// Format: a list of composer names seperated by commas, final pair joined by ' and '
								$n = 0;
								echo '<p class="no-works">Works by ';
								foreach ($fullprogramme as $item) {
									if ($n == ($count - 1)) {
										// last item
										if ($item['url']) {
											echo '<a href="' . esc_url( $item['url'] ) . '">';
											echo $item['composer'] . '</a>.';
										}
										else {
											echo $item['composer'] . '.';
										}
									}
									elseif ($n == ($count - 2)) {
										// penultimate item
										if ($item['url']) {
											echo '<a href="' . esc_url( $item['url'] ) . '">';
											echo $item['composer'] . '</a> and ';
										}
										else {
											echo $item['composer'] . ' and ';
										}
									}
									else {
										// other items
										if ($item['url']) {
											echo '<a href="' . esc_url( $item['url'] ) . '">';
											echo $item['composer'] . '</a>, ';
										}
										else {
											echo $item['composer'] . ', ';
										}
									}
									$n++;
								}
								echo '</p>';

							} ?>

					</section><!-- .programme -->
				<?php endif; ?>

				<?php
				// ARCHIVE CONTENT
				if( get_field('poster_pdf') || get_field('programme_pdf') ) {
					echo '<section class="archive-docs"><h3>Related Files</h3><ul>';
					if( get_field('poster_pdf') ) {
						$posterpdf = get_field('poster_pdf');
						$filesize = size_format(filesize(get_attached_file($posterpdf['ID'])));
						if ($posterpdf['mime_type'] == 'application/pdf') {
							echo '<li><span class="icon icon-download" aria-hidden="true"></span><a href="' . esc_url($posterpdf['url']) . '">Download PDF of concert poster</a> <span class="docs-meta">' . $filesize . '</span></li>';
						}
						else {
							$filetype = wp_check_filetype($posterpdf['url']);
							echo '<li><span class="icon icon-download" aria-hidden="true"></span><a href="' . esc_url($posterpdf['url']) . '">Download concert poster</a> <span class="docs-meta">' . strtoupper($filetype['ext']) . ', ' . $filesize . '</span></li>';
						}
					}
					if( get_field('programme_pdf') ) {
						$programmepdf = get_field('programme_pdf');
						$progfilesize = size_format(filesize(get_attached_file($programmepdf['ID'])));
						if ($programmepdf['mime_type'] == 'application/pdf') {
							echo '<li><span class="icon icon-download" aria-hidden="true"></span><a href="' . esc_url($programmepdf['url']) . '">Download PDF of program booklet</a> <span class="docs-meta">' . $progfilesize . '</span></li>';
						}
						else {
							echo '<li><span class="icon icon-download" aria-hidden="true"></span><a href="' . esc_url($programmepdf['url']) . '">Download program booklet</a> <span class="docs-meta">' . $progfilesize . '</span></li>';
						}
					}
					echo '</ul></section>';
				}
				?>

				<?php if(get_field('performer_url') || get_field('facebook_url')) : ?>
					<section class="external-links clearfix <?php if(get_field('performer_url') & get_field('facebook_url')) { echo 'both'; } ?>">
						<ul>
							<?php
							// PERFORMER LINK
							if( get_field('performer_url') ): ?>
								<li><a href="<?php esc_url( the_field('performer_url') ); ?>">Find out more about <span class="perfname"><?php the_title(); ?><span class="icon icon-link-ext" aria-hidden="true"></span></span></a></li>
							<?php endif; ?>
							<?php
							// FACEBOOK LINK
							if( get_field('facebook_url') ): ?>
								<li><a href="<?php esc_url( the_field('facebook_url') ); ?>">See this event on Facebook <span class="icon icon-facebook" aria-hidden="true"></span></a></li>
							<?php endif; ?>
						</ul>
					</section>
				<?php endif; ?>

				<?php
				// A/V CONTENT
				if( get_field('a_v') ) {
					$audiolist = $fullprogramme;
					$videolist = $fullprogramme;
					foreach($audiolist as $key => $row) {
						if($row['a_or_v'] !== 'Audio') unset($audiolist[$key]);
					}
					foreach($videolist as $key => $row) {
						if($row['a_or_v'] !== 'Video') unset($videolist[$key]);
					}
					if($audiolist || $videolist) {
						echo '<section class="multimedia"><ul>';
						if ($audiolist) {
							echo '<li class="audio clearfix"><h3>Audio</h3><ul>';
							foreach($audiolist as $item) {
								echo '<li><span class="embed-container">' . $item['embed_link'] . '</span></li>';
							}
							echo '</ul></li>';
						}
						if ($videolist) {
							echo '<li class="video clearfix"><h3>Video</h3><ul>';
							foreach($videolist as $item) {
									echo '<li><span class="embed-container">' . $item['embed_link'] . '</span></li>';
							}
							echo '</ul></li>';
						}
						echo '</ul></section>';
					}
				}
				?>

				<?php
				// GALLERY
				$images = get_field('gallery');

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
				<?php endif; ?>

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
