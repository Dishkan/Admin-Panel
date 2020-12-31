<?php

namespace App\Http\Controllers;

use mysqli;

class DBHostSSHController extends Controller{

	// DB
	protected $db_mysql_ch;
	protected $db_server_host;
	protected $db_server_user;
	protected $db_mysql_pass;

	public function __construct(){
		$this->db_server_host = '100.21.64.57';
		$this->db_server_user = 'dg_auto';
		$this->db_mysql_pass  = '4LzJp91PPnQREIe';
	}

	/**
	 * @return void
	 */
	public function __mysql_connect(){
		$this->db_mysql_ch = mysqli_connect( $this->db_server_host, $this->db_server_user, $this->db_mysql_pass, 'mysql' );
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
	 * Disconnect from MySQL
	 */
	public function __destruct(){
		if( $this->db_mysql_ch instanceof MySQLi ) mysqli_close( $this->db_mysql_ch );
	}
}
