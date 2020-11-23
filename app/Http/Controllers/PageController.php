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
			$input = $request->except('_token');

			exit('<pre>' . print_r($input, 1) . '</pre>'); # DEBUG OUT

		}
		else{

			return view( 'wizard.start' );
		}
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
