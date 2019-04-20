<?php
/**
 * Core code for syncing Pinboard pins to WordPress posts
 */

namespace PinboardSync;

use PinboardSync\Pinboard_API;
use PinboardSync\Pinboard_Sync_Options;

/**
 * Core class for syncing
 */
class Pinboard_Sync_Core {

	// Time of last "recent" method call - this can only be called every minute
	//protected $last_recent_call = null;

	// Timestamp of the last sync
	protected $last_sync = null;

	public function __construct() {
		$stored_last_sync = get_option( 'pinboard-sync-last-sync' );

		$this->last_sync = ( false !== $stored_last_sync ) ? $stored_last_sync : time();
	}

	public function sync() {
		$api = new Pinboard_API();

		$last_update_data = $api->call( 'posts/update' );

		if ( ! $last_update_data ) {
			// Log something?
			exit;
		}

		$last_update_time = $last_update_data->update_time;

		// Compare last update time to last sync to see if anything is new.
		if ( strtotime( $last_update_time ) < $this->last_sync ) {
			echo 'Nothing new to sync';
			return;
		}

		// Can't make API calls less than 3 seconds apart.
		sleep( 4 );

		$new_pins = $api->posts_all( [ 'fromdt' => date( 'Y-m-d\TH:i:s\Z', $this->last_sync ) ] );

		if ( ! is_array( $new_pins ) ) {
			return;
		}

		// Get the author ID to use.
		$author_id = Pinboard_Sync_Options::get_pin_author();

		// Loop through pins creating posts for them.
		foreach ( $new_pins as $pin ) {

			$post_data = [
				'post_type'    => 'pinboard-bookmark',
				'post_date'    => date( 'Y-m-d H:i:s', strtotime( $pin->time ) ),
				'post_title'   => $pin->description,
				'post_content' => $pin->extended,
				'post_status'  => 'yes' === $pin->shared ? 'publish' : 'private',
				'meta_input'   => [
					'hash'     => $pin->hash,
					'url'      => $pin->href,
				],
				'post_author'  => $author_id,
			];

			$existing_pin = Pinboard_Bookmark::with_hash( $pin->hash );
			if ( $existing_pin ) {
				$post_data['ID'] = $existing_pin->ID;
			}

			$result = wp_insert_post( $post_data );

			if ( $result > 0 ) {
				$terms = explode( ' ', $pin->tags );
				wp_set_post_terms( $result, $terms, 'pinboard-tag' );
			}

		}

		// Update last sync time
		$this->last_sync = time();
		update_option( 'pinboard-sync-last-sync',  $this->last_sync );

	}

}
