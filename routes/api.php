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

Route::get('get-site-data',   ['uses' => 'SitesHelperController@getSiteData', 'as' => 'API_getSiteData' ]);
Route::get('is_email_unique', ['uses' => 'SitesHelperController@isEmailUnique', 'as' => 'API_isEmailUnique' ]);
Route::get('is_phone_unique', ['uses' => 'SitesHelperController@isPhoneUnique', 'as' => 'API_isPhoneUnique' ]);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
