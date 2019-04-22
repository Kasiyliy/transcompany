<?php

namespace App\Http\Middleware;

use Closure;

class Superviewer
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
        if(Auth::user()->isSuperviewer()){
            return $next($request);
        }else{
            Session::flash('warning' , 'Доступ запрещен!');
            return redirect()->back();
        }
    }
}
