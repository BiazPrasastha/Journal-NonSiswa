<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class isLogin
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
        if(Auth::user()){
            return $next($request);
        }else{
            alert()->error('','Eitss Tidak Bisa')->background('#3B4252')->autoClose(2000);
            return redirect('/login');
        }
    }
}
