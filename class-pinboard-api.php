<?php
/**
 * Pinboard API class
 *
 * @package PinboardSync
 */

namespace SyncPinboard;

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
		$key = Sync_Pinboard_Options::get_api_key();

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

	public function posts_all( $options ) {
		// We use a timestamp in a transient to suspend calls for the next 5 minutes
		// as this API method can only be called every 5 minutes
		$suspended = get_transient( 'pinboard-posts-all-suspended' );
		if ( false !== $suspended ) {
			echo "Slow down!";
			return null;
		}

		set_transient( 'pinboard-posts-all-suspended', time(), 5 * 60 );

		return $this->call( 'posts/all', $options );
	}

}
