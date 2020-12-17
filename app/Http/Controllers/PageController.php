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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller{
	/**
	 * Display the pricing page
	 *
	 * @return \Illuminate\View\View
	 */
	public function pricing(){
		return view( 'pages.pricing' );
	}

	/**
	 * Display the lock page
	 *
	 * @return \Illuminate\View\View
	 */
	public function lock(){
		return view( 'pages.lock' );
	}

	/**
	 * Display dealer WIZARD page
	 */
	public function wizard( Request $request ){

		// save data
		if( $request->isMethod('POST') ){
			$input = $request->except(['_token','finish']);

			// Register New User and Site, and add user id to the site
			$user_data = array_filter( $input, function( $key ){
				return 'person_' === substr( $key, 0, 7 );
			}, ARRAY_FILTER_USE_KEY);

			// Prepare array
			$_user_data = [];
			foreach( $user_data as $key => $val ){
				$new_key                = substr( $key, 7 );
				$_user_data[ $new_key ] = $val;
			}
			$user_data = $_user_data;

			$user = User::create( [
				'firstname'   => $user_data['firstname'],
				'lastname'    => $user_data['lastname'],
				'email'       => $user_data['email'],
				'phonenumber' => $user_data['phonenumber'],
				'password'    => Hash::make( $user_data['password'] ),
				'role_id'     => 3 // Dealer role id
			] );

			// Login with created user
			auth()->login( $user );

			return redirect()->route('home');
		}
		else
			return view( 'wizard.start' );
	}

	/**
	 * Display all the static pages when authenticated
	 *
	 * @param string $page
	 *
	 * @return \Illuminate\View\View
	 */
	public function index( string $page ){
		if( 'wizard' === $page ){
			return view( 'wizard.start' );
		}
		elseif( view()->exists( "pages.{$page}" ) ){
			return view( "pages.{$page}" );
		}
		elseif( view()->exists( "pages.forms.{$page}" ) ){
			return view( "pages.forms.{$page}" );
		}
		elseif( view()->exists( "pages.tables.{$page}" ) ){
			return view( "pages.tables.{$page}" );
		}
		elseif( view()->exists( "pages.maps.{$page}" ) ){
			return view( "pages.maps.{$page}" );
		}
		elseif( view()->exists( "pages.laravel-examples.{$page}" ) ){
			return view( "pages.laravel-examples.{$page}" );
		}

		return abort( 404 );
	}
}
