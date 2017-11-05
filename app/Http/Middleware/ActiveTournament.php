<?php

namespace App\Http\Middleware;

use App\Tournament;
use Closure;

class ActiveTournament {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if ($request->getRequestUri() !== '/closed') {
			if (!$request->user() || !$request->user()->isAdmin()) {
				return redirect('/closed');
			}
			$tournament = Tournament::getActive();
			if (empty($tournament)) {
				return redirect('/');
			}
		}
		return $next($request);
	}
}
