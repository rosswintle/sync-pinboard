<?php
/**
 * Pinboard Sync Options
 *
 * @package SyncPinboard;
 */

namespace SyncPinboard;

class Sync_Pinboard_Options {

	public static function get_api_key() {
		return get_option( 'sync-pinboard-api-key' );
	}

	public static function set_api_key( $value ) {
		return update_option( 'sync-pinboard-api-key', $value );
	}

	public static function get_pin_author() {
		return get_option( 'sync-pinboard-author' );
	}

	public static function set_pin_author( $value ) {
		return update_option( 'sync-pinboard-author', $value );
	}

	public static function get_pin_sync_status() {
		return (int)get_option( 'sync-pinboard-status' );
	}

	public static function set_pin_sync_status( $value ) {
		return update_option( 'sync-pinboard-status', $value );
	}

}
