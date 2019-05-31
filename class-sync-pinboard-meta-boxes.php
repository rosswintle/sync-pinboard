<?php

namespace SyncPinboard;

class Sync_Pinboard_Meta_Boxes {

	public function __construct() {

		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );

		/* Save post meta on the 'save_post' hook. */
		add_action( 'save_post', [ $this, 'save' ], 10, 2 );

		register_meta( 'post', 'url', [
		    //'object_subtype' => 'pinboard-bookmark',
		    'type' => 'string',
    		'description' => 'The URL of the pin',
    		'single' => true,
    		'show_in_rest' => true,
    	]);

		register_rest_field('pinboard-bookmark', 'content_raw', [
			'get_callback' => function ($post_array) {
				return $post_array['content']['raw'];
			},
    		'schema' => [
    			'description' => 'The raw content',
    			'type'        => 'string',
    			],
    	]);

	}

	public function add_meta_boxes() {
		add_meta_box( 'sync-pinboard-details', 'Pin details', [ $this, 'meta_box' ], 'pinboard-bookmark', 'normal', 'default' );
	}

	public function meta_box( $post ) {
		wp_nonce_field( basename( __FILE__ ), 'sync-pinboard-meta-nonce' );
		?>

		<p>
			<label for="sync-pinboard-url">URL</label>
			<br />
			<input class="widefat" type="url" name="sync-pinboard-url" id="sync-pinboard-url" value="<?php echo esc_attr( get_post_meta( $post->ID, 'url', true ) ); ?>" size="80" />
		</p>
		<?php
	}

	public function save( $post_id, $post ) {
		/* Verify the nonce before proceeding. */
		if ( ! isset( $_POST['sync-pinboard-meta-nonce'] ) || ! wp_verify_nonce( $_POST['sync-pinboard-meta-nonce'], basename( __FILE__ ) ) ) {
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
		$new_meta_value = ( isset( $_POST['sync-pinboard-url'] ) ? esc_url_raw( $_POST['sync-pinboard-url'] ) : '' );

		if ( empty( $new_meta_value ) ) {
			delete_post_meta( $post_id, 'url' );
		} else {
			update_post_meta( $post_id, 'url', $new_meta_value );
		}

	}

}
