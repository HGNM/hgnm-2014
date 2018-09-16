<?php

get_header();

        if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('p-section primary entry'); ?>>
					<h2 class="post-title fname"><?php the_title(); ?></h2>
					<?php component('edit_button') ?>
						<?php
                        // SET TIMEZONE
                        date_default_timezone_set('America/New_York');
                        $dtstart = DateTime::createFromFormat('d/m/Y G:i', (get_field('dtstart') . ' 12:00'));

                        // EVENT META — date, time & location
                        ?>
						<section class="event-meta">
							<p class="dtstart"><time class="value" datetime="<?php echo $dtstart->format('Y-m-d\TH:i:sO'); ?>">
								<?php echo $dtstart->format('l, j F Y, ga'); ?>
							</time></p>

							<?php component(
                                'colloquium_location_link',
                            array( "location_only" => true )
                            ); ?>

						</section>
						<?php if (get_field('photo')) {
                                echo '<section class="event-photo">';
                                $photo = get_field('photo');
                                echo '<img src="' . $photo['sizes']['hgnm-main'] . '" alt="' . $photo['alt'] . '">';
                                echo '</section>';
                            } ?>
						<?php the_content(); ?>
				</article>
			<?php endwhile; ?>
		<?php else: ?>
		<?php endif;

get_footer();

?>
