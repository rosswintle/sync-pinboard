<?php

/**
 * Registers the `pinboard_bookmark` post type.
 */
function pinboard_bookmark_init() {
	register_post_type( 'pinboard-bookmark', array(
		'labels'                => array(
			'name'                  => __( 'Pins', 'pinboard-sync' ),
			'singular_name'         => __( 'Pin', 'pinboard-sync' ),
			'all_items'             => __( 'All Pins', 'pinboard-sync' ),
			'archives'              => __( 'Pin Archives', 'pinboard-sync' ),
			'attributes'            => __( 'Pin Attributes', 'pinboard-sync' ),
			'insert_into_item'      => __( 'Insert into Pin', 'pinboard-sync' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Pin', 'pinboard-sync' ),
			'featured_image'        => _x( 'Featured Image', 'pinboard-bookmark', 'pinboard-sync' ),
			'set_featured_image'    => _x( 'Set featured image', 'pinboard-bookmark', 'pinboard-sync' ),
			'remove_featured_image' => _x( 'Remove featured image', 'pinboard-bookmark', 'pinboard-sync' ),
			'use_featured_image'    => _x( 'Use as featured image', 'pinboard-bookmark', 'pinboard-sync' ),
			'filter_items_list'     => __( 'Filter Pins list', 'pinboard-sync' ),
			'items_list_navigation' => __( 'Pins list navigation', 'pinboard-sync' ),
			'items_list'            => __( 'Pins list', 'pinboard-sync' ),
			'new_item'              => __( 'New Pin', 'pinboard-sync' ),
			'add_new'               => __( 'Add New', 'pinboard-sync' ),
			'add_new_item'          => __( 'Add New Pin', 'pinboard-sync' ),
			'edit_item'             => __( 'Edit Pin', 'pinboard-sync' ),
			'view_item'             => __( 'View Pin', 'pinboard-sync' ),
			'view_items'            => __( 'View Pins', 'pinboard-sync' ),
			'search_items'          => __( 'Search Pins', 'pinboard-sync' ),
			'not_found'             => __( 'No Pins found', 'pinboard-sync' ),
			'not_found_in_trash'    => __( 'No Pins found in trash', 'pinboard-sync' ),
			'parent_item_colon'     => __( 'Parent Pin:', 'pinboard-sync' ),
			'menu_name'             => __( 'Pins', 'pinboard-sync' ),
		),
		'public'                => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array( 'title', 'editor', 'author' ),
		'has_archive'           => true,
		'rewrite'               => true,
		'query_var'             => true,
		'menu_position'         => null,
		'menu_icon'             => 'dashicons-pressthis',
		'show_in_rest'          => true,
		'rest_base'             => 'pinboard-bookmark',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

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
		1  => sprintf( __( 'Pin updated. <a target="_blank" href="%s">View Pin</a>', 'pinboard-sync' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'pinboard-sync' ),
		3  => __( 'Custom field deleted.', 'pinboard-sync' ),
		4  => __( 'Pin updated.', 'pinboard-sync' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Pin restored to revision from %s', 'pinboard-sync' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Pin published. <a href="%s">View Pin</a>', 'pinboard-sync' ), esc_url( $permalink ) ),
		7  => __( 'Pin saved.', 'pinboard-sync' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Pin submitted. <a target="_blank" href="%s">Preview Pin</a>', 'pinboard-sync' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Pin scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Pin</a>', 'pinboard-sync' ),
		date_i18n( __( 'M j, Y @ G:i', 'pinboard-sync' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Pin draft updated. <a target="_blank" href="%s">Preview Pin</a>', 'pinboard-sync' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'pinboard_bookmark_updated_messages' );
