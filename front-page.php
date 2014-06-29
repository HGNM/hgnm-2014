<?php

get_header();

		if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post" <?php post_class(); ?>>
					<h2 class="post-title"><?php the_title(); ?></h2>
					<div class="entry"><?php the_content(); ?></div>
				</article><!-- #post -->
			<?php endwhile; ?>
		<?php else: ?>
		<?php endif;
		
		$posts = get_posts(array(
			'numberposts' => -1,
			'post_type' => 'member',
			'meta_key' => 'dtend',
			'meta_value' => ''
		));
		 
		if($posts)
		{
			echo '<h2>Composers</h2><ul>';
		 
			foreach($posts as $post)
			{
				echo '<li><a href="' . get_permalink($post->ID) . '">' . get_the_post_thumbnail($post->ID, 'thumbnail') . '<span>' . get_the_title($post->ID) . '</span>' . '</a></li>';
			}
		 
			echo '</ul>';
		}

get_footer();

?>