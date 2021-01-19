<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CredentialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table( 'credentials' )->insert( [
            'id' => 1,
            'datacenter' => 'Oregon, Portland, USA',
            'ip' => '#f5365c',
            'dbname' => 'oregon_db',
            'dbusername' => 'oregon_user',
            'dbpassword' => '123123',
            'ssh' => 'secure shell',
            'created_at' => now(),
            'updated_at' => now(),
        ] );
    }
}
