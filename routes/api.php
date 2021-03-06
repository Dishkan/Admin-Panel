<?php

use Illuminate\Http\Request;
use App\Http\Controllers\SitewideSearchController;

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

// ONLY FOR TESTS
Route::get('test', ['uses' => 'HelperController@test' ]);

// TWILIO
Route::group( [ 'prefix' => 'twilio' ], function(){
	Route::get( 'voice-xml/{code}', [ 'uses' => 'TwilioController@voiceXML', 'as' => 'Twilio_voice_code_xml' ] );
	Route::match( [ 'GET', 'POST' ], 'voice-xml/{code}', [
		'uses' => 'TwilioController@voiceXML',
		'as'   => 'Twilio_voice_code_xml',
	] );
} );

Route::get('get-site-data',   ['uses' => 'SitesHelperController@getSiteData',   'as' => 'API_getSiteData'   ]);
Route::get('is_email_unique', ['uses' => 'SitesHelperController@isEmailUnique', 'as' => 'API_isEmailUnique' ]);
Route::get('isPassUnique', ['uses' => 'SitesHelperController@isPassUnique', 'as' => 'API_isPassUnique' ]);
Route::get('site-status',     ['uses' => 'SitesHelperController@siteStatus',    'as' => 'API_siteStatus'    ]);

Route::group( [ 'middleware' => 'api.auth' ], function(){

	// Sites
	Route::group( [ 'prefix' => 'sites' ], function(){
		Route::get( 'process', ['uses' => 'SitesController@process','as' => 'API_Sites_process'] );

		// For Builder
		Route::get( 'data', ['uses' => 'SitesController@site_data_by_id','as' => 'API_Sites_get_site_data_by_id'] );
	} );

	// CloudFlare
	Route::group( [ 'prefix' => 'cf' ], function(){
		Route::get( 'verify',         [ 'uses' => 'CloudFlareController@verify',    'as' => 'API_CF_verify'    ] );
		Route::get( 'list',           [ 'uses' => 'CloudFlareController@list',      'as' => 'API_CF_list'      ] );
		Route::get( 'create_ns/{ns}', [ 'uses' => 'CloudFlareController@create_ns', 'as' => 'API_CF_create_ns' ] );
		Route::get( 'delete_ns/{ns}', [ 'uses' => 'CloudFlareController@delete_ns', 'as' => 'API_CF_delete_ns' ] );
	} );

} );

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
