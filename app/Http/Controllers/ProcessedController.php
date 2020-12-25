<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;

class ProcessedController extends Controller
{
    //
	public function execute() {
		return $sites = Site::where('processed', 0)->get('*');
	}
}
