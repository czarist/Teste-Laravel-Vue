<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Roles
{
    public function handle($request, Closure $next, ...$roles)
    {
        if(!Auth::user()->ativo || Auth::user()->ativo === 0) {
            Auth::logout();
            Log::info('User Not Alowed: ' . Auth::user());
            return redirect()->back()->withErrors(["email" => "Essas crendências não possuem acesso ao sistema."]);
        }  
        if(Auth::user()->is_root)
            return $next($request);
        else if(Auth::user()->is_admin && $request->route()->uri != 'config/usuarios')
            return $next($request);

        foreach($roles as $role) {
            if(Auth::user()->hasRole($role))
                return $next($request);
        }
        return abort(403, 'Acesso negado.');
    }
}
