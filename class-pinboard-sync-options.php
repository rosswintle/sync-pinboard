<?php
/**
 * Pinboard Sync Options
 *
 * @package PinboardSync;
 */

namespace PinboardSync;

class Pinboard_Sync_Options {

	public static function get_api_key() {
		return get_option( 'pinboard-sync-api-key' );
	}

	public static function set_api_key( $value ) {
		return update_option( 'pinboard-sync-api-key', $value );
	}

}
