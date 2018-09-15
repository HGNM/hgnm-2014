<?php

get_header();

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

		echo '<article>';

		if($posts) { component('member_list', $posts); }


		// Get graduated composers names, photos and permalinks
		$today = date('Ymd', strtotime('-1 day'));
		$posts2 = get_posts(array(
			'numberposts' => -1,
			'post_type' => 'member',
			'meta_key' => 'dtend',
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key' => 'dtend',
					'value' => '',
					'compare' => '!=' // Exclude posts where field is not set
				),
				array(
					'key' => 'dtend',
					'value' => $today,
					'type' => 'numeric',
					'compare' => '<'
				)
			)
		));
		if($posts2)
		{
			echo '<section class="composers p-section"><h2>Past Members</h2><ul class="clearfix">';
			foreach($posts2 as $post)
			{
				$imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'hgnm-thumb');
				echo '<li><a href="' . get_permalink($post->ID) . '">';
				echo '<span>' . get_the_title($post->ID) . '</span>' . '</a></li>';
			}
			echo '</ul></section>';
		}

		if( !$posts && !$posts2 ) {
			echo '<section class="composers p-section"><h2>Composers</h2><p>I’m afraid it looks like there aren’t any composers to show you yet.</p>';
		}

		echo '</article>';



get_footer();

?>
