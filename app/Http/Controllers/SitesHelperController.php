<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class SitesHelperController extends Controller{
	private static $opts = [
		'http'    => [
			'header' => "User-Agent:Datgate/1.0\r\n",
			'timeout' => 100,
		],
		'ssl'     => [
			'verify_peer'      => false,
			'verify_peer_name' => false,
		],
	];

	public function getSiteData( Request $request ){
		$site_url = $request->input( 'site-url' );

		if( ! filter_var( $site_url, FILTER_VALIDATE_DOMAIN ) ){
			$return = [
				'status'  => 'ERROR',
				'message' => 'Url is not valid',
			];
		}
		else{
			$data = [];

			try{
				$context = stream_context_create( self::$opts );
				$html    = file_get_contents( $site_url, false, $context, 0, 100000 );

				$crawler = new Crawler( $html );
			}
			catch( \Exception $e ){
				return json_encode([]);
			}


			if( 'favicon' ){
				try{
					$data['favicon_url'] = $crawler->filterXPath( '//link[contains(@rel, "icon")]' )->attr('href');

					// append domain
					if( '/' === substr( $data['favicon_url'], 0, 1 ) ){
						$data['favicon_url'] = $site_url . $data['favicon_url'];
					}
				}
				catch( \Exception $e ){}
			}

			if( 'logo' ){
				try{
					$data['logo_url'] = $crawler->filterXPath( '//img[contains(@class, "logo")]' )->attr( 'src' );

					// append domain
					if( '/' === substr( $data['logo_url'], 0, 1 ) ){
						$data['logo_url'] = $site_url . $data['logo_url'];
					}
				}
				catch( \Exception $e ){}
				// try to get with a
				if( ! isset( $data['logo_url'] ) ){
					try{
						$data['logo_url'] = $crawler->filterXPath( '//a[contains(@class, "logo")]' )->children( 'img' )
							->attr( 'src' );
						// append domain
						if( '/' === substr( $data['logo_url'], 0, 1 ) ){
							$data['logo_url'] = $site_url . $data['logo_url'];
						}
					}
					catch( \Exception $e ){}
				}
			}

			$return = [
				'status' => 'OK',
				'data'   => $data,
			];
		}

		return json_encode( $return, JSON_UNESCAPED_SLASHES );
	}

	public function isEmailUnique( Request $request ) {
		$email = $request->input( 'email' );

		if( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
			$return = [
				'status'  => 'ERROR',
				'message' => 'Email is not valid',
			];
		}
		else{
			$data = [];

			$return = [
				'status' => 'OK',
				'data'   => $data,
			];
		}

		return json_encode( $return, JSON_UNESCAPED_SLASHES );
	}

	public function isPhoneUnique( Request $request ) {
		$phone = $request->input( 'phone' );

		if( ! filter_var( $phone, FILTER_VALIDATE_INT ) ){
			$return = [
				'status'  => 'ERROR',
				'message' => 'The phone is incorrect',
			];
		}
		
		else {
			$data = [];

			$return = [
				'status' => 'OK',
				'data'   => $data,
			];
		}

		return json_encode( $return, JSON_UNESCAPED_SLASHES );
	}

}
