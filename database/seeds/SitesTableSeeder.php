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
		    'place_name'      => 'Lamborgini, CA',
		    'old_website_url' => 'https://yandex.ru/',
		    'dealer_name'     => 'Lambo Aventador',
		    'lead_email'      => 'lambo@gmail.com',
		    'country'         => 'United States',
		    'state'           => 'California',
		    'city'            => 'San Francisco',
		    'postal_code'     => '3434',
		    'dealer_number'   => '998912766565',
		    'address'         => '1675 Howard St, San Francisco, CA 94103, USA',
		    'user_id'         => 7,
		    'created_at'      => now(),
		    'updated_at'      => now(),
	    ] );

	    DB::table( 'sites' )->insert( [
		    'type'            => 'oem',
		    'place_name'      => 'Buggati, LA',
		    'old_website_url' => 'https://google.com/',
		    'dealer_name'     => 'Buggati Chiron',
		    'lead_email'      => 'bugaga@gmail.com',
		    'country'         => 'United States',
		    'state'           => 'California',
		    'city'            => 'Los Angeles',
		    'postal_code'     => '1223',
		    'dealer_number'   => '998912766590',
		    'address'         => '1675 Howard St, Los Angeles, LA 94103, USA',
		    'user_id'         => 8,
		    'created_at'      => now(),
		    'updated_at'      => now(),
	    ] );

	    DB::table( 'sites' )->insert( [
		    'type'            => 'independent',
		    'place_name'      => 'Mercedes , CA',
		    'old_website_url' => 'https://facebook.com/',
		    'dealer_name'     => 'Mercedes Benz',
		    'lead_email'      => 'mers@gmail.com',
		    'country'         => 'United States',
		    'state'           => 'California',
		    'city'            => 'Los Angeles',
		    'postal_code'     => '7867',
		    'dealer_number'   => '998912766745',
		    'address'         => '1675 Howard St, Los Angeles, LA 94103, USA',
		    'user_id'         => 9,
		    'created_at'      => now(),
		    'updated_at'      => now(),
	    ] );

    }
}
