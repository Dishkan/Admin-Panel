<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelperController extends Controller{

	public static $chars = '123456789abcdefghijklmnopqrstuvwxyz';

	public static function test(){

		$sitesHostSSH = new SitesHostSSHController();

		$sitesHostSSH->get_directories();

		exit('here');

		// $EC2 = new DBHostSSHController();
		// $EC2->create_db_and_user( 'test' );
	}

	/**
	 * Return the same string if it not exists in second param (array)
	 * If exists, will generate random symbols starts with dash `-`
	 *
	 * Example:
	 * 'banana', ['apple','banana','tomato']              = return: `banana-{random char}`
	 * 'bull',   ['apple','banana','tomato']              = return: `bull`
	 * 'apple',  ['apple','banana','tomato'], true        = return: `bull_c`
	 * 'apple',  ['apple','banana','tomato'], true,  true = return: `c_bull`
	 * 'apple',  ['apple','banana','tomato'], false, true = return: `bull_c`
	 *
	 * @param string $string
	 * @param array  $array
	 * @param bool   $not_dash
	 * @param bool   $prepend
	 *
	 * @return string
	 */
	public static function generate_name_from_string( string $string, array $array, $not_dash = false, $prepend = false ){
		$i         = 0;
		$sep_char  = $not_dash ? '_' : '-';
		$chars_len = strlen( self::$chars ) - 1;
		while( in_array( $string, $array ) && $i < 100 ){

			$char_to_add = self::$chars[ rand( 0, $chars_len ) ];

			if( $prepend )
				$string = 0 === $i ? $char_to_add . $sep_char . $string : $char_to_add . $string;
			else
				$string .= 0 === $i ? $sep_char . $char_to_add : $char_to_add;

			$i++;
		}

		return $string;
	}

	/**
	 * @param int $length
	 *
	 * @return string
	 */
	public static function generate_password( $length = 16 ){
		$pass      = '';
		$safe      = 0;
		$chars_len = strlen( self::$chars ) - 1;
		while( strlen( $pass ) < $length && $safe < 500 ){
			$pass .= self::$chars[ rand( 0, $chars_len ) ];
			$safe++;
		}

		return $pass;
	}

}
