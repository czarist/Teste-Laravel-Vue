<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if(Auth::user()->root) {
            return $next($request);
        }

        foreach($roles as $role) {
            if(Auth::user()->hasRole($role)) {
                return $next($request);
            }
        }

        return abort(401, 'Acesso negado.');
    }
}
