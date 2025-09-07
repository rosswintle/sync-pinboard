<?php

/**
 * Registers the `pinboard_bookmark` post type.
 */
function pinboard_bookmark_init() {
	$pinboard_bookmark_post_type_options = array(
		'labels'                => array(
			'name'                  => __( 'Pins', 'sync-pinboard' ),
			'singular_name'         => __( 'Pin', 'sync-pinboard' ),
			'all_items'             => __( 'All Pins', 'sync-pinboard' ),
			'archives'              => __( 'Pin Archives', 'sync-pinboard' ),
			'attributes'            => __( 'Pin Attributes', 'sync-pinboard' ),
			'insert_into_item'      => __( 'Insert into Pin', 'sync-pinboard' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Pin', 'sync-pinboard' ),
			'featured_image'        => _x( 'Featured Image', 'pinboard-bookmark', 'sync-pinboard' ),
			'set_featured_image'    => _x( 'Set featured image', 'pinboard-bookmark', 'sync-pinboard' ),
			'remove_featured_image' => _x( 'Remove featured image', 'pinboard-bookmark', 'sync-pinboard' ),
			'use_featured_image'    => _x( 'Use as featured image', 'pinboard-bookmark', 'sync-pinboard' ),
			'filter_items_list'     => __( 'Filter Pins list', 'sync-pinboard' ),
			'items_list_navigation' => __( 'Pins list navigation', 'sync-pinboard' ),
			'items_list'            => __( 'Pins list', 'sync-pinboard' ),
			'new_item'              => __( 'New Pin', 'sync-pinboard' ),
			'add_new'               => __( 'Add New', 'sync-pinboard' ),
			'add_new_item'          => __( 'Add New Pin', 'sync-pinboard' ),
			'edit_item'             => __( 'Edit Pin', 'sync-pinboard' ),
			'view_item'             => __( 'View Pin', 'sync-pinboard' ),
			'view_items'            => __( 'View Pins', 'sync-pinboard' ),
			'search_items'          => __( 'Search Pins', 'sync-pinboard' ),
			'not_found'             => __( 'No Pins found', 'sync-pinboard' ),
			'not_found_in_trash'    => __( 'No Pins found in trash', 'sync-pinboard' ),
			'parent_item_colon'     => __( 'Parent Pin:', 'sync-pinboard' ),
			'menu_name'             => __( 'Pins', 'sync-pinboard' ),
		),
		'public'                => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array( 'title', 'editor', 'author', 'custom-fields', 'excerpt', 'thumbnail' ),
		'has_archive'           => true,
		'rewrite'               => true,
		'exclude_from_search'   => true,
		'query_var'             => true,
		'menu_position'         => null,
		'menu_icon'             => 'dashicons-pressthis',
		'show_in_rest'          => true,
		'rest_base'             => 'pinboard-bookmark',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	);

	$pinboard_bookmark_post_type_options = apply_filters('sync-pinboard-bookmark-post-type-options', $pinboard_bookmark_post_type_options);

	register_post_type( 'pinboard-bookmark', $pinboard_bookmark_post_type_options );

}
add_action( 'init', 'pinboard_bookmark_init' );

/**
 * Sets the post updated messages for the `pinboard_bookmark` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `pinboard_bookmark` post type.
 */
function pinboard_bookmark_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['pinboard-bookmark'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Pin updated. <a target="_blank" href="%s">View Pin</a>', 'sync-pinboard' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'sync-pinboard' ),
		3  => __( 'Custom field deleted.', 'sync-pinboard' ),
		4  => __( 'Pin updated.', 'sync-pinboard' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Pin restored to revision from %s', 'sync-pinboard' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Pin published. <a href="%s">View Pin</a>', 'sync-pinboard' ), esc_url( $permalink ) ),
		7  => __( 'Pin saved.', 'sync-pinboard' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Pin submitted. <a target="_blank" href="%s">Preview Pin</a>', 'sync-pinboard' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Pin scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Pin</a>', 'sync-pinboard' ),
		date_i18n( __( 'M j, Y @ G:i', 'sync-pinboard' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Pin draft updated. <a target="_blank" href="%s">Preview Pin</a>', 'sync-pinboard' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'pinboard_bookmark_updated_messages' );
