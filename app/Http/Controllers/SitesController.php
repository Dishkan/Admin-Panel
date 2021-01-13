<?php

namespace App\Http\Controllers;

use App\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Requests\SiteRequest;
use Illuminate\Support\Facades\Storage;
use App\User;


class SitesController extends Controller{

	public static $tz    = 'Europe/Kiev';
	public static $debug = false;

	/**
	 * Display a listing of the resource.
	 *
	 * @param Site $sites
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function index( Site $sites ){
		$user = \auth()->user();

		$sites = $user->isMember() ? $sites->where( ( [ 'user_id' => $user->id ] ) )->paginate( 10 )
			: $sites->paginate( 10 );

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

		$site->update(['to_remove' => 1]);

		return redirect()->route( 'sites.index' )->withStatus( __( 'Site successfully deleted.' ) );
	}

	/**
	 * @param Request $request
	 *
	 * @return false|string
	 */
	public function site_data_by_id( Request $request ){
		$site_data = Site::where( ['id'=>$request->id] )->first();

		if( is_null( $site_data ) ){
			return json_encode( ['site_not_exists'] );
		}

		$site_data = $site_data->toArray();

		$user_id = $site_data['user_id'];
		unset( $site_data['user_id'] );

		$user_data = User::where(['id'=>$user_id])->first()->toArray();
		$site_data['user'] = $user_data;

		return json_encode( $site_data, JSON_UNESCAPED_SLASHES );
	}



	/*
	 * Here we gonna work on creating sites logic
	 */

	/**
	 * Process not created sites with status 0 and set 1
	 * DO:
	 *     create empty site folder
	 *     create Apache Virtual hosts files for 80 and 443
	 *
	 * @return mixed|void
	 */
	public static function process_just_created(){
		$cron_name      = 'vhost_and_folder_processing';
		$process_status = 0;
		$done_status    = 1;

// Check if this cron already running
// if( CronStatuses::is_run( $cron_name ) )
//     return;

		// Run
		CronStatuses::run( $cron_name );

		// get just created
		$sites = Site::where( [ 'status'=>$process_status, 'to_remove'=>0, 'removed'=>0, 'creates_error'=>0 ] )->get();

		if( $sites->isEmpty() ){
			CronStatuses::stop( $cron_name );
			return;
		}

		$db_host_object = new DBHostController();
		$sitesHostSSH   = new SitesHostSSHController();
		date_default_timezone_set( self::$tz );

		$result = $cur_log = [];
		foreach( $sites as $site ){
			// clean current log
			$cur_log = [];

			// generate name from the old website url
			if( $site->old_website_url ){
				$old_web_site_url_parts = parse_url( $site->old_website_url );
				$host                   = $old_web_site_url_parts['host'];
				$base_name              = explode( '.', $host )[0];

				// log
				$cur_log['base_name__info'] = "base_name created from old_website_url: [{$site->old_website_url}]";
			}
			// generate name from the dealer name
			else{
				$base_name = preg_replace( '~\s~', '-', $site->dealer_name );

				// log
				$cur_log['base_name__info'] = "base_name created from dealer_name: [{$site->dealer_name}]";
			}

			$base_name = preg_replace( '~_~', '-', $base_name );
			$base_name = strtolower( trim( $base_name ) );

			// log
			$cur_log['base_name'] = $base_name;

			// ==============
			// NS
			// ==============
			$exists_domains = CloudFlareController::list();
			$exists_domains = (array)json_decode( $exists_domains );
			$exists_domains = array_keys( $exists_domains );
			$sub_domain     = HelperController::generate_name_from_string( $base_name, $exists_domains );
			$res            = CloudFlareController::create_ns( $sub_domain );
			if( 'OK' !== $res['status'] ){
				$res[] = 'Can not create subdomain';
				$site->update( [
					'last_error'    => json_encode( $res, JSON_UNESCAPED_SLASHES ),
					'creates_error' => 1,
				] );
				continue;
			}
			$domain = $res['domain'];


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
			$db_data = $db_host_object->create_db_and_user( $base_name );

			// log
			$cur_log['db_data__info'] = $db_data;

			// ==============
			// SITES1
			// ==============
			// Create folder
			// /var/www/dealer_sites_auto/{$folder_name}

			// return:
			//   status OK|ERROR
			$document_root = $sitesHostSSH->create_folder( $domain );

			// log
			$cur_log['document_root'] = $document_root;

			// Generate and save local VHost file 80 port
			$file_content  = $sitesHostSSH->get_vhost_template_file_content();
			$vhost_content = strtr( $file_content, [
				'{{{REMOTE_ADDR}}}'  => $_SERVER['REMOTE_ADDR'],
				'{{{CUR_DATETIME}}}' => date( 'd-m-Y H:i:s' ),
				'{{{TIMEZONE}}}'     => self::$tz,
				'{{{DOMAIN}}}'       => $domain,
				'{{{DOC_ROOT}}}'     => $document_root,
			] );
			$vhost_filename = "999-{$domain}.conf";
			Storage::disk('vhosts')->put( $vhost_filename, $vhost_content );

			// Generate and save local VHost file with SSL 443 port
			$file_ssl_content  = $sitesHostSSH->get_vhost_template_file_ssl_content();
			$vhost_ssl_content = strtr( $file_ssl_content, [
				'{{{REMOTE_ADDR}}}'  => $_SERVER['REMOTE_ADDR'],
				'{{{CUR_DATETIME}}}' => date( 'd-m-Y H:i:s' ),
				'{{{TIMEZONE}}}'     => self::$tz,
				'{{{DOMAIN}}}'       => $domain,
				'{{{DOC_ROOT}}}'     => $document_root,
			] );
			$vhost_ssl_filename = "999-{$domain}-le-ssl.conf";
			Storage::disk('vhosts')->put( $vhost_ssl_filename, $vhost_ssl_content );

			// log
			$cur_log['vhost_file_content']     = $vhost_content;
			$cur_log['vhost_file_ssl_content'] = $vhost_ssl_content;

			// Send local file to a remote server and generate SSL
			$is_vhost_file_send     = $sitesHostSSH->ssh_send_vhost_file( $vhost_filename );
			$is_vhost_file_ssl_send = $sitesHostSSH->ssh_send_vhost_file( $vhost_ssl_filename );

			// log
			$cur_log['is_vhost_file_send']     = $is_vhost_file_send     ? 'Yes' : 'No';
			$cur_log['is_vhost_file_ssl_send'] = $is_vhost_file_ssl_send ? 'Yes' : 'No';

			$site_update = [
				'status'             => $done_status,
				'base_name'          => $base_name,
				'website_url'        => $res['domain'],
				'server_ip'          => CloudFlareController::get_server_ip(),
				'db_name'            => $db_data['db_name'],
				'db_user'            => $db_data['db_user'],
				'db_pass'            => $db_data['db_pass'],
				'document_root'      => $document_root,
				'vhost_filename'     => $vhost_filename,
				'vhost_ssl_filename' => $vhost_ssl_filename,
			];

			// set domain to DB
			$site->update( $site_update );

			$cur_log['site_update'] = $site_update;

			$result[] = $cur_log;
		}

		// Stop
		CronStatuses::stop( $cron_name );

		dd( $result );
	}

