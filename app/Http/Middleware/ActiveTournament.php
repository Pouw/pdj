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
		$tournament = Tournament::getActive();
		if (empty($tournament) || !$tournament->isOpen()) {
			$request->session()->flash('alert-danger', 'All registration has been closed.');
			return redirect('/');
		}
		return $next($request);
	}
}
