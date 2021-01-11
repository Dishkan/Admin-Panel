<?php

use Illuminate\Database\Seeder;

class CronStatusesSeeder extends Seeder{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(){
		DB::table( 'cron_statuses' )->insert( [
			'name'   => 'vhost_and_folder_processing',
			'status' => 0,
		] );

		DB::table( 'cron_statuses' )->insert( [
			'name'   => 'files_processing',
			'status' => 0,
		] );

		DB::table( 'cron_statuses' )->insert( [
			'name'   => 'db_processing',
			'status' => 0,
		] );

		DB::table( 'cron_statuses' )->insert( [
			'name'   => 'certbot_processing',
			'status' => 0,
		] );

		DB::table( 'cron_statuses' )->insert( [
			'name'   => 'finalize_processing',
			'status' => 0,
		] );
	}
}