	/**
	 * Process sites with status 1 and set 2
	 * DO:
	 *     copy sites files
	 *     replace DB credentials in wp-config.php
	 */
	public static function process_without_files(){
		$cron_name      = 'files_processing';
		$process_status = 1;
		$done_status    = 2;

//if( CronStatuses::is_run( $cron_name ) )
//	return;

		CronStatuses::run( $cron_name );

		$sites = Site::where( [ 'status'=>$process_status, 'to_remove'=>0, 'removed'=>0, 'creates_error'=>0 ] )->get();

		if( $sites->isEmpty() ){
			CronStatuses::stop( $cron_name );
			return;
		}

		$sitesHostSSH = new SitesHostSSHController();
		date_default_timezone_set( self::$tz );
		foreach( $sites as $site ){

			if( !$sitesHostSSH->copy_files_from_tmpl( $site->document_root ) ){
				$site->update([
					'creates_error' => 1,
					'last_error'    => "Cannot copy the files, Folder {$site->document_root} does not exists"
				]);
				continue;
			}

			if( !$sitesHostSSH->replace_db_credentials( $site ) ){
				$site->update([
					'creates_error' => 1,
					'last_error'    => "Cannot replace credentials in wp-config.php in folder {$site->document_root}"
				]);
				continue;
			}

			// if OK
			$site->update([
				'status'        => $done_status,
				'creates_error' => 0,
				'last_error'    => ''
			]);
		}

		$sitesHostSSH->ssh_cmd( "sudo chown -R www-data:11112 {$sitesHostSSH->auto_sites_path}" );

		CronStatuses::stop( $cron_name );
	}

	/**
	 * Process sites with status 2 and set 3
	 * DO:
	 *     import DB
	 *     replace 2 options in DB
	 *     clear Redis cache
	 */
	public static function process_with_empty_db(){
		$cron_name      = 'db_processing';
		$process_status = 2;
		$done_status    = 3;

//if( CronStatuses::is_run( $cron_name ) )
//	return;

		CronStatuses::run( $cron_name );

		$sites = Site::where( [ 'status'=>$process_status, 'to_remove'=>0, 'removed'=>0, 'creates_error'=>0 ] )->get();

		if( $sites->isEmpty() ){
			CronStatuses::stop( $cron_name );
			return;
		}

		$dbHost = new DBHostController();
		foreach( $sites as $site ){

			if( !$dbHost->copy_db_from_template_to( $site ) ){
				$site->update([
					'creates_error' => 1,
					'last_error'    => 'Cannot import DB'
				]);
				continue;
			}

			// OK
			$site->update([
				'status'        => $done_status,
				'creates_error' => 0,
				'last_error'    => ''
			]);

		}

		CronStatuses::stop( $cron_name );
	}

