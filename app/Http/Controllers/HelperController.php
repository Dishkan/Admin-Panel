<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class HelperController extends Controller{

	public static $chars = '123456789abcdefghijklmnopqrstuvwxyz';

	public static function test(){


		$hirads_number = '+15035445583';
		$antons_number = '+380672206192';
		$segas_number  = '+380660035739';
		$dens_number   = '+380931488118';


		if( false && 'TEST'){
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://rest.plus.dealerpeak.com/api/Credit/CreateApplication?createLead=true',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'{
  "Source": "Dealership Website",
  "Applicant": {
    "DOB": "05/23/1985",
    "SSN": 555555555,
    "DriversLicense": "334345AB12",
    "DriversLicenseState": "AZ",
    "DriversLicenseExpirationDate": "05/23/2025",
    "FirstName": "John",
    "MiddleName": "Test",
    "LastName": "Customer",
    "Suffix": "Sr",
    "Title": "Dr",
    "ConsumerEmail": "drtest@example.com",
    "HomePhone": 7776668888,
    "CellPhone": 6667779999,
    "WorkPhone": 3335557777,
    "Address1": "123 Test Dr",
    "Address2": "Appt 123",
    "City": "Phoenix",
    "State": "AZ",
    "ZipCode": "85001",
    "YearsAtCurrentAddress": 3,
    "MonthsAtCurrentAddress": 3,
    "Address1Prev": "345 Blah St",
    "Address2Prev": "",
    "CityPrev": "Amarillo",
    "StatePrev": "TX",
    "ZipCodePrev": "79110",
    "YearsAtPrevAddress": 6,
    "MonthsAtPrevAddress": 3,
    "MailingAddress1": "PO BOX 6890",
    "MailingAddress2": "",
    "MailingCity": "Phoenix",
    "MailingState": "AZ",
    "MailingZipCode": "85001",
    "HomeFinance": "BuyingHome",
    "HousingPayment": 1456.00,
    "OutstandingAutoLoan": true,
    "LineHolder": "Car Bank",
    "Year": "2021",
    "Make": "Tesla",
    "Model": "Model X",
    "LoanAmount": 82300.00,
    "TradeVehicle": false,
    "Employer": "DealerPeak LLC",
    "JobDescription": "Salesperson",
    "EmploymentStatus": "FullTime",
    "EmployerPhone": 5554443333,
    "EmployerEmail": "employer@example.com",
    "EmployerAddress1": "123 Test Dr",
    "EmployerAddress2": "",
    "EmployerCity": "Phoenix",
    "EmployerState": "AZ",
    "EmployerZipCode": "85005",
    "YearsAtCurrentCompany": 7,
    "MonthsAtCurrentCompany": 6,
    "EmployerPrev": "",
    "JobDescriptionPrev": "",
    "EmployerPhonePrev": null,
    "EmployerAddress1Prev": "",
    "EmployerAddress2Prev": "",
    "EmployerCityPrev": "",
    "EmployerStatePrev": "",
    "EmployerZipCodePrev": "",
    "YearsAtPrevCompany": null,
    "MonthsAtPrevCompany": null,
    "PrimaryIncome": 3000,
    "SecondaryIncome": 600,
    "SourceofOtherIncome": "Waiter",
    "Reference1Name": "Bill Joe",
    "Reference1Address": "456 Big Blvd Amarillo, TX 79112",
    "Reference1Phone": 5678901234,
    "Reference1Relationship": "Professor",
    "Reference2Name": "",
    "Reference2Address": "",
    "Reference2Phone": null,
    "Reference2Relationship": "",
    "Reference3Name": "",
    "Reference3Address": "",
    "Reference3Phone": null,
    "Reference3Relationship": "",
    "InsuranceCompanyName": "AllState",
    "InsuranceCompanyPhone": 345678123,
    "InsuranceCompanyAddress1": "123 All St",
    "InsuranceCompanyAddress2": "",
    "InsuranceCompanyCity": "Phoenix",
    "InsuranceCompanyState": "AZ",
    "InsuranceCompanyZipCode": "85007",
    "InsuranceCompanyAgentFirstName": "My",
    "InsuranceCompanyAgentLastName": "Agent",
    "InsuranceCompanyAgencyName": "My AllState Agency",
    "InsuranceCompanyPolicyNumber": 12345677,
    "InsuranceCompanyPolicyStartDate": null,
    "InsuranceCompanyPolicyEndDate": null,
    "InsuranceCompanyLiabilityCoverage": null,
    "InsuranceCompanyCompCoverage": null,
    "InsuranceCompanyCompDeductible": null,
    "InsuranceCompanyCollisionCoverage": null,
    "InsuranceCompanyCollisionDeductible": null
  },
  "CoApplicant": null,
  "BankruptcyComments": "",
  "AdditionalComments": ""
}',
				CURLOPT_HTTPHEADER => array(
					'RooftopID: 174',
					'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJlbWFpbCI6ImRodW1lQGRlYWxlcnBlYWsuY29tIiwidW5pcXVlX25hbWUiOiJVV0ZCWE85RDVRRllWOVhNS1lLNDA4VVpRV1BZTE5KTyIsInJvbGUiOiJBcGlVc2VyIiwiVXNlcklEIjoiMSIsIlVzZXJUeXBlIjoiU2VjdXJlMzYwLk1vZGVscy5BcGlVc2VyIiwiUm9vZnRvcElEIjoiIiwibmJmIjoxNjExMjY2MjE2LCJleHAiOjE3NjkwMzI2MTYsImlhdCI6MTYxMTI2NjIxNn0.wYPq97EXmjEUez3w7L-M0sSpTeWWTr-M-QupOrwVIAs',
					'Content-Type: application/json'
				),
			));

			$response = curl_exec($curl);
			$info     = curl_getinfo( $curl );

			curl_close($curl);

			echo $response;
			echo '<pre>';
			print_r( $info );
		}


		//$twilio = new TwilioController();
		//$twilio->callVoiceCode( $hirads_number, '12345' );


		//dd( $res );

		/*
		$twilio = new Twilio(env('TWILIO_SID'), env('TWILIO_TOKEN'), env('TWILIO_FROM'));

		$twilio->call( '+380672206192', function( VoiceResponse $message ){
			$message->say( 'Hello' );
			$message->play( 'https://api.twilio.com/cowbell.mp3', [ 'loop' => 5 ] );
		} );
		*/

		//Twilio::message( '+380672206192', $message );

		// $dbHost = new DBHostController();
		// $res = $dbHost->query();


		/*
		$s = new SitesHostSSHController();
		var_dump( $s->ssh_send_file(  Storage::disk( $s->wpconfig_storage )->path( $s->wpconfig_filename ), '/var/www/dealer_sites_auto/mercedes-benz.idweb.io/' . $s->wpconfig_filename ) );
		exit;
		*/

		// 0 - TEST PASSED
		// SitesController::process_just_created();

		// 1 - TEST PASSED
		// SitesController::process_without_files();

		// 2 - TEST PASSED
		// SitesController::process_with_empty_db();

		// 3 - TEST
		// SitesController::process_without_SSL();

		// 3 - TEST
		// SitesController::finalize_processing();

		//SitesController::delete_sites();

		dd( 'Your IP ' . $_SERVER['REMOTE_ADDR'] . ' logged to journal');
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
