<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutositesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autosites', function (Blueprint $table) {
            $table->id();
	        $table->string( 'type', 50 ); // enum of: group, oem, independent
	        $table->string( 'dealer_number' )->nullable();
	        $table->string( 'place_name', 250 )->nullable();
	        $table->string( 'dealer_email', 250 )->nullable();
	        $table->string( 'make', 250 )->nullable();
	        $table->string( 'old_website_url', 250 )->nullable();
	        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autosites');
    }
}
