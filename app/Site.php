<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Site extends Model{
	protected $fillable = [
		'dealer_name',
		'lead_email',
		'country',
		'state',
		'city',
		'postal_code',
		'dealer_number',
		'address',
		'type',
		'place_name',
		'place_id',
		'old_website_url',
		'old_website_favicon_src',
		'old_website_logo_src',
		'user_id',
		'processed',
	];

	public function icon(){
		return Storage::disk( 'public' )->url( $this->old_website_favicon_src );
	}

	public function logo(){
		return Storage::disk( 'public' )->url( $this->old_website_logo_src );
	}
}
