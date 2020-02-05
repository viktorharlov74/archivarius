<?php

namespace App\Http\Middleware;


use Closure;
class TokenAuth extends Middleware
{ /**
   * Обработка входящего запроса.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next,$token)
  {

    return $next($request);
  }
}
