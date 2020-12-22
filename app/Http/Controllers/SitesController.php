<?php

namespace App\Http\Controllers;

use App\Site;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function index( ) {
		if( 'wizard' ){
			return view( 'wizard.start' );
		}

		return abort( 404 );
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view( 'wizard.start' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

    auth()->login( $user );

    $site = Site::create( [
        'dealer_name'   => $input['dealer_name'],
        'lead_emails'    => $input['lead_emails'],
        'country'       => $input['country'],
        'state' => $input['state'],
        'city'    => $input['state'],
        'postal_code'     => $input['state'],
        'address'     => $input['address'],
        'type'     => $input['type'],
        'place_name'     => $input['place_name'],
        'place_id'     => $input['place_id'],
        'old_website_url'     => $input['old_website_url'],
        'user_id'     => Auth::id(),
        'created'     => true,

    ] );

    // Login with created user

    return redirect()->route('home');
}
    else
    return view( 'wizard.start' );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
