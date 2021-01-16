<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run(){
		DB::statement( 'SET FOREIGN_KEY_CHECKS=0' );

		DB::table( 'roles' )->truncate();
		DB::table( 'users' )->truncate();
		DB::table( 'tags' )->truncate();
		DB::table( 'item_tag' )->truncate();
		DB::table( 'categories' )->truncate();
		DB::table( 'items' )->truncate();
		DB::table( 'sites' )->truncate();
		DB::table( 'autosites' )->truncate();

		$this->call( [
			RolesTableSeeder::class,
			UsersTableSeeder::class,
			SitesTableSeeder::class,
			TagsTableSeeder::class,
			CategoriesTableSeeder::class,
			ItemsTableSeeder::class,
			CronStatusesSeeder::class,
			AutoSitesSeeder::class,
		] );

		DB::statement( 'SET FOREIGN_KEY_CHECKS=1' );
	}
}
