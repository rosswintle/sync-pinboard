<?php
/**
 * Plugin Name:     Sync Pinboard
 * Description:     Fetch bookmarks from pinboard.in into a custom post type and custom taxonomy
 * Author:          Ross Wintle
 * Author URI:      https://rosswintle.uk
 * Text Domain:     sync-pinboard
 * Domain Path:     /languages
 * Version:         0.2.0
 *
 * @package         Sync_Pinboard
 */

namespace SyncPinboard;

require_once 'post-types/pinboard-bookmark.php';
require_once 'post-types/class-pinboard-bookmark.php';
require_once 'taxonomies/pinboard-tag.php';
require_once 'class-pinboard-sync-options.php';
require_once 'class-pinboard-sync-admin.php';
require_once 'class-pinboard-sync-meta-boxes.php';
require_once 'class-pinboard-sync-cron.php';
require_once 'class-pinboard-sync-wp-cli.php';
require_once 'class-pinboard-api.php';
require_once 'class-pinboard-sync-core.php';
require_once 'vendor/autoload.php';

/**
 * Sync Pinboard class
 */
class Sync_Pinboard {

	/**
	 * Constructor
	 */
	public function __construct() {
		// Initial hooks.
		add_action( 'init', [ $this, 'init_hooks' ] );
		add_action( 'admin_menu', [ $this, 'admin_menu_hooks' ] );

		$this->register_deactivation_hook();
	}

	/**
	 * Run any init hook actions
	 *
	 * @return void
	 */
	public function init_hooks() {
		new Sync_Pinboard_Cron();
		new Sync_Pinboard_Meta_Boxes();
		new Sync_Pinboard_WPCLI();
	}

	/**
	 * Run any admin menu hook actions
	 *
	 * @return void
	 */
	public function admin_menu_hooks() {
		new Sync_Pinboard_Admin();
	}

	/**
	 * Register a deactivation hook - this will trigger the sync_pinboard_deactivate action
	 * so anything that needs to be done on deactivation should be done using that hook.
	 *
	 * @return void
	 */
	public function register_deactivation_hook() {
	   register_deactivation_hook( __FILE__, [ $this, 'run_deactivation_hook' ] );
	}

	/**
	 * This actually does the pinboard_sync_deactivate hook
	 */
	public function run_deactivation_hook() {
		do_action('sync_pinboard_deactivate');
	}

	/**
	 * This takes a timestamp and turns it into local time using the gmt_offset options
	 */
	public static function make_time_local( $timestamp ) {
		$offset_secs = ((int)get_option('gmt_offset')) * 60 * 60;
		return $timestamp + $offset_secs;
	}

}

$syncpb_instance = new Sync_Pinboard();
