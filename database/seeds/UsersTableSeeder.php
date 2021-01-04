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
			'phonenumber' => '1234567899',
			'email'       => 'anton@datgate.com',
			'password'    => Hash::make( '123456' ),
			'role_id'     => 1,
		] );

		factory( App\User::class )->create( [
			'id'          => 2,
			'firstname'   => 'Hirad',
			'lastname'    => 'Ahranjani',
			'phonenumber' => '1234567898',
			'email'       => 'hirad@datgate.com',
			'password'    => Hash::make( '123456' ),
			'role_id'     => 1,
		] );

		factory( App\User::class )->create( [
			'id'          => 3,
			'firstname'   => 'Sega',
			'lastname'    => 'Mytkin',
			'phonenumber' => '1234567897',
			'email'       => 'sega@datgate.com',
			'password'    => Hash::make( '123456' ),
			'role_id'     => 1,
		] );

		factory( App\User::class )->create( [
			'id'          => 4,
			'firstname'   => 'Creator',
			'lastname'    => '',
			'phonenumber' => '1234567896',
			'email'       => 'creator@nowui.com',
			'password'    => Hash::make( '123456' ),
			'role_id'     => 2,
		] );

		factory( App\User::class )->create( [
			'id'          => 5,
			'firstname'   => 'Dealer user',
			'lastname'    => '',
			'phonenumber' => '1234567895',
			'email'       => 'rth@datgate.com',
			'password'    => Hash::make( '123456' ),
			'role_id'     => 3,
		] );

		factory( App\User::class )->create( [
			'id'          => 6,
			'firstname'   => 'Dishkan',
			'lastname'    => 'Khudoyarov',
			'phonenumber' => '1234567894',
			'email'       => 'dishkan@datgate.com',
			'password'    => Hash::make( '123456' ),
			'role_id'     => 1,
		] );

		factory( App\User::class )->create( [
			'id'          => 7,
			'firstname'   => 'TestLambo',
			'lastname'    => 'LastLambo',
			'phonenumber' => '1234567852',
			'email'       => 'lambo@datgate.com',
			'password'    => Hash::make( '123456' ),
			'role_id'     => 3,
		] );

		factory( App\User::class )->create( [
			'id'          => 8,
			'firstname'   => 'TestBugatti',
			'lastname'    => 'LastBugatti',
			'phonenumber' => '1234567821',
			'email'       => 'bugaga@datgate.com',
			'password'    => Hash::make( '123456' ),
			'role_id'     => 3,
		] );

		factory( App\User::class )->create( [
			'id'          => 9,
			'firstname'   => 'TestMercedes and BMW',
			'lastname'    => 'LastMercedes and BMW',
			'phonenumber' => '123456784320',
			'email'       => 'mercedes@datgate.com',
			'password'    => Hash::make( '123456' ),
			'role_id'     => 3,
		] );
	}
}
