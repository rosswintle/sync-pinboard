<?php
/**
 * Core code for syncing Pinboard pins to WordPress posts
 */

namespace PinboardSync;

use PinboardSync\Pinboard_API;

/**
 * Core class for syncing
 */
class Pinboard_Sync_Core {

	// Time of last "all" method call - this can only be called every five minutes
	//protected $last_all_call = null;

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

		// Compare last update time to last sync to see if anything is new
		if (strtotime($last_update_time) < $this->last_sync) {
			//echo "Nothing to sync";
			return;
		}

		// Can't make API calls less than 3 seconds apart
		sleep(4);

		$new_pins = $api->call( 'posts/all', [ 'fromdt' => date( 'Y-m-d\TH:i:s\Z', $this->last_sync ) ] );

		// Loop through pins creating posts for them
		foreach ( $new_pins as $pin ) {

		}
		var_dump($new_pins);

		// Update last sync time
		$this->last_sync = time();
		update_option( 'pinboard-sync-last-sync',  $this->last_sync );

	}

}
