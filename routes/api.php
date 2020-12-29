<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('get-site-data',   ['uses' => 'SitesHelperController@getSiteData',   'as' => 'API_getSiteData'   ]);
Route::get('is_email_unique', ['uses' => 'SitesHelperController@isEmailUnique', 'as' => 'API_isEmailUnique' ]);
Route::get('is_phone_unique', ['uses' => 'SitesHelperController@isPhoneUnique', 'as' => 'API_isPhoneUnique' ]);
Route::get( 'processed',      ['uses' => 'ProcessedController@execute',         'as' => 'API_Processed'     ]);

Route::group( [ 'middleware' => 'api.auth' ], function(){

	// CloudFlare
	Route::group( [ 'prefix' => 'cf' ], function(){
		Route::get( 'verify',         [ 'uses' => 'CloudFlareController@verify',    'as' => 'CF_verify'    ] );
		Route::get( 'list',           [ 'uses' => 'CloudFlareController@list',      'as' => 'CF_list'      ] );
		Route::get( 'create_ns/{ns}', [ 'uses' => 'CloudFlareController@create_ns', 'as' => 'CF_create_ns' ] );
		Route::get( 'delete_ns/{ns}', [ 'uses' => 'CloudFlareController@delete_ns', 'as' => 'CF_delete_ns' ] );
	} );

} );

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
