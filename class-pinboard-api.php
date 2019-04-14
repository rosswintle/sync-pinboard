<?php
/**
 * Pinboard API class
 *
 * @package PinboardSync
 */

namespace PinboardSync;

/**
 * Class for using the Pinboard.in API
 */
class Pinboard_API {

	/**
	 * Generic API call wrapper
	 *
	 * @param  array $options
	 * @return array|null
	 */
	public function call( $options = [] ) {
		$key = Pinboard_Sync_Options::get_api_key();

		if (! $key) {
			return null;
		}

		$default_options = [
			'format'     => 'json',
			'auth_token' => $key,
		];

		return [];
	}

}
