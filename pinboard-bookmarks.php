<?php
/**
 * Plugin Name:     Pinboard Bookmarks
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     Fetch bookmarks from Pinboard
 * Author:          Ross Wintle
 * Author URI:      https://rosswintle.uk
 * Text Domain:     pinboard-bookmarks
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Pinboard_Bookmarks
 */

namespace PinboardBookmarks;

/**
 * Pinboard Bookmarks class
 */
class PinboardBookmarks {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_post_types' ] );
	}

	/**
	 * Registers post types
	 *
	 * @return void
	 */
	public function register_post_types() {
		require_once 'post-types/pinboard-bookmark.php';
	}
}

$pbbm_instance = new PinboardBookmarks();
