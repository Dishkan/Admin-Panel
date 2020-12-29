<?php

namespace App\Http\Controllers;

use App\Site;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Requests\SiteRequest;

class SitesController extends Controller{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index( Site $sites ){

		return view( 'sites.index', [ 'sites' => $sites->all() ] );

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(){
		return view('sites.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
	 */

	public function store( SiteRequest $request ){
		// save data
			$input = $request->except( [ '_token' ] );

			Site::create( [
				'type'                    => $input['type'],
				'dealer_name'             => $input['dealer_name'],
				'lead_email'              => $input['lead_email'],
				'country'                 => $input['country'],
				'state'                   => $input['state'],
				'city'                    => $input['city'],
				'postal_code'             => $input['postal_code'],
				'dealer_number'           => $input['dealer_number'],
				'address'                 => $input['address'],
				'place_name'              => $input['place_name'],
				'place_id'                => $input['place_id'],
				'old_website_url'         => $input['old_website_url'],

				'old_website_favicon_src' => isset($request->site_icon_src) ? $request->site_icon_src->store('sitepictures', 'public') : null,
				'old_website_logo_src'    => isset ($request->logo_src) ? $request->logo_src->store('sitepictures', 'public') : null,

				'user_id'                 => Auth::id(),
				'processed'               => false,
			] );

			return redirect()->route( 'sites.index' )->withStatus( __( 'Site was added successfully.' ) );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( $id ){
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( Site $site ){

		return view('sites.edit', ['site' => $site]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( SiteRequest $request, Site $site ){
		$site->update( $request->merge( [
			'old_website_favicon_src' => $request->site_icon_src ? $request->site_icon_src->store( 'sitepictures', 'public' ) : null,
			'old_website_logo_src'    => $request->logo_src ? $request->logo_src->store( 'sitepictures', 'public' ) : null,
		] )->except( [
			//$request->except('_token'),
			$request->hasFile( 'site_icon_src' ) ? '' : 'old_website_favicon_src',
			$request->hasFile( 'logo_src' ) ? '' : 'old_website_logo_src',
		] ) );

		//$site->update($request->except('_token'));

		return redirect()->route('sites.index')->withStatus(__('Site information successfully updated.'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( Site $site ){

		$site->delete();

		return redirect()->route( 'sites.index' )->withStatus( __( 'Site successfully deleted.' ) );
	}

	public function get_not_created(){
		return Site::where( [ 'processed' => 0 ] )->get()->toJson();
	}
}
