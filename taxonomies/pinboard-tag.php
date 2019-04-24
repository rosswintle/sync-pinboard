<?php

/**
 * Registers the `pinboard_tag` taxonomy,
 * for use with 'pinboard-bookmark'.
 */
function pinboard_tag_init() {
	register_taxonomy( 'pinboard-tag', array( 'pinboard-bookmark' ), array(
		'hierarchical'      => false,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'show_admin_column' => false,
		'query_var'         => true,
		'rewrite'           => true,
		'capabilities'      => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts',
		),
		'labels'            => array(
			'name'                       => __( 'Pinboard Tags', 'sync-pinboard' ),
			'singular_name'              => _x( 'Pinboard Tag', 'taxonomy general name', 'sync-pinboard' ),
			'search_items'               => __( 'Search Pinboard Tags', 'sync-pinboard' ),
			'popular_items'              => __( 'Popular Pinboard Tags', 'sync-pinboard' ),
			'all_items'                  => __( 'All Pinboard Tags', 'sync-pinboard' ),
			'parent_item'                => __( 'Parent Pinboard Tag', 'sync-pinboard' ),
			'parent_item_colon'          => __( 'Parent Pinboard Tag:', 'sync-pinboard' ),
			'edit_item'                  => __( 'Edit Pinboard Tag', 'sync-pinboard' ),
			'update_item'                => __( 'Update Pinboard Tag', 'sync-pinboard' ),
			'view_item'                  => __( 'View Pinboard Tag', 'sync-pinboard' ),
			'add_new_item'               => __( 'Add New Pinboard Tag', 'sync-pinboard' ),
			'new_item_name'              => __( 'New Pinboard Tag', 'sync-pinboard' ),
			'separate_items_with_commas' => __( 'Separate Pinboard Tags with commas', 'sync-pinboard' ),
			'add_or_remove_items'        => __( 'Add or remove Pinboard Tags', 'sync-pinboard' ),
			'choose_from_most_used'      => __( 'Choose from the most used Pinboard Tags', 'sync-pinboard' ),
			'not_found'                  => __( 'No Pinboard Tags found.', 'sync-pinboard' ),
			'no_terms'                   => __( 'No Pinboard Tags', 'sync-pinboard' ),
			'menu_name'                  => __( 'Pinboard Tags', 'sync-pinboard' ),
			'items_list_navigation'      => __( 'Pinboard Tags list navigation', 'sync-pinboard' ),
			'items_list'                 => __( 'Pinboard Tags list', 'sync-pinboard' ),
			'most_used'                  => _x( 'Most Used', 'pinboard-tag', 'sync-pinboard' ),
			'back_to_items'              => __( '&larr; Back to Pinboard Tags', 'sync-pinboard' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'pinboard-tag',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'pinboard_tag_init' );

/**
 * Sets the post updated messages for the `pinboard_tag` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `pinboard_tag` taxonomy.
 */
function pinboard_tag_updated_messages( $messages ) {

	$messages['pinboard-tag'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Pinboard Tag added.', 'sync-pinboard' ),
		2 => __( 'Pinboard Tag deleted.', 'sync-pinboard' ),
		3 => __( 'Pinboard Tag updated.', 'sync-pinboard' ),
		4 => __( 'Pinboard Tag not added.', 'sync-pinboard' ),
		5 => __( 'Pinboard Tag not updated.', 'sync-pinboard' ),
		6 => __( 'Pinboard Tags deleted.', 'sync-pinboard' ),
	);

	return $messages;
}
add_filter( 'term_updated_messages', 'pinboard_tag_updated_messages' );
