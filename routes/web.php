<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get( '/', function(){
	return redirect()->route( 'login' );
} );

Auth::routes();
Route::get( '/home', 'HomeController@index' )->name( 'home' );

Route::resource( 'wizard',  'SitesController'  );


Route::get( 'pricing', 'PageController@pricing' )->name( 'page.pricing' );
Route::get( 'lock',    'PageController@lock'    )->name( 'page.lock'    );
Route::get( 'error', [ 'as' => 'page.error', 'uses' => 'PageController@error' ] );

Route::group( [ 'middleware' => 'auth' ], function(){
	Route::resource( 'user',     'UserController'     );
	Route::resource( 'category', 'CategoryController' );
	Route::resource( 'tag',      'TagController'      );
	Route::resource( 'item',     'ItemController'     );
	Route::resource( 'role',     'RoleController'     );

	Route::get( 'profile',          [ 'as' => 'profile.edit',     'uses' => 'ProfileController@edit'     ] );
	Route::put( 'profile',          [ 'as' => 'profile.update',   'uses' => 'ProfileController@update'   ] );
	Route::put( 'profile/password', [ 'as' => 'profile.password', 'uses' => 'ProfileController@password' ] );

	Route::get( '{page}', [ 'as' => 'page.index', 'uses' => 'PageController@index' ] );

	// CloudFlare
	Route::group( [ 'prefix' => 'cf' ], function(){
		Route::get( 'verify',         [ 'uses' => 'CloudFlareController@verify',    'as' => 'CF_verify'    ] );
		Route::get( 'list',           [ 'uses' => 'CloudFlareController@list',      'as' => 'CF_list'      ] );
		Route::get( 'create_ns/{ns}', [ 'uses' => 'CloudFlareController@create_ns', 'as' => 'CF_create_ns' ] );
		Route::get( 'delete_ns/{ns}', [ 'uses' => 'CloudFlareController@delete_ns', 'as' => 'CF_delete_ns' ] );
	} );
} );
