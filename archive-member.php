<?php

get_header();

		// Get composers names, photos and permalinks
		$today = date('Ymd', strtotime('-1 day'));
		$members = get_posts(array(
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

		if ($members) {
			component('member_list', array(
				"members" => $members
			));
		}

		// Get graduated composers names, photos and permalinks
		$today = date('Ymd', strtotime('-1 day'));
		$past_members = get_posts(array(
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

		if ($past_members) {
			component('member_list', array(
				"members" => $past_members,
				"heading" => 'Past Members',
				"show_image" => false
			));
		}

		if (!$members && !$past_members) {
			echo '<section class="composers p-section"><h2>Composers</h2><p>I’m afraid it looks like there aren’t any composers to show you yet.</p>';
		}

		echo '</article>';

get_footer();

?>
