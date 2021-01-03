<?php

namespace App\Http\Controllers;


class CloudFlareController extends Controller{

	private static $endpoint_url    = 'https://api.cloudflare.com/client/v4/';
	private static $token           = 'rsVRxM9pVN-FiT6WcdbmC8GImDlJ7JvAgXocWNPh';
	public  static $zone_domain     = 'idweb.io';
	private static $zone_id         = '42414f1b8a9adaffa0891ddb95441b56';
	private static $sites_server_IP = '54.188.129.59';

	/**
	 * Verify provided Token if it's active
	 *
	 * @return bool
	 */
	static function verify(){

		$ch = curl_init();
		curl_setopt_array( $ch, [
			CURLOPT_URL            => self::$endpoint_url . 'user/tokens/verify',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_CUSTOMREQUEST  => 'GET',
			CURLOPT_HTTPHEADER     => [
				'Authorization: Bearer ' . self::$token
			],
		] );

		$response = curl_exec( $ch );
		curl_close( $ch );

		try{
			if( ! is_object( @json_decode($response) ) ){
				throw new \Exception( json_last_error_msg() );
			}
			else{
				$res_obj = @json_decode( $response );
			}
		}
		catch( \Exception $e ){
			trigger_error( $e->getMessage(), E_USER_ERROR );
		}


		if( isset( $res_obj->result->status ) ){
			return 'active' === $res_obj->result->status;
		}

		return false;
	}

	/**
	 * List of exists A zones (subdomains)
	 *
	 * @return false|string
	 */
	static function list(){

		$ch = curl_init();
		curl_setopt_array( $ch, [
			CURLOPT_URL            => self::$endpoint_url . 'zones/'. self::$zone_id .'/dns_records?type=A',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_FRESH_CONNECT  => true,
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_CUSTOMREQUEST  => 'GET',
			CURLOPT_HTTPHEADER     => [
				'Authorization: Bearer ' . self::$token,
				'Cache-Control: no-cache'
			],
		] );

		$response = curl_exec( $ch );

		curl_close( $ch );

		try{
			if( ! is_object( @json_decode($response) ) ){
				throw new \Exception( json_last_error_msg() );
			}
			else{
				$res_obj = @json_decode( $response );
			}
		}
		catch( \Exception $e ){
			trigger_error( $e->getMessage(), E_USER_ERROR );
		}

		$names = [];
		foreach( $res_obj->result as $domain ){
			$name = preg_replace( '~\.$~', '', str_replace( self::$zone_domain, '', $domain->name ) );

			if( !$name ) continue;

			$names[ $name ] = [
				'id'      => $domain->id,
				'content' => $domain->content,
			];
		}

		return json_encode( $names, JSON_UNESCAPED_SLASHES );
	}

	/**
	 * @param string $ns
	 *
	 * @return array
	 */
	static function create_ns( string $ns ){

		$result = [];

		$list = (array)json_decode( self::list() );
		if( array_key_exists( $ns, $list ) ){
			$result['status']  = 'Error';
			$result['message'] = "Record already exists [name: $ns, id: {$list[$ns]->id}]";
		}
		else{
			$payload = json_encode( [
				'type'    => 'A',
				'name'    => "$ns." . self::$zone_domain,
				'content' => self::$sites_server_IP,
				'ttl'     => 120,
				'proxied' => false,
			] );

			$ch = curl_init();
			curl_setopt_array( $ch, [
				CURLOPT_URL            => self::$endpoint_url . 'zones/'. self::$zone_id .'/dns_records',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_MAXREDIRS      => 10,
				CURLOPT_TIMEOUT        => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_CUSTOMREQUEST  => 'POST',
				CURLOPT_POSTFIELDS     => $payload,
				CURLOPT_HTTPHEADER     => [
					'Authorization: Bearer ' . self::$token
				],
			] );

			$response = curl_exec( $ch );

			curl_close( $ch );

			try{
				if( ! is_object( @json_decode($response) ) ){
					throw new \Exception( json_last_error_msg() );
				}
				else{
					$res_obj = @json_decode( $response );
				}
			}
			catch( \Exception $e ){
				trigger_error( $e->getMessage(), E_USER_ERROR );
			}

			if( property_exists( $res_obj, 'success' ) && $res_obj->success ){
				$result['status']  = 'OK';
				$result['message'] = "Successful created [$ns]";
				$result['domain']  = 'https://' . $ns . '.' . self::$zone_domain;
			}
			else{
				$result['status']  = 'Error';
				$result['message'] = 'Error while creating';
			}
		}


		return $result;
	}

	/**
	 * Delete NS record
	 *
	 * @param string $ns
	 *
	 * @return array
	 */
	static function delete_ns( string $ns ){

		$list   = (array)json_decode( self::list() );
		$result = [];

		if( ! array_key_exists( $ns, $list ) ){
			$result['status']  = 'Error';
			$result['message'] = "Record does not exists [$ns]";
		}
		else{
			$ch = curl_init();
			curl_setopt_array( $ch, [
				CURLOPT_URL            => self::$endpoint_url . 'zones/'. self::$zone_id .'/dns_records/'. $list[$ns]->id,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_MAXREDIRS      => 10,
				CURLOPT_TIMEOUT        => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_CUSTOMREQUEST  => 'DELETE',
				CURLOPT_HTTPHEADER     => [
					'Authorization: Bearer ' . self::$token
				],
			] );

			$response = curl_exec( $ch );
			curl_close( $ch );

			/*
			{
			  "result": {
			    "id": "7084e6c75f2f56f2c0cf5293bd329f61"
			  },
			  "success": true,
			  "errors": [],
			  "messages": []
			}
			*/
			try{
				if( ! is_object( @json_decode($response) ) ){
					throw new \Exception( json_last_error_msg() );
				}
				else{
					$res_obj = @json_decode( $response );
				}
			}
			catch( \Exception $e ){
				trigger_error( $e->getMessage(), E_USER_ERROR );
			}

			if( property_exists( $res_obj, 'success' ) && $res_obj->success ){
				$result['status']  = 'OK';
				$result['message'] = "Successful removed [$ns]";
			}
			else{
				$result['status']  = 'Error';
				$result['message'] = 'Error while removing';
			}
		}


		return $result;
	}

	/**
	 * @return string
	 */
	static function get_server_ip(){
		// TODO: create logic to get this info based on environment
		return self::$sites_server_IP;
	}

	/**
	 * @return string
	 */
	static function get_zone_domain(){
		// TODO: create logic to get this info based on environment
		return self::$sites_server_IP;
	}

}
