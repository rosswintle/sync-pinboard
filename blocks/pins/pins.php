<?php

namespace SyncPinboard\Blocks;

class Pins
{
	public function __construct() {

    	wp_register_script(
        	'sync-pinboard-pins-block',
        	plugins_url( 'block.js', __FILE__ ),
        	array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components' )
    	);

    	register_block_type( 'sync-pinboard/pins', array(
        	'editor_script' => 'sync-pinboard-pins-block',
    	) );

	}

}
