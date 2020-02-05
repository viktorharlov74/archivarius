<?php

namespace App\Http\Controllers;

use App\FindCorobs;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FindController extends Controller
{
	public function Clear($str)
	  {

	    $input_text = trim($str);
	    $input_text = htmlspecialchars($input_text);
	    // $input_text = mysql_escape_string($input_text);
	    return $input_text;
	  }
    public function show(){
    	return view('findcorobs');
    }
    public function find(Request $request){
    	$res=str_replace(" ","",$this->Clear($request->input('q')));
    	$pieces = explode("\r\n", $res);
    	
    	$res_arr=[];
    	$res_arr_not_found=[];
    	foreach ($pieces as $corob) {
    		$obj_find=new FindCorobs($corob);
    		$res_item=$obj_find->findContainer($corob);
    		if (count($res_item)==0){
    			$res_arr_not_found[]=$corob;
    		}
    		else{
    			$res_arr[]=$res_item;
    		}
    		
    	}
    	// dump($res_arr);
    	return view('findcorobs',['res' =>  $res_arr,'not_found'=>$res_arr_not_found]);
    }
}
