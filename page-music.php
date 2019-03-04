<?php
get_header();
?>

<article class="p-section primary entry">
    <h2 class="post-title fname">
        <?php the_title(); ?>
    </h2>
    <?= component('edit_button') ?>
    <section>
        <?php
        // Get concerts with valid embed links in their programmes
        $concerts = event_query(array(
            'post_type' => 'concert',
            'has_av'    => true
        ));
        ?>

        <ul>
            <?php
            $lastyear = INF;
            $lastindex = array_keys($concerts)[count($concerts) - 1];
            $media_items = array();
            foreach ($concerts as $index => $post) {
                $concdt = DateTime::createFromFormat('d/m/Y', get_field('dtstart'));
                $concyr = $concdt->format('Y');

                $next = $index + 1;
                $nextconc = isset($concerts[$next]) ? $concerts[$next] : NULL;
                $nextconcdt = $nextconc ? DateTime::createFromFormat('d/m/Y', get_field('dtstart', $nextconc->ID)) : NULL;
                $nextconcyr = $nextconcdt ? $nextconcdt->format('Y') : NULL;

                $performer_link =
                '<a href="' . get_the_permalink() . '">' .
                    get_the_title() .
                '</a>';

                while (have_rows('programme')) {
                    the_row();
                    $media_item = component('embed_card', array(
                        'post' => $post
                    ));
                    if ($media_item) {
                        $media_items[] = $media_item;
                    }
                }

                if ($concyr < $lastyear) {
                    echo '<li>
                        <h3 class="h2">' . $concyr . '</h3>';
                }
                if ($concyr !== $nextconcyr) {
                    echo component('responsive_card_list', array('cards' => $media_items));
                    echo '</li>';
                    $media_items = array();
                }

                $lastyear = $concyr;
            } ?>
                </ul>
            </li>
        </ul>
    </section>
</article>

<?php
get_footer();
?>
