<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class SitesHostSSHController extends Controller{

	// Sites
	protected $sites_server_host;
	protected $sites_server_user;
	protected $sites_pub_key_path;
	protected $sites_priv_key_path;

	protected $auto_sites_path = '/var/www/dealer_sites_auto';
	protected $su_pass         = '4LzJp91PPnQREIe';

	// should be exists in the user's home directory
	protected $temp_file_name      = 'auto_sites';
	protected $vhost_path          = 'auto-sites-enabled';
	protected $vhost_template_file = 'vhost-template.conf';


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
	 * Send file via SSH/SFTP from `vhosts` storage to `auto_sites_path` by filename
	 *
	 * @param string $filename
	 *
	 * @return bool
	 */
	public function ssh_send_file( string $filename ):bool{

		if( ! $this->ch ) $this->__ssh_connect();

		$local_filename  = Storage::disk( 'vhosts' )->path( $filename );
		$remote_filename = "{$this->vhost_path}/{$filename}";

		return ssh2_scp_send( $this->ch, $local_filename, $remote_filename, 0644 );
	}

	/**
	 * @param string $base_name
	 *
	 * @return string
	 */
	public function create_folder( string $base_name ):string{
		$dir_name      = HelperController::generate_name_from_string( $base_name, $this->get_directories(), false, true );
		$document_root = "{$this->auto_sites_path}/{$dir_name}";

		// TODO: uncomment me
		// $this->ssh_cmd( "mkdir {$document_root}" );

		return $document_root;
	}

	/**
	 * Return array of directories in specific folder on remote Server
	 *
	 * @return array
	 */
	public function get_directories():array{

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
	public function set_keys_path():void{
		$this->sites_pub_key_path  = storage_path( 'keys' ) . '/dg_auto.pub';
		$this->sites_priv_key_path = storage_path( 'keys' ) . '/dg_auto';
	}

	/**
	 * @param string $cmd
	 *
	 * @return string
	 */
	public function ssh_cmd( string $cmd ):string{

		if( ! $this->ch ) $this->__ssh_connect();

		// create file with listing of directories in specific folder
		$stream = ssh2_exec( $this->ch, $cmd );
		stream_set_blocking( $stream, true );
		$output_raw = stream_get_contents( $stream );
		fclose( $stream );

		return $output_raw;
	}

	/**
	 * @param string $domain
	 *
	 * @return bool
	 */
	public function SSL_generate( string $domain ):bool{

		// delete if exists
		if( $this->is_SSL_exists( $domain ) ){
			$certbot_cmd = "echo {$this->su_pass} | sudo -S certbot delete --cert-name {$domain}";
			$this->ssh_cmd( $certbot_cmd );
		}

		$certbot_cmd = "echo {$this->su_pass} | sudo -S certbot -d {$domain}";
		$res         = $this->ssh_cmd( $certbot_cmd );

		return false !== strpos( $res, 'Congratulations' );
	}

	/**
	 * @param string $domain
	 *
	 * @return bool
	 */
	public function is_SSL_exists( string $domain ):bool{
		$certbot_cmd = "echo {$this->su_pass} | sudo -S certbot certificates -d {$domain}";
		$output      = $this->ssh_cmd( $certbot_cmd );

		return false !== strpos( $output, "Certificate Name: {$domain}" );
	}

	/**
	 * Get template of virtual host configuration file for Apache
	 *
	 * @return string
	 */
	public function get_vhost_template_file_content():string{
		return $this->ssh_cmd( "cat {$this->vhost_template_file}" );
	}

	/**
	 * Disconnect from SSH
	 */
	public function __destruct(){
		if( is_resource( $this->ch ) ) ssh2_disconnect( $this->ch );
	}
}
