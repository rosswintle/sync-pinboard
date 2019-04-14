<?php
/**
 * Plugin Name:     Pinboard Sync
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     Fetch bookmarks from Pinboard
 * Author:          Ross Wintle
 * Author URI:      https://rosswintle.uk
 * Text Domain:     pinboard-sync
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Pinboard_Sync
 */

namespace PinboardSync;

require_once 'post-types/pinboard-bookmark.php';


/**
 * Pinboard Sync class
 */
class PinboardSync {

	/**
	 * Constructor
	 */
	public function __construct() {
		// add_action( 'init', [ $this, 'register_post_types' ] );
	}

}

$pbsync_instance = new PinboardSync();
