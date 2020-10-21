<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class isAdmin
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
        if (Auth::user()->role == "2") {
            return $next($request);
        } else {
            alert()->error('','Eitss Tidak Bisa')->background('#3B4252')->autoClose(2000);
            return redirect('/jurnal');
        }

    }
}
