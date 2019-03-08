<?php

get_header();

if (have_posts()) :
    while (have_posts()) :
        the_post();

        // Get composer ID to look for
        $testID = get_the_ID();

        // Get archived colloquia
        $colloquia = event_query(array(
            'order'         => 'ASC',
            'post_type'     => 'colloquium',
            'ft_composer'   => $testID,
        ));

        // Get archived concerts
        $concerts = event_query(array(
            'order'         => 'ASC',
            'post_type'     => 'concert',
            'ft_composer'   => $testID
        ));

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

        // Set variable that can be checked and emptied if no media is found
        $archivemedia = $pastconcerts;

        // Unset array items if they don’t contain media for this composer
        foreach ($archivemedia as $key => $row) {
            $mediacheck = 0;
            if (have_rows('programme', $row->ID)) {
                while (have_rows('programme', $row->ID)) {
                    the_row();
                    // Check if there’s a row for this composer with a media embed link
                    if (get_sub_field('composer')->ID == $testID && get_sub_field('embed_link')) {
                        $mediacheck = 1;
                    }
                }
            }
            // If no media for this composer has been found, remove this post from our array
            if ($mediacheck == 0) {
                unset($archivemedia[$key]);
            }
        }

        // Create post-class string.
        // Sets class of 'no-secondary' if no sidebar content exists.
        $postclass = 'p-section';
        if (!(has_post_thumbnail() || get_field('url') || $upcomingcolloquia || $upcomingconcerts)) {
            $postclass = $postclass . ' no-secondary';
        }
        // Sets class of 'no-primary' if no main content.
        if (!get_the_content()) {
            $postclass = $postclass . ' no-primary';
        }
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($postclass); ?>>
  <h2 class="post-title fname entry-title"><?php the_title(); ?></h2>
  <?php echo component('edit_button');
        if (get_the_content()) : ?>
  <section class="primary entry clearfix">
    <?php   the_content(); ?>
    <p class="updated">
      Last updated: <?= get_the_modified_time('F j, Y'); ?>
    </p>
  </section>
  <?php endif;
        if (has_post_thumbnail() || get_field('url') || $upcomingcolloquia || $upcomingconcerts) : ?>
  <section class="secondary clearfix">

    <?php   // Display Featured Image
            if (has_post_thumbnail()): ?>
    <div class="featured-img">
      <?php     $thumbid = get_post_thumbnail_id();
                $thumbsrc = wp_get_attachment_image_src($thumbid, 'hgnm-main');
                $thumbalt = get_post_meta($thumbid, '_wp_attachment_image_alt', true);
                echo '<img src="' . $thumbsrc[0] . '" alt="' . $thumbalt . '">'; ?>
    </div>
    <?php   endif;
            if (get_field('url')) {
                ?>
    <div class="url">
      <?= component('button_link', array(
        'href' => get_field('url'),
        'html' => 'Personal Website ' . component('icon', array('type' => 'link-ext'))
      )) ?>
    </div>
    <?php
            }

            // Display Next Colloquium
            if ($upcomingcolloquia) {
                echo '<div class="colloquia"><h3 class="sans-sc-h3">Next Colloquium</h3>';
                foreach ($upcomingcolloquia as $item) {
                    $dtstart = DateTime::createFromFormat('d/m/Y G:i', (get_field('dtstart', $item->ID) . ' 12:00'));
                    echo '<h4 class="dtstart">' .
                            $dtstart->format('l, j F — Ga') .
                         '</h4>';
                    echo component(
                        'colloquium_location_link',
                        array( "location_only" => true )
                    );
                    break;
                }
                echo '</div>';
            }

            // Display Next Concerts
            if ($upcomingconcerts) {
                $heading = 'Next Concert';
                if (count($upcomingconcerts) > 1) {
                    $heading = 'Upcoming Concerts';
                }
                echo '<div class="concerts">' .
                       '<h3 class="sans-sc-h3">' . $heading . '</h3>' .
                       '<ul>';
                foreach ($upcomingconcerts as $concert) {
                    echo component('concert_list_item', array("id" => $concert->ID));
                }
                echo   '</ul>' .
                     '</div>';
            }
    ?>
  </section> <!-- .secondary -->
  <?php endif;
        if ($archivemedia): ?>
  <section class="composerav clearfix">
    <h3>Performances from HGNM concerts</h3>
    <ul class="audio clearfix">
      <?php
            $archivemedia = array_reverse($archivemedia);
            foreach ($archivemedia as $post) :
                while (have_rows('programme', $post->ID)) :
                    the_row();
                    if (get_sub_field('composer')->ID == $testID && get_sub_field('embed_link')) : ?>
      <li>
        <p>
          <span class="mediadt">
            <?php       $concdt = DateTime::createFromFormat('d/m/Y', get_field('dtstart'));
                        echo $concdt->format('n.j.Y'); ?>
          </span><br />
          <em><?php the_sub_field('work_title', $post->ID); ?></em>,
          <a href="<?php the_permalink(); ?>">
            <?php       the_title(); ?>
          </a>
        </p>
        <?= component('responsive_embed', get_sub_field('embed_link', $post->ID)) ?>
      </li>
      <?php         endif;
                endwhile;
            endforeach; ?>
    </ul>
  </section> <!-- .composerav -->
  <?php endif; ?>

  <section class="composers-link">
    <?= component('button_link', array(
      'href' => get_post_type_archive_link('member'),
      'html' => 'See all composers »'
    )) ?>
  </section>
</article><!-- #post -->
<?php
    endwhile;
endif;

get_footer();
?>
