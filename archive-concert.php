<?php

get_header();

        // If there is a year query, e.g. '?y=2012', get it and use it as a variable, else set it to the current year
        if (get_query_var('y')) {
            if (filter_var(get_query_var('y'), FILTER_VALIDATE_INT, array('options' => array('min_range' => 0, 'max_range' => 9999,))) !== false) {
                $yearquery = get_query_var('y');
            }
        } else {
            // Set correct year query from current date when no query_var present
            if (date('m') > 8) {
                $yearquery = date('Y') - 1;
            } else {
                $yearquery = date('Y') - 2;
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
        } else {
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
                'orderby' => 'dtstart',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key' => 'dtstart',
            'value'  => $season,
            'compare'  => 'BETWEEN'
                    )
                )
            )
        );

        // Get archived miscellaneous events
        $miscevents = get_posts(
            array(
                'numberposts' => -1,
                'post_type' => 'miscevent',
                'meta_key' => 'dtstart',
                'orderby' => 'dtstart',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key' => 'dtstart',
            'value'  => $season,
            'compare'  => 'BETWEEN'
                    )
                )
            )
        );

        //
        // Let’s start building a select menu
        //
        $seed = 1984;
        if (date('m') > 8) {
            $now = date('Y') + 1;
        } else {
            $now = date('Y');
        }
        $years = range($seed, $now);

        $menuitems = array();

        foreach ($years as $year) {

            // Set query variables for each year
            $querystart = $year . '0901';
            $queryend = ($year + 1) . '0831';
            $query = array($querystart,$queryend);

            // Get archived concerts
            $concertcheck = get_posts(
                array(
                    'numberposts' => 1,
                    'post_type' => 'concert',
                    'meta_key' => 'dtstart',
                    'orderby' => 'dtstart',
                    'order' => 'ASC',
                    'meta_query' => array(
                        array(
                            'key' => 'dtstart',
                            'value'  => $query,
                            'compare'  => 'BETWEEN'
                        )
                    )
                )
            );

            // Get archived colloquia
            $colloquiumcheck = get_posts(
                array(
                    'numberposts' => 1,
                    'post_type' => 'colloquium',
                    'meta_key' => 'dtstart',
                    'orderby' => 'dtstart',
                    'order' => 'ASC',
                    'meta_query' => array(
                        array(
                            'key' => 'dtstart',
                            'value'  => $query,
                            'compare'  => 'BETWEEN'
                        )
                    )
                )
            );

            // Get archived miscellaneous events
            $misceventscheck = get_posts(
                array(
                    'numberposts' => 1,
                    'post_type' => 'miscevent',
                    'meta_key' => 'dtstart',
                    'orderby' => 'dtstart',
                    'order' => 'ASC',
                    'meta_query' => array(
                        array(
                            'key' => 'dtstart',
                            'value'  => $query,
                            'compare'  => 'BETWEEN'
                        )
                    )
                )
            );

            if ($concertcheck || $colloquiumcheck || $misceventscheck) {
                $menuitems = array_merge($menuitems, array($year));
            }
        } // endforeach years checker

        $flippedmenuitems = (array_flip($menuitems));
        $currentindex = isset($flippedmenuitems[$yearquery]) ? $flippedmenuitems[$yearquery] : null;
        $previousyear = isset($menuitems[($currentindex - 1)]) ? $menuitems[($currentindex - 1)] : null;
        $nextyear = isset($menuitems[($currentindex + 1)]) ? $menuitems[($currentindex + 1)] : null;

        // Check queries to see if it is for a season starting more than a year in the future. N.B. The *next* season will return as false.
        echo '<article id="events" class="p-section clearfix">';
        if ($seasonstart > date('Ymd', strtotime(date('Ymd', time()) . ' + 365 day'))) {
            // What should happen if someone wants to see into the future?
            echo '<h2>Archives</h2><p>Welcome to the future! It looks like you’re looking for events in the ' . $seasontitle . ' season, but unfortunately this is neither a time machine nor a crystal ball. Why not <a href="' . get_post_type_archive_link('concert') . '">check out what’s happening right now</a>?</p>';
        } elseif ($seasonstart < 19840900) {
            // What should happen if it is before HGNM was founded?
            echo '<h2>Archives</h2><p>' . $yearquery . '? Harvard Group for New Music wasn’t founded until 1984, so there’s nothing to see for this date. Why not <a href="' . get_post_type_archive_link('concert') . '">check out what’s happening right now</a>?</p>';
        } elseif ($seasonstart > date('Ymd') && !have_posts()) {
            // What should happen if it is the *next* season but there are no posts
            echo '<h2>Archives: ' . $seasontitle . '</h2>'; ?>
          <p>We’re busy planning for next season, but the details aren’t available yet. Check back soon and in the meantime, why not <a href="<?php echo get_post_type_archive_link('colloquium') ?>">check out what’s happening right now</a>?</p></p>
    <?php
        } elseif (!have_posts() && !$colloquia && !$miscevents) {
            // What should happen there are no posts
            echo '<h2>Archives: ' . $seasontitle . '</h2>'; ?>
          <p>Whoops, looks like we don’t have any events for this season. Why not <a href="<?php echo get_post_type_archive_link('colloquium') ?>">check out what’s happening right now</a>?</p></p>
    <?php
        } else {
            // OK, now we’re talking. Check if posts exist?
            // Display archive header and navigation
            ?>
        <header class="archive-header">
          <h2>Archives<br /><?php echo $seasontitle ?></h2>
          <nav id="archive-nav" class="clearfix">
            <?php if ($previousyear) : ?>
              <a href="<?php echo get_post_type_archive_link('concert') . $previousyear . '/'; ?>" class="left">
                <span class="icon icon-left-arrow-bold" aria-hidden="true"></span>
                <span class="text">Older Archive</span>
              </a>
            <?php endif; ?>
            <?php if ($nextyear) : ?>
              <a href="<?php echo get_post_type_archive_link('concert') . $nextyear . '/'; ?>" class="right">
                <span class="text">Newer Archive</span>
                <span class="icon icon-right-arrow-bold" aria-hidden="true"></span>
              </a>
            <?php endif; ?>
          </nav>
        </header>
      <?php
            // Display archived concerts for $yearquery season
            if (have_posts()) : ?>
        <section class="concerts <?php if (!$colloquia) {
                echo 'solo';
            } ?>">
          <h3>Concerts</h3>
          <ul>
            <?php while (have_posts()) {
                the_post();
                echo component('concert_list_item', array( "id" => get_the_ID() ));
            } ?>
          </ul>
        </section>
      <?php else: ?>
      <?php endif;
            // Display archived colloquia for $yearquery season
            if ($colloquia) : ?>
        <section class="colloquia <?php if (!have_posts()) {
                echo 'solo';
            } ?>">
          <h3>Colloquia</h3>
          <?= component('colloquium_list', array("colloquia" => $colloquia)) ?>
        </section>
      <?php endif;
            // Display archived miscellaneous events for $yearquery season
            if ($miscevents): ?>
        <section class="miscevents">
          <h3>Other Events</h3>
          <ul>
          <?php foreach ($miscevents as $miscevent): ?>
            <li class="vevent clearfix">
              <h4 class="dtstart">
                <?php
                                $dtstart = DateTime::createFromFormat('d/m/Y', get_field('dtstart', $miscevent->ID));
            $dtend = DateTime::createFromFormat('d/m/Y', get_field('dtend', $miscevent->ID));
            echo '<time class="value-title" datetime="' . $dtstart->format('Y-m-d\TH:i:sO') . '" title="' . $dtstart->format('Y-m-d\TH:i:sO') . '">';
            if (get_field('dtend', $miscevent->ID)) :
                                        if ($dtstart->format('n') == $dtend->format('n')) :
                                            echo $dtstart->format('n/j') . '–' . $dtend->format('j'); else :
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
      <?php endif;

            if ($menuitems) {
                echo '<footer id="years-nav"><h3>Explore Seasons</h3><ul>';
                foreach ($menuitems as $item) {
                    if (($item % 100) == 99) {
                        $menulabel = $item . '–' . ($item + 1);
                    } else {
                        $menulabel = $item . '–' . str_pad((($item + 1) % 100), 2, '0', STR_PAD_LEFT);
                    }
                    echo '<li';
                    if ($item == $yearquery) {
                        echo ' class="current"';
                    }
                    echo '><a href="' . get_post_type_archive_link('concert') . $item . '/">' . $menulabel . '</a></li>';
                }
                echo '</ul></footer>';
            }
        }
        echo '</article>';

get_footer();

?>
