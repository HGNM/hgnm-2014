<?php

get_header();

		if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class('p-section'); ?>>
				<h2 class="post-title"><?php the_title(); ?></h2>
				<?php
				date_default_timezone_set('America/New_York');
				$dtstart = DateTime::createFromFormat('d/m/Y G:i', (get_field('dtstart') . ' 20:00')); ?>
				<p><time class="value" datetime="<?php echo $dtstart->format('Y-m-d\TH:i:sO'); ?>">
					<?php echo $dtstart->format('l jS F Y, ga'); ?>
				</time><br />
				<?php the_field('location') ?></p>
				<section class="entry">
					<?php if( get_field('summary') ): ?>
					<?php the_field('summary'); ?>
					<?php endif; ?>
				</section>

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
									echo '</strong><br /><em class="work_title">' . $item['work_title'] . '</em>';
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
				
				
			</article><!-- #posts -->
			<?php endwhile; ?>
		<?php else: ?>
		<?php endif;

get_footer();

?>