<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(){
		factory( App\User::class )->create( [
			'id'          => 1,
			'firstname'   => 'Anton',
			'lastname'    => 'Kulyk',
			'phonenumber' => '1234567891',
			'email'       => 'anton@datgate.com',
			'password'    => Hash::make( '123456' ),
			'role_id'     => 1,
		] );

		factory( App\User::class )->create( [
			'id'          => 2,
			'firstname'   => 'Hirad',
			'lastname'    => 'Ahranjani',
			'phonenumber' => '1234567891',
			'email'       => 'hirad@datgate.com',
			'password'    => Hash::make( '123456' ),
			'role_id'     => 1,
		] );

		factory( App\User::class )->create( [
			'id'          => 3,
			'firstname'   => 'Sega',
			'lastname'    => 'Mytkin',
			'phonenumber' => '1234567891',
			'email'       => 'sega@datgate.com',
			'password'    => Hash::make( '123456' ),
			'role_id'     => 1,
		] );

		factory( App\User::class )->create( [
			'id'          => 4,
			'firstname'   => 'Creator',
			'lastname'    => '',
			'phonenumber' => '1234567891',
			'email'       => 'creator@nowui.com',
			'password'    => Hash::make( '123456' ),
			'role_id'     => 2,
		] );

		factory( App\User::class )->create( [
			'id'          => 5,
			'firstname'   => 'Dealer user',
			'lastname'    => '',
			'phonenumber' => '1234567891',
			'email'       => 'rth@datgate.com',
			'password'    => Hash::make( '123456' ),
			'role_id'     => 3,
		] );
		
		factory( App\User::class )->create( [
			'id'          => 6,
			'firstname'   => 'Dishkan',
			'lastname'    => 'Khudoyarov',
			'phonenumber' => '1234567891',
			'email'       => 'dishkan@datgate.com',
			'password'    => Hash::make( '123456' ),
			'role_id'     => 1,
		] );
	}
}
