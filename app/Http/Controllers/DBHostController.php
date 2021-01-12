<?php

namespace App\Http\Controllers;

use mysqli;

class DBHostController extends Controller{

	// DB
	protected $db_mysql_ch;

	// SSH
	protected $ssh_ch;
	protected $login_res;

	// keys
	protected $db_pub_key_path;
	protected $db_priv_key_path;

	public static $db_server_host = '100.21.64.57';
	public static $db_server_user = 'dg_auto';
	public static $db_mysql_pass  = '4LzJp91PPnQREIe';

	// Templates
	protected $tmpl_db_name    = 'adg_tmpl';
	protected $tmp_db_filename = 'db_auto_temp.sql';

	public function __construct(){

	}

	/**
	 * @return void
	 */
	public function __mysql_connect():void{
		$this->db_mysql_ch = mysqli_connect( self::$db_server_host, self::$db_server_user, self::$db_mysql_pass, 'mysql' );
	}

	/**
	 * @param string $base_name
	 *
	 * @return array
	 */
	public function create_db_and_user( string $base_name ):array{

		// Simple Sanitizing For Database Syntax
		$base_name = str_replace( '-', ' ', $base_name );
		$base_name = preg_replace( '~\s+~', '_', trim( $base_name ) );
		$base_name = preg_replace('/[^A-Za-z0-9_]/', '', $base_name);
		$base_name = preg_replace( '~^_~', '', $base_name );

		$db_name = 'adg_auto_' . $base_name;
		$db_user = 'au_'       . $db_name;

		$db_name = HelperController::generate_name_from_string( $db_name, $this->get_databases(), true );
		$db_user = HelperController::generate_name_from_string( $db_user, $this->get_users(),     true );

		// Create Database
		$this->exec( "CREATE DATABASE `{$db_name}`;" );

		// Create User
		$db_pass                     = HelperController::generate_password();
		$server_ip                   = CloudFlareController::get_server_ip();
		$user_name_with_host         = "'{$db_user}'@'{$server_ip}'";
		$dg_auto_user_name_with_host = "'" . self::$db_server_user . "'@'localhost'";
		$query                       = "CREATE USER {$user_name_with_host} IDENTIFIED WITH mysql_native_password BY '{$db_pass}';";
		$this->exec( $query );

		// Grant for created user and for 'dg_auto'@'localhost' user
		$this->exec( "GRANT ALL PRIVILEGES ON `{$db_name}`.* TO {$user_name_with_host}, {$dg_auto_user_name_with_host};" );
		$this->exec( 'FLUSH PRIVILEGES;' );

		return [
			'db_name' => $db_name,
			'db_user' => $db_user,
			'db_pass' => $db_pass,
		];
	}

	/**
	 * @param string $username with host in the next format 'u_dg_auto_test'@'1.1.1.1'
	 *
	 * @return string
	 */
	public function delete_user( string $username ):string{
		return $this->exec( "DROP USER {$username};" );
	}

	/**
	 * @param string $database
	 *
	 * @return string
	 */
	public function delete_database( string $database ):string{
		return $this->exec( "DROP TABLE {$database};" );
	}

	/**
	 * @param $site
	 *
	 * @return bool
	 */
	public function copy_db_from_template_to( $site ):bool{

		// dump
		$this->ssh_cmd( "mysqldump {$this->tmpl_db_name} > {$this->tmp_db_filename}" );

		// import
		$this->ssh_cmd( "mysql {$site->db_name} < {$this->tmp_db_filename}" );

		// Grant privileges
		$server_ip                   = CloudFlareController::get_server_ip();
		$user_name_with_host         = "'{$site->db_user}'@'{$server_ip}'";
		$dg_auto_user_name_with_host = "'" . self::$db_server_user . "'@'localhost'";

		// Grant for site db user and 'dg_auto'@'localhost'
		$this->exec( "GRANT ALL PRIVILEGES ON `{$site->db_name}`.* TO {$user_name_with_host}, {$dg_auto_user_name_with_host};" );
		$this->exec( 'FLUSH PRIVILEGES;' );

		// Replace `siteurl` and `home`
		$website_url = 'https://' . $site->website_url;
		$this->exec( "UPDATE {$site->db_name}.wp_options SET option_value = '{$website_url}/core' WHERE option_name = 'siteurl'" );
		$this->exec( "UPDATE {$site->db_name}.wp_options SET option_value = '{$website_url}'      WHERE option_name = 'home'"    );


		// TODO: Add another options based on the settings
		//
		//
		//


		// TODO: Refactor it later
		$res = $this->query( "SELECT option_value FROM {$site->db_name}.wp_options WHERE option_name = 'home' " );
		return isset( $res[0][0] ) && $website_url === $res[0][0];
	}

	/*=============
	||  HELPERS  ||
	=============*/

	/**
	 * Returns all databases names exists on DB servers
	 *
	 * @return array
	 */
	public function get_users():array{

		$users_raw = $this->query( 'SELECT `user` FROM `user`' );

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
	public function get_databases():array{

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
	public function query( $query ):array{

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
	public function exec( $query ):string{
		if( !$this->db_mysql_ch ) $this->__mysql_connect();

		mysqli_query( $this->db_mysql_ch, $query );

		return mysqli_error( $this->db_mysql_ch );
	}

	/**
	 * @return void
	 */
	public function __ssh_connect(){
		// this function will set `$sites_pub_key_path` and `$sites_priv_key_path` vars
		$this->set_keys_path();

		$this->ssh_ch    = ssh2_connect( self::$db_server_host, 22, [ 'hostkey' => 'ssh-rsa' ] );
		$this->login_res = ssh2_auth_pubkey_file( $this->ssh_ch, self::$db_server_user, $this->db_pub_key_path, $this->db_priv_key_path );
	}

	/**
	 * @param string $cmd
	 *
	 * @return string
	 */
	public function ssh_cmd( string $cmd ):string{

		if( ! $this->ssh_ch ) $this->__ssh_connect();

		// create file with listing of directories in specific folder
		$stream = ssh2_exec( $this->ssh_ch, $cmd );
		stream_set_blocking( $stream, true );
		$output_raw = stream_get_contents( $stream, 4096 );
		fclose( $stream );

		return $output_raw;
	}


	/**
	 * @return void
	 */
	public function set_keys_path():void{
		$this->db_pub_key_path  = storage_path( 'keys' ) . '/dg_auto.pub';
		$this->db_priv_key_path = storage_path( 'keys' ) . '/dg_auto';
	}

	/**
	 * Disconnect from MySQL
	 */
	public function __destruct(){
		if( $this->db_mysql_ch instanceof MySQLi ) mysqli_close( $this->db_mysql_ch );
		if( is_resource( $this->ssh_ch ) ) ssh2_disconnect( $this->ssh_ch );
	}
}
