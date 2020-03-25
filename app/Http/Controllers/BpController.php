<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BpModel;
use Illuminate\Support\Facades\DB;


class BpController extends Controller
{
	public function show(Request $request)
    {
     	$arr_bp=BpModel::showAll();
    	return view('bp/businessprocesses',['arr_bp'=>$arr_bp]);
    }

    public function stepsBp(Request $request){
        $id=$request->id;
    	$Bp=new BpModel($id);
    	
    	$arr_steps_bp=$Bp->getSteps($id);
    	$name=$Bp->getNameBp($id);
    	ksort($arr_steps_bp);
    	dump($arr_steps_bp);

    	return view('bp/bpsteps',['arr_steps'=>$arr_steps_bp,'name_bp'=>$name]);
    }
}
