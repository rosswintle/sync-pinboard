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
require_once 'post-types/class-pinboard-bookmark.php';
require_once 'taxonomies/pinboard-tag.php';
require_once 'class-pinboard-sync-options.php';
require_once 'class-pinboard-sync-admin.php';
require_once 'class-pinboard-api.php';
require_once 'class-pinboard-sync-core.php';
require_once 'vendor/autoload.php';

/**
 * Pinboard Sync class
 */
class Pinboard_Sync {

	/**
	 * Constructor
	 */
	public function __construct() {
		// Initial hooks.
		add_action( 'admin_menu', [ $this, 'admin_menu_hooks' ] );
	}

	/**
	 * Run any admin menu hook actions
	 *
	 * @return void
	 */
	public function admin_menu_hooks() {
		new Pinboard_Sync_Admin();
	}

}

$pbsync_instance = new Pinboard_Sync();
