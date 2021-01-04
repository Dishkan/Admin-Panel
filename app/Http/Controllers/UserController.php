<?php
/*

=========================================================
* Argon Dashboard PRO - v1.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard-pro-laravel
* Copyright 2018 Creative Tim (https://www.creative-tim.com) & UPDIVISION (https://www.updivision.com)

* Coded by www.creative-tim.com & www.updivision.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

*/

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Site;
use Exception;

class UserController extends Controller{
	public function __construct(){
		$this->authorizeResource( User::class );
	}

	/**
	 * Display a listing of the users
	 *
	 * @param \App\User $model
	 *
	 * @return \Illuminate\View\View
	 */
	public function index( User $model ){
		$this->authorize( 'manage-users', User::class );

		return view( 'users.index', [ 'users' => $model->with( 'role' )->paginate(10) ] );
	}

	/**
	 * Show the form for creating a new user
	 *
	 * @param \App\Role $model
	 *
	 * @return \Illuminate\View\View
	 */
	public function create( Role $model ){
		return view( 'users.create', [ 'roles' => $model->get( [ 'id', 'name' ] ) ] );
	}

	/**
	 * Store a newly created user in storage
	 *
	 * @param \App\Http\Requests\UserRequest $request
	 * @param \App\User                      $model
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store( UserRequest $request, User $model ){

		$model->create( $request->merge( [
			'picture'  => $request->profile_photo ? $request->profile_photo->store( 'profile', 'public' ) : null,
			'password' => Hash::make( $request->get( 'password' ) ),
		] )->except( [ '_token' ] ) );

		return redirect()->route( 'user.index' )->withStatus( __( 'User successfully created.' ) );
	}

	/**
	 * Show the form for editing the specified user
	 *
	 * @param \App\User $user
	 * @param \App\Role $model
	 *
	 * @return \Illuminate\View\View
	 */
	public function edit( User $user, Role $model ){
		return view( 'users.edit', [ 'user' => $user->load( 'role' ), 'roles' => $model->get( [ 'id', 'name' ] ) ] );
	}

	/**
	 * Update the specified user in storage
	 *
	 * @param \App\Http\Requests\UserRequest $request
	 * @param \App\User                      $user
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update( UserRequest $request, User $user ){
		$hasPassword = $request->get( 'password' );
		$user->update( $request->merge( [
			'picture'  => $request->profile_photo ? $request->profile_photo->store( 'profile', 'public' ) : $user->picture,
			'password' => Hash::make( $request->get( 'password' ) ),
		] )->except( [ $hasPassword ? '' : 'password' ] ) );
		return redirect()->route( 'user.index' )->withStatus( __( 'User successfully updated.' ) );
	}

	/**
	 * Remove the specified user from storage
	 *
	 * @param \App\User $user
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws Exception
	 */
	public function destroy( User $user ){

		if( ( new User )->profilePicture() ){
			Storage::disk( 'public' )->delete( $user->picture );
		}
		else{
			dd( 'File does not exists.' );
		}

		Site::where( 'user_id', $user->id )->delete();
		$user->delete();

		return redirect()->route( 'user.index' )->withStatus( __( 'User successfully deleted.' ) );
	}
}
