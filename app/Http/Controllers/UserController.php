<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
  /**
   * Показать профиль данного пользователя.
   *
   * @param  int  $id
   * 
   */

    public function store(Request $request)
  {
    $name = $request->input('token');

    //
  }
  public function show($token="",$id, Request $request)
  {

    if ($request->has('token')) {
  // 


    if ($request->input('token')=='3'){
           return "Результат контроллера ".$id.$token;
    }
    else{
      return "Erors2";
    }
}
    echo $request->q;
    if ($request->token=='2'){
           return "Результат контроллера ".$id.$token;
    }
    else{
      return "Erors";
    }
    
  }
}