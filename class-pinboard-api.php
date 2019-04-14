<?php
/**
 * Pinboard API class
 *
 * @package PinboardSync
 */

namespace PinboardSync;

use GuzzleHttp\Client;

/**
 * Class for using the Pinboard.in API
 */
class Pinboard_API {

	/**
	 * Generic API call wrapper
	 *
	 * @param  string $method
	 * @param  array $options
	 * @return array|null
	 */
	public function call( $method, $options = [] ) {
		$key = Pinboard_Sync_Options::get_api_key();

		if (! $key) {
			return null;
		}

		$default_options = [
			'format'     => 'json',
			'auth_token' => $key,
		];

		$options = wp_parse_args( $options, $default_options );

		$guzzle = new Client([
			'base_uri' => 'http://api.pinboard.in/v1/',
		]);

		$response = $guzzle->get( $method, ['query' => $options] );

		if (200 !== $response->getStatusCode()) {
			return null;
		}

		$bodyText = (string) $response->getBody();
		$bodyData = json_decode($bodyText);

		return $bodyData;
	}

}
