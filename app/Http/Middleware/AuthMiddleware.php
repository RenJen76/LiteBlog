<?php

namespace App\Http\Middleware;

use Closure;
// use Illuminate\Auth\AuthenticationException;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $IsLogin    = false;
        $UserID     = session()->get('UserID');
        
        if(!is_null($UserID)){
            $IsLogin= true;
        }

        if($IsLogin === false){
            return redirect('/auth/login');
            // throw new AuthenticationException('Unauthenticated.');
        }

        return $next($request);
    }
}
