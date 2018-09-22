<?php

get_header();

        echo '<article>';

        // Get home page blurb
        if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
        <?= component('edit_button') ?>
        <section id="fp-blurb" <?php post_class('fp-section'); ?>>
          <div class="entry"><?php the_content(); ?></div>
          <p class="social-link">
            <?= component(
              'button_link',
              array(
                'href' => 'https://www.facebook.com/pages/Harvard-Group-for-New-Music/130937206919388',
                'html' => 'Join us on Facebook <span class="icon icon-facebook" aria-hidden="true"></span>'
              )
            ) ?>
          </p>
        </section><!-- #post -->
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
                'orderby' => 'dtstart',
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
                'orderby' => 'dtstart',
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
        // Get upcoming miscellaneous events
        $miscevents = get_posts(
            array(
                'numberposts' => 1,
                'post_type' => 'miscevent',
                'meta_key' => 'dtstart',
                'orderby' => 'dtstart',
                'order' => 'ASC',
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key' => 'dtstart',
                        'value' => $today,
            'compare' => '>'
                    ),
                    array(
                        'key' => 'dtend',
                        'value' => $today,
                        'compare' => '>'
                    )
                )
            )
        );

        // Display upcoming events
        if ($concerts || $colloquia || $miscevents) : ?>
      <section id="events" class="fp-section clearfix">
        <h2>Events</h2>
        <ul>
          <?php if ($concerts) : ?>
            <li class="concerts <?php if (!$colloquia) {
            echo 'solo';
        } ?>">
              <h3>Next Concert</h3>
              <?php foreach ($concerts as $concert) {
            echo component('concert_list_item', array(
                          "id" => $concert->ID,
                          "el" => "div"
                      ));
        } ?>
            </li>
          <?php endif; ?>
          <?php if ($colloquia) : ?>
            <li class="colloquia <?php if (!$concerts) {
            echo 'solo';
        } ?>">
            <h3>Upcoming Colloquia</h3>
            <?= component('colloquium_list', array(
                            "colloquia" => $colloquia,
                            "show_map_link" => true
                        )) ?>
            </li>
          <?php endif; ?>
          <?php if ($miscevents) : ?>
            <li class="miscevents">
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
                                                    echo $dtstart->format('n/j') . '–' . $dtend->format('j');
                                                else :
                                                    echo $dtstart->format('n/j') . '–' . $dtend->format('n/j');
                                                endif; ?>
                      <?php else : ?>
                        <?php echo $dtstart->format('n/j'); ?>
                      <?php endif; ?>
                    </time>
                  </h4>
                  <span class="summary"><a href="<?php echo get_permalink($miscevent->ID); ?>" class="url"><?php echo get_the_title($miscevent->ID); ?></a></span>
                </li>
              <?php endforeach; ?>
              </ul>
            </li>
          <?php endif; ?>
            <li class="more-events-link">
              <?= component('button_link', array(
                'href' => get_post_type_archive_link('colloquium'),
                'html' => '<p>See all upcoming events »</p>'
              )) ?>
            </li>
        </ul>
      </section> <!-- #fp-events -->
    <?php endif;

        // Get composers names, photos and permalinks
        $today = date('Ymd', strtotime('-1 day'));
        $posts = get_posts(array(
            'numberposts' => -1,
            'post_type' => 'member',
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => 'dtend',
                    'value' => null
                ),
                array(
                    'key' => 'dtend',
                    'value' => $today,
                    'type' => 'numeric',
                    'compare' => '>'
                )
            )
        ));

        if ($posts) {
            echo component('member_list', array(
                "members" => $posts
            ));
        }

        // Display archive link
        ?>
    <section id="fp-archive-link" class="fp-section">
      <?= component('button_link', array(
        'href' => get_post_type_archive_link('concert'),
        'html' => '<h2>Archive</h2><p>Dive into an archive of HGNM’s past events, members, audio and video.</p>'
      )) ?>
    </section>

    </article>

<?php get_footer();

?>
