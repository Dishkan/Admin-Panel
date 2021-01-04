<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table( 'sites' )->insert( [
		    'type'            => 'group',
		    'place_name'      => 'Lamborghini, CA',
		    'old_website_url' => 'https://lamborghini.com/',
		    'dealer_name'     => 'Lamborghini California Cars',
		    'lead_email'      => 'lambo@datgate.com',
		    'country'         => 'US',
		    'state'           => 'California',
		    'city'            => 'San-Francisco',
		    'postal_code'     => '94103',
		    'dealer_number'   => '1234567891',
		    'address'         => '1675 Howard St, San Francisco, CA 94103, USA',
		    'user_id'         => 7,
		    'created_at'      => now(),
		    'updated_at'      => now(),
	    ] );

	    DB::table( 'sites' )->insert( [
		    'type'            => 'oem',
		    'place_name'      => 'Bugatti, LA',
		    'old_website_url' => 'https://bugatti.com/',
		    'dealer_name'     => 'Bugatti Chiron Sport Cars',
		    'lead_email'      => 'Bugatti@datgate.com',
		    'country'         => 'US',
		    'state'           => 'California',
		    'city'            => 'Los Angeles',
		    'postal_code'     => '94103',
		    'dealer_number'   => '1234567892',
		    'address'         => '1675 Howard St, Los Angeles, LA 94103, USA',
		    'user_id'         => 8,
		    'created_at'      => now(),
		    'updated_at'      => now(),
	    ] );

	    DB::table( 'sites' )->insert( [
		    'type'            => 'independent',
		    'place_name'      => 'Mercedes, CA',
		    'old_website_url' => 'https://mercedes-benz.com/',
		    'dealer_name'     => 'Mercedes Benz ',
		    'lead_email'      => 'mercedes@datgate.com',
		    'country'         => 'US',
		    'state'           => 'California',
		    'city'            => 'Los Angeles',
		    'postal_code'     => '94103',
		    'dealer_number'   => '1234567893',
		    'address'         => '1675 Howard St, Los Angeles, LA 94103, US',
		    'user_id'         => 9,
		    'created_at'      => now(),
		    'updated_at'      => now(),
	    ] );

	    DB::table( 'sites' )->insert( [
		    'type'            => 'oem',
		    'place_name'      => 'BMW, OR',
		    'old_website_url' => 'https://bmwofportland.com/',
		    'dealer_name'     => 'BMW of Portland',
		    'lead_email'      => 'bmw@datgate.com',
		    'country'         => 'US',
		    'state'           => 'Oregon',
		    'city'            => 'Portland',
		    'postal_code'     => '94103',
		    'dealer_number'   => '1234567894',
		    'address'         => '777 5th Avenue, Portland, OR 94103, US',
		    'user_id'         => 9,
		    'created_at'      => now(),
		    'updated_at'      => now(),
	    ] );

    }
}
