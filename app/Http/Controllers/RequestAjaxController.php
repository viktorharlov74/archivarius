<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers;

class RequestAjaxController extends Controller
{
    //
	protected function getTokenApi($id){
    		$results = DB::table('users_api')->where([['id',$id]])->get();
    		if (count($results)==1){
    			$token=$results->first()->remember_token;
    			return $token;
    		}
    		else return false;

  	}

    public function addCorobs(Request $request){
    	if($request->ajax()){
    		// var_dump(($request->session()->all()));
    		echo("Получение токена");
    		$token=$this->getTokenApi($request->session()->get('user'));
    		echo "ID";
    		echo ($request->id);
    		$str="home";
    		$request_zav=new Controllers\RequestArchive($request->id);
    		// var_dump($request_zav);
    		if ($request_zav->checkAcsessBD()){
          		//$corobs =$this->corobsDecode($this->Clear($request->input('corobs')));
          	var_dump($request->corobs);
          	$request_zav->addContainerReq($request->corobs);
          	}
        	//return "Заявка найдена и активна, короба должны быть добавленны";//Добавить короба в таблицу коробок и добавить короба в промежуточную таблицу короба и заявок

		return "AJAX";
		}
		else return "http";
    }
}
