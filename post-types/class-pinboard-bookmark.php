<?php

namespace SyncPinboard;

class Pinboard_Bookmark {

	public static function with_hash( $hash ) {
		$posts = get_posts([
			'post_type'  => 'pinboard-bookmark',
			'meta_query' => [
				[
					'key'   => 'hash',
					'value' => $hash,
				],
			],
		]);
		if (is_array($posts)) {
			return $posts[0];
		} else {
			return null;
		}
	}

}
