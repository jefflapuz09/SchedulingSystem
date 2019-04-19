<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class checkIfActivated
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
        if(Auth::user()->is_first_login == 1){
            return redirect(url('home'));
        }
        
        return $next($request);
    }
}
