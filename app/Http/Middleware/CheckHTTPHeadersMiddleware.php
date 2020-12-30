<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckHTTPHeadersMiddleware{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle( Request $request, Closure $next ){
		if( $request->headers->has('dgdev') && env('DGDEV') === $request->headers->get('dgdev') ){
			return $next( $request );
		}

		return response( 'Unauthorized', 401 );
	}
}
