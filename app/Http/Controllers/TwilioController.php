<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use Twilio\TwiML\VoiceResponse;
use Illuminate\Http\Response;


class TwilioController extends Controller{

	// https://www.twilio.com/docs/quickstart

	public  $client     = null;
	private $SID_test   = 'AC88fc95070944099e266a41e0a63d4490';
	private $SID_live   = 'AC1590d9ebcecd45e3f1787a2b289ffbc1';
	private $token_test = '8038f7630a961a3487282d81f95460c0';
	private $token_live = 'b7944194c8b032b8e2f8296f048932cc';
	private $from       = '(503) 400 3633'; // (503) 400-3373

	public static $voice = 'man';

	/**
	 * TwilioController constructor.
	 * @throws \Twilio\Exceptions\ConfigurationException
	 */
	public function __construct(){
		$this->client = new Client( $this->SID_live, $this->token_live );
	}

	/**
	 * @param string $number
	 * @param string $message
	 */
	public function sendMessage( string $number, string $message ){

	}

	/**
	 * @param string $number
	 * @param string $code
	 */
	public function callVoiceCode( string $number, string $code ){
		$this->client->account->calls->create( $number, $this->from, [
			'url' => route( 'Twilio_voice_code_xml', [ 'code' => $code ] ),
		] );
	}

	/**
	 * @param string $code
	 *
	 * @return string
	 */
	public static function voiceXML( string $code ){
		$say = ',,,,,,,,,, Your code is ';

		$voice_response = new VoiceResponse();

		$say = $voice_response->say( $say, [
			'voice'    => self::$voice,
			'language' => 'en-US',
			'loop'     => 3
		] );
		$say->break_(['strength' => 'x-weak', 'time' => '1000ms']);;

		for( $i = 0; $i < strlen( $code ); $i++ ){
			$digit = $code[ $i ];
			$say->append( $digit . ',,,,,,,,,,' );
			$say->break_( [ 'strength' => 'x-weak', 'time' => '2000ms' ] );
		}

		return $voice_response;
	}

}
