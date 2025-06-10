<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlockLawyerFromUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
        public function handle(Request $request, Closure $next)
        {
            $user = Auth::user();

            if ($user && $user->role === 'Lawyer') {
                abort(403, 'Unauthorized access. Lawyers are not allowed to see user details.');
            }

            return $next($request);
        }
}
