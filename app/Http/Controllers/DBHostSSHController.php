<?php

namespace App\Http\Controllers;

use mysqli;
use PHPUnit\TextUI\Help;

class DBHostSSHController extends Controller{

	// DB
	protected $db_mysql_ch;
	protected $db_server_host;
	protected $db_server_user;
	protected $db_pub_key_path;
	protected $db_priv_key_path;
	protected $db_mysql_pass;

	// SSH Connection Handler
	protected $ch;

	protected $login_res;

	public function __construct(){
		$this->db_server_host = '100.21.64.57';
		$this->db_server_user = 'dg_auto';
		$this->db_mysql_pass  = '4LzJp91PPnQREIe';
	}

	/**
	 * @return void
	 */
	public function __ssh_connect(){
		// this function will set `$db_pub_key_path` and `$db_priv_key_path` vars
		$this->set_keys_path();

		$this->ch = ssh2_connect( $this->db_server_host );

		// Auth with key
		$this->login_res = ssh2_auth_pubkey_file( $this->ch, $this->db_server_user, $this->db_pub_key_path, $this->db_priv_key_path );
	}

	/**
	 * @return void
	 */
	public function __mysql_connect(){
		$this->db_mysql_ch = mysqli_connect( $this->db_server_host, $this->db_server_user, $this->db_mysql_pass, 'mysql' );
	}

	/**
	 * @return void
	 */
	public function set_keys_path(){
		$this->db_pub_key_path  = storage_path('keys') . '/dg_auto.pub';
		$this->db_priv_key_path = storage_path('keys') . '/dg_auto';
	}

	/**
	 * @param string $base_name
	 *
	 * @return array
	 */
	public function create_db_and_user( string $base_name ){
		$db_name = 'dg_auto_' . $base_name;
		$db_user = 'u_'       . $db_name;

		$db_name = HelperController::generate_name_from_string( $db_name, $this->get_databases(), true );
		$db_user = HelperController::generate_name_from_string( $db_user, $this->get_users(),     true );

		// Create Database
		// TODO: Uncomment it when it's live
		$this->exec( "CREATE DATABASE $db_name;" );

		// Create User
		$db_pass             = HelperController::generate_password();
		$server_ip           = CloudFlareController::get_server_ip();
		$user_name_with_host = "'{$db_user}'@'{$server_ip}'";
		$query               = "CREATE USER {$user_name_with_host} IDENTIFIED WITH mysql_native_password BY '{$db_pass}';";
		$this->exec( $query );

		// Grant Privileges
		$this->exec( "GRANT ALL PRIVILEGES ON *.{$db_name} TO {$user_name_with_host};" );

		$res = [
			'db_name' => $db_name,
			'db_user' => $db_user,
			'db_pass' => $db_pass,
		];


		return $res;
	}


	/*=============
	||  HELPERS  ||
	=============*/

	/**
	 * @param string   $cmd
	 *
	 * @return false|string
	 */
	public function ssh_cmd( string $cmd ){

		if( !$this->ch ) $this->__ssh_connect();

		$stream = ssh2_exec( $this->ch, $cmd );
		stream_set_blocking( $stream, true );
		$stream_out = ssh2_fetch_stream( $stream, SSH2_STREAM_STDIO );
		$return     = stream_get_contents( $stream_out );

		fclose( $stream );

		return $return;
	}

	/**
	 * Returns all databases names exists on DB servers
	 *
	 * @return array
	 */
	public function get_users(){

		$users_raw = $this->query( 'SELECT user FROM user' );

		$users = [];
		foreach( $users_raw as $item ){
			$users[] = $item[0] ?: '';
		}

		return $users;
	}

	/**
	 * Returns all users name on DB servers
	 *
	 * @return array
	 */
	public function get_databases(){

		$dbs_raw = $this->query( 'SHOW DATABASES' );
		$databases = [];
		foreach( $dbs_raw as $item ){
			$databases[] = $item[0] ?: '';
		}

		return $databases;
	}

	/**
	 * @param $query
	 *
	 * @return array
	 */
	public function query( $query ){

		if( !$this->db_mysql_ch ) $this->__mysql_connect();

		$res_raw = mysqli_query( $this->db_mysql_ch, $query );

		$res = [];
		while( $row = mysqli_fetch_row( $res_raw ) ){
			$res[] = $row;
		}

		return $res;
	}

	/**
	 * @param $query
	 *
	 * @return string
	 */
	public function exec( $query ){
		if( !$this->db_mysql_ch ) $this->__mysql_connect();

		// TODO: Uncomment it when it's live
		// mysqli_query( $this->db_mysql_ch, $query );
		mysqli_query( $this->db_mysql_ch, 'select time()' );

		return mysqli_error( $this->db_mysql_ch );
	}

	/**
	 * Disconnect from SSH and MySQL
	 */
	public function __destruct(){
		if( is_resource( $this->ch ) ) ssh2_disconnect( $this->ch );
		if( $this->db_mysql_ch instanceof MySQLi ) mysqli_close( $this->db_mysql_ch );
	}
}
