<?php

namespace App\Http\Middleware;
use App\Http\Controllers\AuthmidlewareController;
use Illuminate\Support\Facades\Auth;
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

        // echo "Посредник123\n";
        // dump($request);
        $AuthController=new AuthmidlewareController();
        if ($AuthController->checkAuthRequest($request)==false)
        {
            return redirect()->route('login');
         // $AuthController->starts($request);
        }
        else return $next($request);
        //TODO Сделать проверку токем
        // if ($request->token!='2'){
        //    return redirect('AuthEror/');
        // }
        // echo $request->token;
        
    }
}
