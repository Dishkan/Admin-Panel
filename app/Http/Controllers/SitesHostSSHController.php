<?php

namespace App\Http\Controllers;

class SitesHostSSHController extends Controller{

	// Sites
	protected $sites_server_host;
	protected $sites_server_user;
	protected $sites_pub_key_path;
	protected $sites_priv_key_path;

	protected $auto_sites_path = '/var/www/dealer_sites_auto/';
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
	 * Return array of directories in specific folder on remote Server
	 */
	public function get_directories(){
		$dirs_raw = $this->ssh_cmd( 'ls' );

		dd( $dirs_raw );

	}

	/**
	 * @return void
	 */
	public function set_keys_path(){
		$this->sites_pub_key_path  = storage_path('keys') . '/dg_auto.pub';
		$this->sites_priv_key_path = storage_path('keys') . '/dg_auto';
	}

	/**
	 * @param string   $cmd
	 *
	 * @return false|string
	 */
	public function ssh_cmd( string $cmd ){

		if( !$this->ch ) $this->__ssh_connect();

		// create file with listing of directories in specific folder
		$stream = ssh2_exec( $this->ch, "ls {$this->auto_sites_path} > {$this->temp_file_name}" );
		stream_set_blocking( $stream, true );
		fclose( $stream );

		// show content of file, created above
		$stream = ssh2_exec( $this->ch, "cat {$this->temp_file_name}" );
		stream_set_blocking( $stream, true );
		$sites_raw = stream_get_contents( $stream );
		fclose( $stream );

		$sites = explode( "\n", $sites_raw );
		$sites = array_filter( $sites );

		echo '<pre>';
		print_r( $sites );


		exit;

		return $return;
	}

	/**
	 * Disconnect from SSH
	 */
	public function __destruct(){
		if( is_resource( $this->ch ) ) ssh2_disconnect( $this->ch );
	}
}
