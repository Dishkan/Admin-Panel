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
			$table->string( 'dealer_name', 250 )->nullable();
			$table->string( 'lead_email', 250 )->nullable();
			$table->string( 'make', 250 )->nullable();
			$table->string( 'country', 250 )->nullable();
			$table->string( 'state', 250 )->nullable();
			$table->string( 'city', 250 )->nullable();
			$table->string( 'postal_code', 10 )->nullable();
			$table->string( 'dealer_number' )->nullable();
			$table->string( 'address', 250 )->nullable();

			// Admin fields

			// 0    - not processed at all.
			// 1    - created NS, virtual host files, site folder and empty DB.
			// 2    - files was copied and replaced DB credentials in wp-config.php.
			// 3    - DB was imported and replaced 2 wp_options table on the site DB.
			// 4    - SSL generated and added Redirect Rules to virtual host config file.
			// 5-99 - reserved
			// 100  - site ready to use
			$table->integer( 'status' )->default( 0 );

			$table->string( 'base_name' )->nullable();

			$table->string( 'old_website_url', 250 )->nullable();
			$table->string( 'old_website_favicon_src', 250 )->nullable();
			$table->string( 'old_website_logo_src', 250 )->nullable();

			// SSL
			$table->boolean( 'ssl_generated' )->default( false );

			// Remove
			$table->boolean( 'to_remove' )->default( false );
			$table->boolean( 'removed' )->default( false );

			// Hosting data
			$table->string( 'website_url', 255 )->nullable();
			$table->string( 'document_root', 255 )->nullable();
			$table->string( 'vhost_filename', 255 )->nullable();
			$table->string( 'vhost_ssl_filename', 255 )->nullable();
			$table->string( 'server_ip', 15 )->nullable();
			$table->string( 'db_name' )->nullable();
			$table->string( 'db_user' )->nullable();
			$table->string( 'db_pass' )->nullable();

			// Service data
			$table->boolean( 'creates_error' )->default(0);
			$table->text( 'last_error' )->nullable();

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
