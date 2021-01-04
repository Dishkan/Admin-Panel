<?php

namespace App\Http\Controllers;

use App\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Requests\SiteRequest;
use Illuminate\Support\Facades\Storage;

class SitesController extends Controller{

	public static $cron_name = 'sites_processing';

	/**
	 * Display a listing of the resource.
	 *
	 * @param Site $sites
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function index( Site $sites ){
		$user = \auth()->user();

		$sites = $user->isAdmin() || $user->isMember() ? $sites->paginate(10) : $sites->where(['user_id'=>$user->id])->get();

		return view( 'sites.index', [ 'sites' => $sites ] );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function create(){
		return view( 'sites.create' );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
	 */
	public function store( SiteRequest $request ){
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
			'old_website_favicon_src' => isset( $request->site_icon_src ) ? $request->site_icon_src->store( 'sitepictures', 'public' ) : null,
			'old_website_logo_src'    => isset ( $request->logo_src ) ? $request->logo_src->store( 'sitepictures', 'public' ) : null,
			'user_id'                 => Auth::id(),
			'processed'               => false,
		] );

		self::process();

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
	 * @param Site $site
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function edit( Site $site ){
		return view( 'sites.edit', [ 'site' => $site ] );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param SiteRequest $request
	 * @param Site        $site
	 *
	 * @return mixed
	 */
	public function update( SiteRequest $request, Site $site ){
		$site->update( $request->merge( [
			'old_website_favicon_src' => $request->site_icon_src ? $request->site_icon_src->store( 'sitepictures', 'public' ) : null,
			'old_website_logo_src'    => $request->logo_src ? $request->logo_src->store( 'sitepictures', 'public' ) : null,
		] )->except( [
			$request->hasFile( 'site_icon_src' ) ? '' : 'old_website_favicon_src',
			$request->hasFile( 'logo_src' ) ? '' : 'old_website_logo_src',
		] ) );
		
		return redirect()->route( 'sites.index' )->withStatus( __( 'Site information successfully updated.' ) );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Site $site
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function destroy( Site $site ){

		if( ( new Site )->icon() || ( new Site )->logo() ){
			Storage::disk( 'public' )->delete( [ $site->old_website_favicon_src, $site->old_website_logo_src ] );
		}
		else{
			dd( 'File does not exists.' );
		}

		$site->delete();

		return redirect()->route( 'sites.index' )->withStatus( __( 'Site successfully deleted.' ) );
	}



	/*
	 * Here we gonna work on creating sites logic
	 */

	/**
	 * Return Collection with not created sites on the server
	 *
	 * @return mixed
	 */
	public static function get_not_created(){
		return Site::where( [ 'processed' => 0 ] )->get();
	}

	/**
	 * Process not created sites
	 *
	 * @return mixed|void
	 */
	public static function process(){

		// Check if this cron already running
		// if( CronStatuses::is_run( self::$cron_name ) )
		// 	return;

		// Run
		CronStatuses::run( self::$cron_name );

		// get not processed/created
		$not_processed_sites = self::get_not_created();

		if( $not_processed_sites->isEmpty() ){
			CronStatuses::stop( self::$cron_name );
			return;
		}

		foreach( $not_processed_sites as $site ){

			// generate name from the old website url
			$exists_domains = CloudFlareController::list();
			$exists_domains = (array)json_decode( $exists_domains );
			$exists_domains = array_keys( $exists_domains );
			if( $site->old_website_url ){
				$old_web_site_url_parts = parse_url( $site->old_website_url );
				$host                   = $old_web_site_url_parts['host'];
				$base_name              = explode( '.', $host )[0];
			}
			// generate name from the dealer name
			else{
				$base_name = preg_replace( '~\s~', '-', $site->dealer_name );
			}

			$base_name = preg_replace( '~_~', '-', $base_name );
			$base_name = strtolower( trim( $base_name ) );
			$base_name = HelperController::generate_name_from_string( $base_name, $exists_domains );
			$res       = CloudFlareController::create_ns( $base_name );

			if( 'OK' !== $res['status'] ){
				continue;
			}
			$full_domain = $res['domain'];

			// ==============
			// DB
			// ==============

			// Get DB names from DB
			// if it's exists, add random chars to the end (abc only)
			// create database uses name `dg_auto_{$site->dealer_name}`
			// create user `u_dg_auto_{$site->dealer_name}`
			// grant privileges

			// return:
			//   DB name
			//   DB username
			//   DB password
			$db_host_object = new DBHostSSHController();
			$db_data        = $db_host_object->create_db_and_user( $base_name );


			// ==============
			// SITES1
			// ==============

			// Create folder
			// /var/www/dealer_sites_auto/{$folder_name}
			// Copy sites files from `/var/www/tmps/dealersite` to `/var/www/dealer_sites_auto/{$folder_name}`
			// Change `DB_NAME` | `DB_USER` | `DB_PASSWORD` in `/var/www/dealer_sites_auto/{$folder_name}/wp-config.php`
			// Create Apache config uses $folder_name
			// Run `certbot -d {$folder_name}`
			// Run `redis-cli -a r0CO7ki98903m4I FLUSHALL`

			// return:
			//   status OK|ERROR

			$sitesHostSSH  = new SitesHostSSHController();
			$document_root = $sitesHostSSH->create_folder( $base_name );

			// set domain to DB
			$site->update( [
				'website_url'   => $full_domain,
				'server_ip'     => CloudFlareController::get_server_ip(),
				'processed'     => 1,
				'db_name'       => $db_data['db_name'],
				'db_user'       => $db_data['db_user'],
				'db_pass'       => $db_data['db_pass'],
				'document_root' => $document_root,
			] );

			// TODO: remove me
			CronStatuses::stop( self::$cron_name );
		}

		// Stop
		CronStatuses::stop( self::$cron_name );
	}


}
