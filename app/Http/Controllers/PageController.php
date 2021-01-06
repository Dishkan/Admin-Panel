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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Site;
use Illuminate\Support\Facades\DB;

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
		if( $request->isMethod( 'POST' ) ){
			$input = $request->except( [ '_token', 'finish' ] );

			// Register New User and Site, and add user id to the site
			$user_data = array_filter( $input, function( $key ){
				return 'person_' === substr( $key, 0, 7 );
			}, ARRAY_FILTER_USE_KEY );

			// Prepare array
			$_user_data = [];
			foreach( $user_data as $key => $val ){
				$new_key                = substr( $key, 7 );
				$_user_data[ $new_key ] = $val;
			}
			$user_data = $_user_data;

			$validator = Validator::make( $input, [
				'person_firstname'   => 'required|max:255',
				'person_lastname'    => 'required|max:255',
				'person_email'       => 'required|email|max:255|unique:users,email',
				'person_phonenumber' => [
					'required',
					//'regex: /((\(\d{3}\) ?)|(\d{3}-))?\d{3}-\d{4}/',
					'unique:users,phonenumber',
				],
				'type'               => 'required',
				'dealer_name'        => 'required|max:255',
				'lead_emails'        => 'required|email|max:255|unique:sites,lead_email',
				'country'            => 'required|max:255',
				'state'              => 'required|max:255',
				'city'               => 'required|max:255',
				'postal_code'        => 'required',
				'dealer_number'      => [
					'required',
					//'regex: /((\(\d{3}\) ?)|(\d{3}-))?\d{3}-\d{4}/',
					'unique:sites,dealer_number',
				],
				'address'            => 'required|max:255',
				'place_name'         => 'max:255',
				'old_website_url'    => 'required|max:255',
			] );

			$steps_inputs = [
				'type' => [
					'type'
				],
				'account' => [
					'dealer_name',
					'place_name',
					'lead_emails',
					'old_website_url',
					'country',
					'state',
					'city',
					'postal_code',
					'address',
					'phonenumber'
				],
				'finish' => [
					'person_firstname',
					'person_lastname',
					'person_email',
					'person_phonenumber'
				]
			];

			if( $validator->fails() ){
				$not_valid_fields = array_keys( $validator->messages()->get( '*' ) );

				foreach( $steps_inputs as $step_name => $fields ){
					foreach( $fields as $field ){
						if( in_array( $field, $not_valid_fields ) ){
							$activeStep = $step_name;
							break 2;
						}
					}
				}
			}
			$activeStep = $activeStep ?? 'type';


			setcookie( 'activeStep', $activeStep );


			if( $validator->fails() ){
				return back()->withInput()->withErrors( $validator );
			}

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

			Site::create( [
				'type'                    => $input['type'],
				'dealer_name'             => $input['dealer_name'],
				'lead_email'              => $input['lead_emails'],
				'country'                 => $input['country'],
				'state'                   => $input['state'],
				'city'                    => $input['city'],
				'postal_code'             => $input['postal_code'],
				'dealer_number'           => $input['dealer_number'],
				'address'                 => $input['address'],
				'place_name'              => $input['place_name'],
				'place_id'                => $input['place_id'],
				'old_website_url'         => $input['old_website_url'],
				'old_website_favicon_src' => $input['site_icon_src'],
				'old_website_logo_src'    => $input['logo_src'],
				'user_id'                 => Auth::id(),
				'processed'               => false,
			] );

			return redirect()->route( 'home' );
		}

		else
			return view( 'wizard.start' );

	}

	function search(Request $request)
	{
		if($request->ajax())
		{
			$output = '';
			$query = $request->get('query');
			if($query)
			{
				$data = DB::table('users')->where('firstname', 'like', '%'.$query.'%')
					->orWhere('lastname', 'like', '%'.$query.'%')
					->orWhere('phonenumber', 'like', '%'.$query.'%')
					->orWhere('email', 'like', '%'.$query.'%')
					->get();

			}
			else
			{
				$data = User::orderBy('id', 'firstname')
					->get();
			}
			$total_row = $data->count();
			if($total_row > 0)
			{
				foreach($data as $row)
				{
					$output .= '
        <tr>
         <td>' . $row->picture . '</td>
         <td>' . $row->firstname . '</td>
         <td>' . $row->email . '</td>
         <td>' . $row->role->name . '</td>
         <td>' . $row->created_at . '</td>
        </tr>
        ';
				}
			}
			else
			{
				$output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
			}
			$data = array(
				'table_data'  => $output,
			);

			echo json_encode($data);
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
