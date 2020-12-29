<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class APIMiddleware{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle( Request $request, Closure $next ){
		if( ! $request->apikey || $request->apikey !== env( 'API_KEY' ) ){
			return response( 'Unauthorized.', 401 );
		}

		return $next( $request );
	}
}
