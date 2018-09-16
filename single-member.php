<?php

get_header();

if (have_posts()) :
    while (have_posts()) :
        the_post();

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
                    ),
                    array(
                        'key' => 'colloquium_type',
                'value'  => 'HGNM Member',
                    )
                )
            )
        );

        // custom filter to replace '=' with 'LIKE'
        function my_posts_where($where)
        {
            $where = str_replace("meta_key = 'programme_$", "meta_key LIKE 'programme_%", $where);
            return $where;
        }

        add_filter('posts_where', 'my_posts_where');

        // Get archived concerts
        $concerts = get_posts(
            array(
                'suppress_filters' => false,
                'numberposts' => -1,
                'post_type' => 'concert',
                'meta_key' => 'dtstart',
                'orderby' => 'dtstart',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key' => 'programme_$_composer',
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

        // Set variable that can be checked and emptied if no media is found
        $archivemedia = $pastconcerts;

        // Unset array items if they don’t contain media for this composer
        foreach ($archivemedia as $key => $row) {
            $mediacheck = 0;
            if (have_rows('programme', $row->ID)) {
                while (have_rows('programme', $row->ID)) : the_row();
                // Check if there’s a row for this composer with a media embed link
                if (get_sub_field('composer')->ID == $testID && get_sub_field('embed_link')) {
                    $mediacheck = 1;
                }
                endwhile;
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
  <?php     component('edit_button');
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
      <a href="<?php the_field('url'); ?>" class="icon-link-ext">
        Personal Website
      </a>
    </div>
    <?php
            }

            // Display Next Colloquium
            if ($upcomingcolloquia) {
                echo '<div class="colloquia"><h3>Next Colloquium</h3>';
                foreach ($upcomingcolloquia as $item) {
                    $dtstart = DateTime::createFromFormat('d/m/Y G:i', (get_field('dtstart', $item->ID) . ' 12:00'));
                    echo '<h4 class="dtstart">' . $dtstart->format('l, j F — Ga') . '</h4>';
                    component(
                        'colloquium_location_link',
                        array( "location_only" => true )
                    );
                    break;
                }
                echo '</div>';
            }

            // Display Next Concerts
            if ($upcomingconcerts) :
                if (count($upcomingconcerts) > 1) {
                    echo '<div class="concerts"><h3>Upcoming Concerts</h3><ul>';
                } else {
                    echo '<div class="concerts"><h3>Next Concert</h3><ul>';
                }
                foreach ($upcomingconcerts as $item) : ?>
    <li class="vevent clearfix">
      <a href="<?= get_permalink($item->ID) ?>" class="url">
        <?php       $dtstart = DateTime::createFromFormat('d/m/Y G:i', (get_field('dtstart', $item->ID) . ' 20:00')); ?>
        <h4 class="dtstart">
          <time class="value-title"
                datetime="<?= $dtstart->format('Y-m-d\TH:i:sO'); ?>"
                title="<?= $dtstart->format('Y-m-d\TH:i:sO'); ?>">
            <span class="month"><?= $dtstart->format('M') ?></span>
            <span class="day"><?= $dtstart->format('j'); ?></span>
          </time>
        </h4>
        <div class="details">
          <p class="summary">
            <?= get_the_title($item->ID); ?>
          </p>
          <p class="location vcard">
            <?php   the_field('location', $item->ID); ?>
          </p>
        </div>
      </a>
    </li>
    <?php       endforeach;
                echo '</div>';
            endif;
    ?>
  </section> <!-- .secondary -->
  <?php endif;
        if ($archivemedia): ?>
  <section class="composerav clearfix">
    <h3>Performances from HGNM concerts</h3>
    <ul class="audio clearfix">
      <?php foreach ($archivemedia as $post) :
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
        <span class="embed-container">
          <?php         the_sub_field('embed_link', $post->ID) ?>
        </span>
      </li>
      <?php         endif;
                endwhile;
            endforeach; ?>
    </ul>
  </section> <!-- .composerav -->
  <?php endif; ?>

  <section class="composers-link">
    <?= '<a href="' . get_post_type_archive_link('member') . '">See all composers »</a>'; ?>
  </section>
</article><!-- #post -->
<?php
    endwhile;
endif;

get_footer();
?>
