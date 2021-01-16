<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AutoSitesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table( 'autosites' )->insert( [
		    'type'            => 'group',
		    'place_name'      => 'US, Portland',
		    'old_website_url' => 'https://lamborghini.com/',
		    'dealer_number'   => '4564879465',
		    'dealer_email'    => 'dealer.10@mail.ru',
		    'make'            => 'Bentley',
		    'created_at'      => now(),
		    'updated_at'      => now(),
	    ] );
    }
}
