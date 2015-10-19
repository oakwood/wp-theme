<?php

namespace Oakwood;

/*
|--------------------------------------------------------------------------
| CLASS AbstractCron
|--------------------------------------------------------------------------
*/

abstract class AbstractCron {

	use Traits\Hooks {
		Traits\Hooks::__construct as __hooks_construct;
	}

	/*
	|--------------------------------------------------------------------------
	| SETTINGS
	|--------------------------------------------------------------------------
	*/

	protected $filters = array(
		'cron_schedules'
	);

	protected $actions = array(
		'clear_transients' => 'daily_schedule'
	);

	protected $schedules = array(
		'15min',
		'hourly',
		'twicedaily',
		'daily'
	);

	public function __construct() {
		foreach ( $this->schedules as $schedule ) {
			if ( ! wp_next_scheduled( $schedule . '_schedule' ) ) {
				wp_schedule_event( time(), $schedule, $schedule . '_schedule' );
			}
		}

		$this->__hooks_construct();
	}

	/*
	|--------------------------------------------------------------------------
	| FILTERS
	|--------------------------------------------------------------------------
	*/

	public function cron_schedules( $schedules ) {
		$schedules['15min'] = array(
			'interval' => 60 * 15,
			'display'  => __( 'Every 15 minutes' )
		);

		return $schedules;
	}

	/*
	|--------------------------------------------------------------------------
	| ACTIONS
	|--------------------------------------------------------------------------
	*/

	public function clear_transients() {
		global $wpdb;

		$time = strtotime( '- 7 days' );
		
		if ( $time > time() || $time < 1 )
			return false;

		$transients = $wpdb->get_col( $wpdb->prepare( "SELECT REPLACE( option_name, '_transient_timeout_', '' ) AS transient_name FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_%%' AND option_value < %s", $time ) );
		
		foreach( $transients as $transient_name ) {
			get_transient( $transient_name );
		}
	}

}
