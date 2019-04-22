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

	public static function get_pin_author() {
		return get_option( 'pinboard-sync-author' );
	}

	public static function set_pin_author( $value ) {
		return update_option( 'pinboard-sync-author', $value );
	}

	public static function get_pin_sync_status() {
		return (int)get_option( 'pinboard-sync-status' );
	}

	public static function set_pin_sync_status( $value ) {
		return update_option( 'pinboard-sync-status', $value );
	}

}
