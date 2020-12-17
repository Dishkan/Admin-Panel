<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table( 'roles' )->insert( [
		    'id'          => 1,
		    'name'        => 'Admin',
		    'description' => 'This is the administration role',
		    'created_at'  => now(),
		    'updated_at'  => now(),
	    ] );

	    DB::table( 'roles' )->insert( [
		    'id'          => 2,
		    'name'        => 'Creator',
		    'description' => 'This is the creator role',
		    'created_at'  => now(),
		    'updated_at'  => now(),
	    ] );

	    DB::table( 'roles' )->insert( [
		    'id'          => 3,
		    'name'        => 'Dealer',
		    'description' => 'This is the dealer role',
		    'created_at'  => now(),
		    'updated_at'  => now(),
	    ] );
    }
}
