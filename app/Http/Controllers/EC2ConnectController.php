<?php

namespace App\Http\Controllers;


class EC2ConnectController extends Controller{

	public static function create_db_and_user( string $name ){

		$db_server_host = env('DB_HOST');
		$db_server_user = env('DB_SERVER_USER');
		$db_server_pass = env('DB_SERVER_PASS');

		$ch = ssh2_connect( $db_server_host );
		ssh2_auth_password( $ch, $db_server_user, $db_server_pass );

		exit('connected');


	}

}
