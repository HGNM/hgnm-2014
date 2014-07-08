<?php

get_header();

		// If there is a year query, e.g. '?y=2012', get it and use it as a variable, else set it to the current year
		if(get_query_var('y')) {
			if (filter_var(get_query_var('y'), FILTER_VALIDATE_INT, array('options' => array ('min_range' => 0, 'max_range' => 9999,))) !== FALSE) {
				$yearquery = get_query_var('y');
			}
		}
		else {
			// Set correct year query from current date when no query_var present
			if (date('m') > 8) {
				$yearquery = date('Y');
			}
			else {
				$yearquery = date('Y') - 1;
			}
		}
		
		// Set season date variables
		$seasonstart = $yearquery . '0901';
		$seasonend = ($yearquery + 1) . '0831';
		$season = array($seasonstart,$seasonend);
		
		// Set pretty season range
		// Format 'YYYY–YY' unless turn of century, in which case 'YYYY–YYYY'
		if (($yearquery % 100) == 99) {
			$seasontitle = $yearquery . '–' . ($yearquery + 1);
		}
		else {
			$seasontitle = $yearquery . '–' . str_pad((($yearquery + 1) % 100), 2, '0', STR_PAD_LEFT);
		}
		
		// Alter main query for displaying concerts in the loop
		query_posts(
			array(
				'numberposts' => -1,
				'post_type' => 'concert',
				'meta_key' => 'dtstart',
				'order' => 'DESC',
				'meta_query' => array(
					array(
						'key' => 'dtstart',
                        'value'  => $season,
                        'compare'  => 'BETWEEN'
					)
				)
			)
		);
		
		// Get archived colloquia
		$colloquia = get_posts(
			array(
				'numberposts' => -1,
				'post_type' => 'colloquium',
				'meta_key' => 'dtstart',
				'order' => 'DESC',
				'meta_query' => array(
					array(
						'key' => 'dtstart',
                        'value'  => $season,
                        'compare'  => 'BETWEEN'
					)
				)
			)
		);
		
		// Check queries to see if it is for a season starting more than a year in the future. N.B. The *next* season will return as false.
		if ($seasonstart > date('Ymd', strtotime(date('Ymd', mktime()) . ' + 365 day')) ) {
			// What should happen if someone wants to see into the future?
			echo '<article class="p-section"><h2>Archives</h2><p>Welcome to the future! It looks like you’re looking for events in the ' . $seasontitle . ' season, but unfortunately this is neither a time machine nor a crystal ball. Why not <a href="' . get_post_type_archive_link('concert') . '">check out what’s happening right now</a>?</p></article>';
		}
		elseif ($seasonstart < 19840900) {
			// What should happen if it is before HGNM was founded?
			echo '<article class="p-section"><h2>Archives</h2><p>' . $yearquery . '? Harvard Group for New Music wasn’t founded until 1984, so there’s nothing to see for this date. Why not <a href="' . get_post_type_archive_link('concert') . '">check out what’s happening right now</a>?</p></article>';
		}
		elseif ($seasonstart > date('Ymd') && !have_posts()) {
			// What should happen if it is the *next* season but there are no posts
			echo '<h2>Archives: ' . $seasontitle . '</h2>'; ?>
				<section class="p-section">
					<p>We’re busy planning for next season, but the details aren’t available yet. Check back soon and in the meantime, why not <a href="<?php get_post_type_archive_link('concert') ?>">check out what’s happening right now</a>?</p></p>
				</section><?php
		}
		else {
			// OK, now we’re talking. Check if posts exist?
			?>
			<article id="fp-events" class="p-section">
				<header>
					<h2>Archives<br /><?php echo $seasontitle ?></h2>
					<nav class="clearfix"><a href="" title="Older" class="icon-left-arrow-bold"></a> <a href="" title="Newer" class="icon-right-arrow-bold"></a></nav>
				</header>
			<?php
			if ( have_posts() ) : ?>
				<section class="concerts <?php if(!$colloquia) { echo 'solo'; } ?>">
					<h3>Concerts</h3>
					<ul>
					<?php while ( have_posts() ) : the_post(); ?>						
						<li <?php post_class('vevent clearfix'); ?>>
							<a href="<?php echo get_permalink() ?>" class="url">
								<?php $dtstart = DateTime::createFromFormat('d/m/Y', get_field('dtstart')); ?>
								<h4 class="dtstart"><time class="value-title" datetime="<?php echo $dtstart->format('Y-m-d\TH:i:sO'); ?>" title="<?php echo $dtstart->format('Y-m-d\TH:i:sO'); ?>">
									<?php echo '<span class="month">' . $dtstart->format('M') . '</span> <span class="day">' . $dtstart->format('j'); ?>
								</time></h4>
								<div class="details">
									<p class="summary"><?php the_title() ?></p>
									<p class="location"><?php the_field('location'); ?></p>
								</div>
							</a>
						</li>
					<?php endwhile; ?>
					</ul>
				</section>
			<?php else: ?>
			<?php endif;
			if ($colloquia) : ?>
				<section class="colloquia <?php if(!have_posts()) { echo 'solo'; } ?>">
					<h3>Colloquia</h3>
					<ul>
					<?php foreach($colloquia as $colloquium): ?>
						<li id="" <?php post_class('vevent clearfix'); ?>>
							<?php $dtstart = DateTime::createFromFormat('d/m/Y', get_field('dtstart', $colloquium->ID)); ?>
							<h4 class="dtstart"><time class="value-title" datetime="<?php echo $dtstart->format('Y-m-d\TH:i:sO'); ?>" title="<?php echo $dtstart->format('Y-m-d\TH:i:sO'); ?>"><?php echo $dtstart->format('n/j'); ?></time></h4>
							<span class="summary">
								<?php $type = get_field('colloquium_type', $colloquium->ID);
								if($type == 'HGNM Member') {
									$composerid = get_field('fname', $colloquium->ID);
									echo '<a href="' . esc_url( get_permalink($composerid->ID) ) . '" class="url">' . get_the_title($colloquium->ID) . '</a>';
								}
								elseif($type == 'Guest Speaker') {
									if(get_field('url', $colloquium->ID)) {
										echo '<a href="' . esc_url( get_field('url', $colloquium->ID) ) . '" class="url exit" target="_blank">' . get_the_title($colloquium->ID) . '</a>';
									}
									else {
										echo get_the_title($colloquium->ID);
									}
								}
								elseif($type == 'Post-Concert Discussion') {
									echo $type . ': ' . get_the_title($colloquium->ID);
								}
								else {
									// If none of the above types (shouldn’t happen, but who knows…)
									echo get_the_title($colloquium->ID);
								} ?>
							</span>

						</li>
					<?php endforeach; ?>
					</ul>
				</section>
			<?php endif;
			echo '</article>';
		}

get_footer();

?>