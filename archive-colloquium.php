<?php

get_header();

		// Set correct year query from current date when no query_var present
		if (date('m') > 8) {
			$yearquery = date('Y');
		}
		else {
			$yearquery = date('Y') - 1;
		}

		// Set season date variables
		$seasonstart = date('Ymd') - 1;

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
				'orderby' => 'dtstart',
				'order' => 'ASC',
				'meta_query' => array(
					array(
						'key' => 'dtstart',
            'value'  => $seasonstart,
            'compare'  => '>='
					)
				)
			)
		);

		// Get upcoming colloquia
		$colloquia = get_posts(
			array(
				'numberposts' => -1,
				'post_type' => 'colloquium',
				'meta_key' => 'dtstart',
				'orderby' => 'dtstart',
				'order' => 'ASC',
				'meta_query' => array(
					array(
						'key' => 'dtstart',
            'value'  => $seasonstart,
            'compare'  => '>='
					)
				)
			)
		);

		// Get upcoming miscellaneous events
		$miscevents = get_posts(
			array(
				'numberposts' => -1,
				'post_type' => 'miscevent',
				'meta_key' => 'dtstart',
				'orderby' => 'dtstart',
				'order' => 'ASC',
				'meta_query' => array(
					'relation' => 'OR',
					array(
						'key' => 'dtstart',
            'value'  => $seasonstart,
            'compare'  => '>='
					),
					array(
						'key' => 'dtend',
						'value' => $seasonstart,
						'compare' => '>='
					)
				)
			)
		);

			// Display events header and navigation
			?>
			<article id="events" class="p-section clearfix">
				<header class="archive-header">
					<h2>Events</h2>
				</header>

			<?php
			// What to do if there are no upcoming events
			if (! (have_posts() || $colloquia || $miscevents)) {
				echo '<section class="entry"><p>It looks like there are no events planned at the moment. Please check back later.</p></section>';
			}

			// Display archived concerts for $yearquery season
			if ( have_posts() ) : ?>
				<section class="concerts <?php if(!$colloquia) { echo 'solo'; } ?>">
					<h3>Upcoming Concerts</h3>
					<ul>
					<?php while ( have_posts() ) {
						the_post();
						component('concert_list_item', array( "id" => get_the_ID() ));
					} ?>
					</ul>
				</section>
			<?php endif;
			// Display archived colloquia for $yearquery season
			if ($colloquia) : ?>
				<section class="colloquia <?php if(!have_posts()) { echo 'solo'; } ?>">
					<h3>Upcoming Colloquia</h3>
					<?php component('colloquium_list', array(
						"colloquia" => $colloquia,
						"show_map_link" => true
					)) ?>
				</section>
			<?php endif;
			// Display archived miscellaneous events for $yearquery season
			if ($miscevents): ?>
				<section class="miscevents">
					<h3>Other Events</h3>
					<ul>
					<?php foreach($miscevents as $miscevent): ?>
						<li class="vevent clearfix">
							<h4 class="dtstart">
								<?php
								$dtstart = DateTime::createFromFormat('d/m/Y', get_field('dtstart', $miscevent->ID));
								$dtend = DateTime::createFromFormat('d/m/Y', get_field('dtend', $miscevent->ID));
								echo '<time class="value-title" datetime="' . $dtstart->format('Y-m-d\TH:i:sO') . '" title="' . $dtstart->format('Y-m-d\TH:i:sO') . '">';
									if(get_field('dtend', $miscevent->ID)) :
										if ($dtstart->format('n') == $dtend->format('n')) :
											echo $dtstart->format('n/j') . '–' . $dtend->format('j');
										else :
											echo $dtstart->format('n/j') . '–' . $dtend->format('n/j');
										endif; ?>
									<?php else : ?>
										<?php echo $dtstart->format('n/j'); ?>
									<?php endif; ?>
								</time>
							</h4>
							<span class="summary"><a href="<?php echo get_permalink($miscevent->ID) ?>" class="url"><?php echo get_the_title($miscevent->ID); ?></a></span>
						</li>
					<?php endforeach; ?>
					</ul>
				</section>
			<?php endif; ?>
			<footer class="more-events-link">
				<a href="<?php echo get_post_type_archive_link('concert') . $yearquery . '/'; ?>">
					<p>See all events from this season »</p>
				</a>
			</footer>
			<?php echo '</article>';

get_footer();

?>
