<?php

namespace App\Http\Controllers;

class SitesHostSSHController extends Controller{

	// Sites
	protected $sites_server_host;
	protected $sites_server_user;
	protected $sites_pub_key_path;
	protected $sites_priv_key_path;

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

		$outputs = [];

		$stream = ssh2_exec( $this->ch, 'cd /var/www/dealer_sites_auto/ && pwd' );
		stream_set_blocking( $stream, true );
		$outputs[] = stream_get_contents( $stream );
		fclose( $stream );


		echo '<pre>';
		print_r( $outputs );


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
