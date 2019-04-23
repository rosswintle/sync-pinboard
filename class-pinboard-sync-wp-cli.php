<?php

namespace PinboardSync;

class Pinboard_Sync_WPCLI {

	public function __construct() {
		if (class_exists('WP_CLI')) {
			\WP_CLI::add_command( 'pinboard-sync', [ $this, 'sync' ] );
		}
	}

    /**
     * Runs a pinboard sync. Pull all pins since the last sync.
     *
     * If this is the first sync it should pull all pins (this can take some time).
     *
     * ## OPTIONS
     *
     * ## EXAMPLES
     *
     *     wp pinboard-sync
     *
     * @when after_wp_load
     */
	public function sync( $args, $assoc_args ) {
		\WP_CLI::log('Starting sync');

		$last_sync = get_option( 'pinboard-sync-last-sync' );
		if (false === $last_sync) {
			\WP_CLI::log('This is the first sync. If you have a lot of bookmarks then this may take some time.');
		} else {
			\WP_CLI::log('Last sync was: ' . date('jS F Y H:i:s', Pinboard_Sync::make_time_local($last_sync)));
		}

		$suspended = get_transient( 'pinboard-posts-all-suspended' );
		if (false !== $suspended) {
			\WP_CLI::log('API is suspended - you are not allowed to make a request. Try again shortly.');
			exit;
		}

    	$core = new Pinboard_Sync_Core();
    	$core->sync();

    	\WP_CLI::log('Sync finished');
	}

}
