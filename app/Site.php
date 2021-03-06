<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Site extends Model implements Searchable{

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
		'website_url', // Dealer cannot edit but can see
		'make',

		// Next fields only for admin
		'base_name',
		'document_root',
		'old_website_url',
		'old_website_favicon_src',
		'old_website_logo_src',
		'user_id',
		'server_ip',
		'vhost_filename',
		'vhost_ssl_filename',
		'db_name',
		'db_user',
		'db_pass',
		'creates_error',
		'last_error',
		'to_remove',
		'removed',
		'ssl_generated',
		'status',
	];

	public function icon(){
		return Storage::disk( 'public' )->url( $this->old_website_favicon_src );
	}

	public function logo(){
		return Storage::disk( 'public' )->url( $this->old_website_logo_src );
	}

	public function getSearchResult(): SearchResult{
		$url = route('sites.edit', $this->id);

		return new SearchResult(
			$this,
			$this->dealer_name,
			$url
		);
	}
}
