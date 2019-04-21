<?php

namespace PinboardSync;

use PinboardSync\Pinboard_Sync_Core;

class Pinboard_Sync_Cron {

	public $hook_name = 'pinboard_sync_cron_hook';

	public function __construct() {
		add_filter( 'cron_schedules', [ $this, 'pinboard_sync_cron_interval' ] );
		add_action( $this->hook_name, [ $this, 'sync' ] );

		if ( ! wp_next_scheduled( $this->hook_name ) ) {
 			wp_schedule_event( time(), 'fifteen_minutes', $this->hook_name );
		}

		add_action( 'pinboard_sync_deactivate', [ $this, 'remove_cron' ] );
 	}

	public function pinboard_sync_cron_interval( $schedules ) {
    	$schedules['fifteen_minutes'] = [
        	'interval' => 15 * 60,
        	'display'  => esc_html__( 'Every Fifteen Minutes' ),
    	];

    	return $schedules;
    }

	public function remove_cron() {
		echo "Removing cron";
		$timestamp = wp_next_scheduled( $this->hook_name );
   		wp_unschedule_event( $timestamp, $this->hook_name );
	}

    public function sync() {
    	$core = new Pinboard_Sync_Core();
    	$core->sync();
    }

}

