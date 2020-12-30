<?php

namespace App\Http\Controllers;

class SitesHostSSHController extends Controller{

	// Sites
	protected $sites_server_host;
	protected $sites_server_user;
	protected $sites_server_pass;

	// Connection Handler
	protected $ch;

	public function __construct(){

		$this->sites_server_host = '100.21.64.57';
		$this->sites_server_user = 'dg_auto';
		$this->sites_server_pass = '';

		$this->ch = ssh2_connect( $this->sites_server_host );

		// Auth with key
		//ssh2_auth_pubkey_file( $this->ch, $this->sites_server_user, $this->sites_server_pass );
	}

	public function create_db_and_user( string $name ){

		//dd( $this->db_server_pass );
	}
}