	/**
	 * Process sites with status 3 and set 4
	 * DO:
	 *     generate SSL for HTTPS
	 *     change configs for vhost 443
	 */
	public static function process_without_SSL(){
		$cron_name      = 'certbot_processing';
		$process_status = 3;
		$done_status    = 4;

//if( CronStatuses::is_run( $cron_name ) )
//	return;

		CronStatuses::run( $cron_name );

		$sites = Site::where( [ 'status'=>$process_status, 'to_remove'=>0, 'removed'=>0, 'creates_error'=>0 ] )->get();

		if( $sites->isEmpty() ){
			CronStatuses::stop( $cron_name );
			return;
		}

		$sitesHostSSH = new SitesHostSSHController();
		foreach( $sites as $site ){
			if( !$sitesHostSSH->SSL_generate( $site->website_url ) ){
				$site->update([
					'creates_error' => 1,
					'last_error'    => "Cannot generate SSL for domain {$site->website_url}"
				]);
				continue;
			}

			// if OK
			$site->update([
				'status'        => $done_status,
				'ssl_generated' => 1,
				'creates_error' => 0,
				'last_error'    => ''
			]);
		}

		CronStatuses::stop( $cron_name );
	}

	/**
	 * Process sites with status 4 and set 100
	 * In this function we gonna check if inventory is adjusted and other things
	 * like theme is set, title is not empty
	 * google key is set
	 */
	public static function finalize_processing(){
		$cron_name      = 'finalize_processing';
		$process_status = 4;
		$done_status    = 100;

		if( CronStatuses::is_run( $cron_name ) )
			return;

		CronStatuses::run( $cron_name );

		$sites = Site::where( [ 'status'=>$process_status, 'to_remove'=>0, 'removed'=>0, 'creates_error'=>0 ] )->get();

		if( $sites->isEmpty() ){
			CronStatuses::stop( $cron_name );
			return;
		}

		foreach( $sites as $site ){
			$site->update( ['status'=>100] );
		}

		CronStatuses::stop( $cron_name );
	}

	/**
	 *
	 */
	/*
	public static function delete_sites(){
		if( CronStatuses::is_run( self::$cron_name_deleting ) )
			return;

		// Run
		//CronStatuses::run( self::$cron_name_deleting );

		// get sites to remove
		$to_remove = self::get_to_remove();

		if( $to_remove->isEmpty() ){
			CronStatuses::stop( self::$cron_name_deleting );
			return;
		}

		$sitesHostSSH = new SitesHostSSHController();
		$dbHost       = new DBHostSSHController();
		$server_ip    = CloudFlareController::get_server_ip();

		foreach( $to_remove as $site_to_remove ){

			$update = [];

			// 1 - Remove the virtual host configurations files only
			$vhost_path     = $sitesHostSSH->vhost_path . '/' . $site_to_remove->vhost_filename;
			$vhost_ssl_path = $sitesHostSSH->vhost_path . '/' . $site_to_remove->vhost_ssl_filename;
			$sitesHostSSH->ssh_cmd( "rm $vhost_path" );
			$sitesHostSSH->ssh_cmd( "rm $vhost_ssl_path" );
			$update['vhost_filename'] = $update['vhost_ssl_filename'] = '';

			// 2 - Remove SSL if exists
			if( $site_to_remove->ssl_generated ){
				$sitesHostSSH->ssh_cmd( "sudo certbot delete -d {$site_to_remove->website_url}" );
				$update['ssl_generated'] = 0;
			}

			// 3 - Remove the folder which is document root
			if( $site_to_remove->document_root && !empty( $site_to_remove->document_root ) ){
				$sitesHostSSH->ssh_cmd( "rm -rf {$site_to_remove->document_root}" );
				$update['document_root'] = '';
			}

			// 4 - Remove database
			if( $site_to_remove->db_name ){
				$dbHost->delete_database( $site_to_remove->db_name );
				$update['db_name'] = '';
			}

			// 5 - Remove database user
			if( $site_to_remove->db_user ){
				$dbHost->delete_user( "'{$site_to_remove->db_user}'@'{$server_ip}'" );
				$update['db_user'] = $update['db_pass'] = '';
			}

			// 6 - Remove NS record
			if( $site_to_remove->website_url ){
				CloudFlareController::delete_ns( $site_to_remove->website_url );
				$update['website_url'] = '';
			}

			$update['removed'] = 1;

			// update data in internal DB
			$site_to_remove->update( $update );
		}

		// 7 - Flush Redis cache on the server
		$sitesHostSSH->ssh_cmd( "redis-cli -a {$sitesHostSSH->redis_pass} FLUSHALL" );

// 8 - Reload Apache
//$sitesHostSSH->ssh_cmd( "sudo apachectl reload" );

		// Stop
		CronStatuses::stop( self::$cron_name_deleting );

		dd( $to_remove );
	}
	*/

}
