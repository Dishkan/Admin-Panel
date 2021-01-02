<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create( 'sites', function( Blueprint $table ){
			$table->increments( 'id' );
			$table->timestamps();
			$table->string( 'type', 50 ); // enum of: group, oem, independent
			$table->string( 'place_name', 250 )->nullable();
			$table->string( 'place_id', 250 )->nullable();
			$table->string( 'old_website_url', 250 )->nullable();
			$table->string( 'old_website_favicon_src', 250 )->nullable();
			$table->string( 'old_website_logo_src', 250 )->nullable();
			$table->string( 'dealer_name', 250 )->nullable();
			$table->string( 'lead_email', 250 )->nullable();
			$table->string( 'country', 250 )->nullable();
			$table->string( 'state', 250 )->nullable();
			$table->string( 'city', 250 )->nullable();
			$table->string( 'postal_code', 10 )->nullable();
			$table->string( 'dealer_number' )->nullable();
			$table->string( 'address', 250 )->nullable();
			$table->boolean( 'processed' )->default( 0 );

			// Hosting data
			$table->string( 'document_root', 255 )->nullable();
			$table->string( 'website_url', 255 )->nullable();
			$table->string( 'server_ip', 15 )->nullable();
			$table->string( 'db_name' )->nullable();
			$table->string( 'db_user' )->nullable();
			$table->string( 'db_pass' )->nullable();

			$table->integer( 'user_id' )->unsigned()->default( 1 );
			$table->foreign( 'user_id' )->references( 'id' )->on( 'users' );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::dropIfExists( 'sites' );
	}
}
