<?php

namespace App\Http\Middleware;

use Closure;

class NewPosrednik
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
        //TODO Сделать проверку токем
        // if ($request->token!='2'){
        //    return redirect('AuthEror/');
        // }
        // echo $request->token;
        return $next($request);
    }
}
