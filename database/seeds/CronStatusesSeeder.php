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
			'name'   => 'sites_processing',
			'status' => 0,
		] );

		DB::table( 'cron_statuses' )->insert( [
			'name'   => 'sites_ssl_generating',
			'status' => 0,
		] );

		DB::table( 'cron_statuses' )->insert( [
			'name'   => 'sites_deleting',
			'status' => 0,
		] );

		DB::table( 'cron_statuses' )->insert( [
			'name'   => 'domain_processing',
			'status' => 0,
		] );

		DB::table( 'cron_statuses' )->insert( [
			'name'   => 'theme_updating',
			'status' => 0,
		] );

		DB::table( 'cron_statuses' )->insert( [
			'name'   => 'security_updating',
			'status' => 0,
		] );
	}
}
