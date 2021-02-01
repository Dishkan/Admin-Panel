<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autosite extends Model
{
	protected $fillable = [
		'type',
		'place_name',
		'old_website_url',
		'dealer_number',
		'dealer_email',
		'make',
		'verify_method'
	];
}
