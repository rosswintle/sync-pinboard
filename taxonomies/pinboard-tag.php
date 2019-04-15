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
			'name'                       => __( 'Pinboard Tags', 'pinboard-sync' ),
			'singular_name'              => _x( 'Pinboard Tag', 'taxonomy general name', 'pinboard-sync' ),
			'search_items'               => __( 'Search Pinboard Tags', 'pinboard-sync' ),
			'popular_items'              => __( 'Popular Pinboard Tags', 'pinboard-sync' ),
			'all_items'                  => __( 'All Pinboard Tags', 'pinboard-sync' ),
			'parent_item'                => __( 'Parent Pinboard Tag', 'pinboard-sync' ),
			'parent_item_colon'          => __( 'Parent Pinboard Tag:', 'pinboard-sync' ),
			'edit_item'                  => __( 'Edit Pinboard Tag', 'pinboard-sync' ),
			'update_item'                => __( 'Update Pinboard Tag', 'pinboard-sync' ),
			'view_item'                  => __( 'View Pinboard Tag', 'pinboard-sync' ),
			'add_new_item'               => __( 'Add New Pinboard Tag', 'pinboard-sync' ),
			'new_item_name'              => __( 'New Pinboard Tag', 'pinboard-sync' ),
			'separate_items_with_commas' => __( 'Separate Pinboard Tags with commas', 'pinboard-sync' ),
			'add_or_remove_items'        => __( 'Add or remove Pinboard Tags', 'pinboard-sync' ),
			'choose_from_most_used'      => __( 'Choose from the most used Pinboard Tags', 'pinboard-sync' ),
			'not_found'                  => __( 'No Pinboard Tags found.', 'pinboard-sync' ),
			'no_terms'                   => __( 'No Pinboard Tags', 'pinboard-sync' ),
			'menu_name'                  => __( 'Pinboard Tags', 'pinboard-sync' ),
			'items_list_navigation'      => __( 'Pinboard Tags list navigation', 'pinboard-sync' ),
			'items_list'                 => __( 'Pinboard Tags list', 'pinboard-sync' ),
			'most_used'                  => _x( 'Most Used', 'pinboard-tag', 'pinboard-sync' ),
			'back_to_items'              => __( '&larr; Back to Pinboard Tags', 'pinboard-sync' ),
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
		1 => __( 'Pinboard Tag added.', 'pinboard-sync' ),
		2 => __( 'Pinboard Tag deleted.', 'pinboard-sync' ),
		3 => __( 'Pinboard Tag updated.', 'pinboard-sync' ),
		4 => __( 'Pinboard Tag not added.', 'pinboard-sync' ),
		5 => __( 'Pinboard Tag not updated.', 'pinboard-sync' ),
		6 => __( 'Pinboard Tags deleted.', 'pinboard-sync' ),
	);

	return $messages;
}
add_filter( 'term_updated_messages', 'pinboard_tag_updated_messages' );
