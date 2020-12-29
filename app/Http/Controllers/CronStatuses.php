<?php

namespace App\Http\Controllers;

use App\CronStatus;

class CronStatuses extends Controller{

	/**
	 * @param string $name
	 *
	 * @return mixed
	 */
	public static function get( string $name ){
		return CronStatus::where( [ 'name' => $name ] )->first();
	}

	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	public static function is_run( string $name ){
		$cron_status = self::get( $name );

		return boolval( $cron_status->status );
	}

	/**
	 * @param string $name
	 *
	 * @return void
	 */
	public static function run( string $name ){
		CronStatus::find( $name )->update( [ 'status' => 1 ] );
	}

	/**
	 * @param string $name
	 *
	 * @return void
	 */
	public static function stop( string $name ){
		CronStatus::find( $name )->update( [ 'status' => 0 ] );
	}

}
