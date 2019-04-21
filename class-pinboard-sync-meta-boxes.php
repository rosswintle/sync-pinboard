<?php

namespace PinboardSync;

class Pinboard_Sync_Meta_Boxes {

	public function __construct() {

		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );

		/* Save post meta on the 'save_post' hook. */
		add_action( 'save_post', [ $this, 'save' ], 10, 2 );
	}

	public function add_meta_boxes() {
		add_meta_box( 'pinboard-sync-details', 'Pin details', [ $this, 'meta_box' ], 'pinboard-bookmark', 'normal', 'default' );
	}

	public function meta_box( $post ) {
		wp_nonce_field( basename( __FILE__ ), 'pinboard-sync-meta-nonce' );
		?>

		<p>
			<label for="pinboard-sync-url">URL</label>
			<br />
			<input class="widefat" type="url" name="pinboard-sync-url" id="pinboard-sync-url" value="<?php echo esc_attr( get_post_meta( $post->ID, 'url', true ) ); ?>" size="80" />
		</p>
		<?php
	}

	public function save( $post_id, $post ) {
		/* Verify the nonce before proceeding. */
		if ( ! isset( $_POST['pinboard-sync-meta-nonce'] ) || ! wp_verify_nonce( $_POST['pinboard-sync-meta-nonce'], basename( __FILE__ ) ) ) {
			return $post_id;
		}

		/* Get the post type object. */
		$post_type = get_post_type_object( $post->post_type );

	    // If this isn't a 'pinboard-bookmark' post, don't update it.
    	if ( 'pinboard-bookmark' != $post_type->name ) {
    		return;
    	}

		/* Check if the current user has permission to edit the post. */
		if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
			return $post_id;
		}

		/* Get the posted data and sanitize it for use as an HTML class. */
		$new_meta_value = ( isset( $_POST['pinboard-sync-url'] ) ? esc_url_raw( $_POST['pinboard-sync-url'] ) : '' );

		if ( empty( $new_meta_value ) ) {
			delete_post_meta( $post_id, 'url' );
		} else {
			update_post_meta( $post_id, 'url', $new_meta_value );
		}

	}

}
