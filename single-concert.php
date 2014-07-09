<?php

get_header();

		if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class('p-section vevent'); ?>>
				<h2 class="post-title summary"><?php the_title(); ?></h2>

				<?php
				// SET TIMEZONE
				date_default_timezone_set('America/New_York');
				$dtstart = DateTime::createFromFormat('d/m/Y G:i', (get_field('dtstart') . ' 20:00'));
				
				// EVENT META — date, time & location
				?>
				<section class="event-meta">
					<p class="dtstart"><time class="value" datetime="<?php echo $dtstart->format('Y-m-d\TH:i:sO'); ?>">
						<?php echo $dtstart->format('l j') . '<sup>' . $dtstart->format('S') . '</sup> ' . $dtstart->format('F Y, ga'); ?>
					</time></p>
					
					<p class="location"><?php the_field('location') ?></p>
				</section>

				<?php
				// SUMMARY FIELD
				if( get_field('summary') ): ?>
				<section class="summary">
					<?php the_field('summary'); ?>
				</section>
				<?php endif; ?>
				
				<?php if(get_field('performer_url') || get_field('facebook_url')) : ?>
					<section class="external-links">
						<ul>
							<?php
							// PERFORMER LINK
							if( get_field('performer_url') ): ?>
								<li><a href="<?php esc_url( the_field('performer_url') ); ?>">Find out more about <?php the_title(); ?></a></li>
							<?php endif; ?>
							<?php
							// FACEBOOK LINK
							if( get_field('facebook_url') ): ?>
								<li><a href="<?php esc_url( the_field('facebook_url') ); ?>">See this event on Facebook</a></li>
							<?php endif; ?>
						</ul>
					</section>
				<?php endif; ?>

				<?php
				// PROGRAMME CONTENT
				if(have_rows('programme') || have_rows('programme_plus')): ?>
					<section class="programme">
						<h3>Programme</h3>
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
								echo '<p>Works by ';
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
						if ($posterpdf['mime_type'] == 'application/pdf') {
							echo '<li><a href="' . esc_url($posterpdf['url']) . '">Download PDF of concert poster</a></li>';
						}
						else {
							echo '<li><a href="' . esc_url($posterpdf['url']) . '">Download concert poster</a></li>';
						}
					}
					if( get_field('programme_pdf') ) {
						$programme = get_field('programme_pdf');
						if ($programmepdf['mime_type'] == 'application/pdf') {
							echo '<li><a href="' . esc_url($programmepdf['url']) . '">Download PDF of concert programme</a></li>';
						}
						else {
							echo '<li><a href="' . esc_url($programmepdf['url']) . '">Download concert programme</a></li>';
						}
					}
					echo '</ul></section>';
				}
				?>
				
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
						echo '<section class="multimedia">';
						if ($audiolist) {
							echo '<h3>Audio</h3><ul>';
							foreach($audiolist as $item) {
								echo '<li class="embed-container">' . $item['embed_link'] . '</li>';
							}
							echo '</ul>';
						}
						if ($videolist) {
							echo '<h3>Video</h3><ul>';
							foreach($videolist as $item) {
									echo '<li class="embed-container">' . $item['embed_link'] . '</li>';
							}
							echo '</ul>';
						}
						echo '</section>';
					}
				}
				?>
				
			</article><!-- #posts -->
			<?php endwhile; ?>
		<?php else: ?>
		<?php endif;

get_footer();

?>