<?php
/**
 * The wp-admin side of the settings/options
 */

namespace PinboardSync;

use PinboardSync\Pinboard_Sync_Options;
use PinboardSync\Pinboard_Sync_Cron;

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

		$api_key         = Pinboard_Sync_Options::get_api_key();
		$pin_author      = Pinboard_Sync_Options::get_pin_author();
		$pin_sync_status = Pinboard_Sync_Options::get_pin_sync_status();

		?>
			<h1>Pinboard Sync Settings</h1>

			<hr>

			<p><strong>Please note:</strong> This is not an official Pinboard plugin. If you have any problems please direct them to the WordPress support forums for this plugin.</p>

			<hr>

			<form method="POST">
				<?php wp_nonce_field( 'pinboard-sync-settings' ); ?>
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row">
								<label for="api-key">Pinboard API Key</label>
							</th>
							<td>
								<input type="text" class="regular-text" name="api-key" id="api-key" value="<?php echo $api_key ? esc_attr( $api_key ) : ''; ?>">
								<p class="description" id="tagline-description">You can get this from your <a href="https://pinboard.in/settings/password">Pinboard password settings screen</a></p>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="pin-author">Sync'ed pin author</label>
							</th>
							<td>
								<select name="pin-author" id="pin-author">
									<?php foreach (get_users() as $user) : ?>
										<option value="<?php echo esc_attr($user->ID); ?>" <?php selected($pin_author, $user->ID); ?>>
											<?php echo esc_html($user->display_name); ?>
										</option>
									<?php endforeach; ?>
								</select>
								<p class="description" id="tagline-description">All new pins synced will be assigned to this author.</p>
							</td>
						</tr>
						<tr>
							<th scope="row">
								Auto-sync
							</th>
							<td>
								<span>
									<input type="radio" name="pin-sync-status" id="sync-off" value="0" <?php checked($pin_sync_status, 0); ?>>
									<label for="sync-off">Off</label>
								</span>
								<span>
									<input type="radio" name="pin-sync-status" id="sync-on" value="1" <?php checked($pin_sync_status, 1); ?>>
									<label for="sync-on">On</label>
								</span>
								<p class="description" id="tagline-description">
									Turn this on to allow automatic syncing using WordPress's built-in scheduler (WP-Cron).
								</p>
								<?php if (1 == $pin_sync_status) : ?>
									<p class="description" id="tagline-description">
										Next sync: <?php echo (new Pinboard_Sync_Cron())->next_sync_time(); ?>
									</p>
								<?php endif; ?>
							</td>
						</tr>
					</tbody>
				</table>
				<p class="submit">
					<input type="submit" class="button button-primary" name="submit" value="Update options">
				</p>
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

		if ( isset( $_POST['pin-author'] ) ) {
			Pinboard_Sync_Options::set_pin_author( $_POST['pin-author'] );
		}

		if ( isset( $_POST['pin-sync-status'] ) ) {
			Pinboard_Sync_Options::set_pin_sync_status( $_POST['pin-sync-status'] );
		}
	}

}
