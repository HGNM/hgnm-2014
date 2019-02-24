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
        // custom filter to replace '=' with 'LIKE'
        function my_posts_where($where)
        {
            return str_replace("meta_key = 'programme_$", "meta_key LIKE 'programme_%", $where);
        }
        add_filter('posts_where', 'my_posts_where');

        // Get concerts with valid embed links in their programmes
        $concerts = get_posts(array(
            'suppress_filters' => false,
            'numberposts' => -1,
            'post_type' => 'concert',
            'meta_key' => 'dtstart',
            'orderby' => 'dtstart',
            'order' => 'DSC',
            'meta_query' => array(array(
                'key' => 'programme_$_embed_link',
                'value' => 'http',
                'compare' => 'LIKE'
            ))
        ));

        // access global embed variable for later
        global $wp_embed;
        ?>

        <ul class="multimedia">
            <?php
            $lastyear = INF;
            foreach ($concerts as $post) {
                $concdt = DateTime::createFromFormat('d/m/Y', get_field('dtstart'));
                $concyr = $concdt->format('Y');

                $performer_link =
                '<a href="' . get_the_permalink() . '">' .
                    get_the_title() .
                '</a>';

                if ($concyr < $lastyear) {
                    if ($lastyear !== INF) {
                        echo '</ul></li>';
                    }
                    echo '<li>
                        <h3 class="multimedia__year-heading">' . $concyr . '</h3>
                        <ul class="audio clearfix">';
                }

                $media_items = '';

                while (have_rows('programme', $post->ID)) {
                    the_row();
                    $embed_link = get_sub_field('embed_link', false);

                    if ($embed_link) {
                        $composer = get_sub_field('composer');

                        $composer_link =
                        '<a href="' . get_the_permalink($composer) . '">' .
                            get_the_title($composer) .
                        '</a>';

                        $heading =
                        '<h4 class="multimedia__item-heading">' .
                            $composer_link .
                            ' / ' .
                            $performer_link .
                            '<br>' .
                            '<em>' .
                                get_sub_field('work_title') .
                            '</em>' .
                        '</h4>';

                        $iframe = $wp_embed->shortcode(array(
                            'width' => 640,
                            'height' => 390,
                            'src' => $embed_link
                        ));

                        $media_item =
                        '<li>' .
                            $heading .
                            component('responsive_embed', $iframe) .
                        '</li>';

                        $media_items .= $media_item;
                    }
                }

                echo $media_items;

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
