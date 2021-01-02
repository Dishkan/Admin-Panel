<?php

namespace App\Http\Controllers;

class SitesHostSSHController extends Controller{

	// Sites
	protected $sites_server_host;
	protected $sites_server_user;
	protected $sites_pub_key_path;
	protected $sites_priv_key_path;

	protected $auto_sites_path = '/var/www/dealer_sites_auto';
	protected $temp_file_name  = 'auto_sites';

	// SSH Connection Handler
	protected $ch;

	protected $login_res;

	public function __construct(){
		$this->sites_server_host = '54.188.129.59';
		$this->sites_server_user = 'dg_auto'; // 4LzJp91PPnQREIe
	}

	/**
	 * @return void
	 */
	public function __ssh_connect(){
		// this function will set `$sites_pub_key_path` and `$sites_priv_key_path` vars
		$this->set_keys_path();

		$this->ch        = ssh2_connect( $this->sites_server_host, 22, [ 'hostkey' => 'ssh-rsa' ] );
		$this->login_res = ssh2_auth_pubkey_file( $this->ch, $this->sites_server_user, $this->sites_pub_key_path, $this->sites_priv_key_path );
	}

	/**
	 * @param string $base_name
	 *
	 * @return string
	 */
	public function create_folder( string $base_name ): string{
		$dir_name      = HelperController::generate_name_from_string( $base_name, $this->get_directories() );
		$dir_name      = $dir_name . '.' . CloudFlareController::$zone_domain;
		$document_root = "{$this->auto_sites_path}/{$dir_name}";

		$this->ssh_cmd( "mkdir {$document_root}" );

		return $document_root;
	}

	/**
	 * Return array of directories in specific folder on remote Server
	 *
	 * @return array
	 */
	public function get_directories(): array{

		// create file with listing of directories in specific folder
		$this->ssh_cmd( "ls {$this->auto_sites_path} > {$this->temp_file_name}" );

		// show content of file, created above
		$sites_raw = $this->ssh_cmd( "cat {$this->temp_file_name}" );

		// clean up array of sites
		$sites = explode( "\n", $sites_raw );
		$sites = array_filter( $sites );
		$sites = array_map( 'trim', $sites );

		return $sites;
	}

	/**
	 * @return void
	 */
	public function set_keys_path(): void{
		$this->sites_pub_key_path  = storage_path( 'keys' ) . '/dg_auto.pub';
		$this->sites_priv_key_path = storage_path( 'keys' ) . '/dg_auto';
	}

	/**
	 * @param string $cmd
	 *
	 * @return false|string
	 */
	public function ssh_cmd( string $cmd ){

		if( ! $this->ch ) $this->__ssh_connect();

		// create file with listing of directories in specific folder
		$stream = ssh2_exec( $this->ch, $cmd );
		stream_set_blocking( $stream, true );
		$output_raw = stream_get_contents( $stream );
		fclose( $stream );

		return $output_raw;
	}

	/**
	 * Disconnect from SSH
	 */
	public function __destruct(){
		if( is_resource( $this->ch ) ) ssh2_disconnect( $this->ch );
	}
}
