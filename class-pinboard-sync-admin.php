<?php
/**
 * The wp-admin side of the settings/options
 */

namespace PinboardSync;

use PinboardSync\Pinboard_Sync_Options;

class Pinboard_Sync_Admin {

	/**
	 * Constructor - setup all the things!
	 */
	public function __construct() {
		add_submenu_page( 'options-general.php', 'Pinboard Sync Settings', 'Pinboard Sync', 'manage_options', 'pinboard-sync', [ $this, 'page' ] );
	}

	/**
	 * Echo the page (and handle form submit)
	 *
	 * @return void
	 */
	public function page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'Unauthorized user' );
		}

		$this->handle_submission();

		$api_key = Pinboard_Sync_Options::get_api_key();

		?>
			<h1>Pinboard Sync Settings</h1>
			<form method="POST">
				<?php wp_nonce_field( 'pinboard-sync-settings' ); ?>
				<div class="form-group">
					<label for="api-key">Pinboard API Key</label>
					<input type="text" name="api-key" id="api-key" value="<?php echo $api_key ? esc_attr( $api_key ) : ''; ?>">
				</div>
				<div>
					<input type="submit" value="Update options">
				</div>
			</form>
		<?php
	}

	/**
	 * Handle a post submission to the page
	 *
	 * @return void
	 */
	public function handle_submission() {
		if ( ! isset( $_POST['_wpnonce'] ) ) {
			return;
		}

		check_admin_referer( 'pinboard-sync-settings' );

		if ( isset( $_POST['api-key'] ) ) {
			Pinboard_Sync_Options::set_api_key( $_POST['api-key'] );
		}
	}

}