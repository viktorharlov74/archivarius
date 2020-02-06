<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BpModel;
use Illuminate\Support\Facades\DB;


class BpController extends Controller
{
	public function show(Request $request)
    {
    	$Bp=new BpModel();
    	$arr_bp=$Bp->showAll();

    	return view('bp/businessprocesses',['arr_bp'=>$arr_bp]);
    }
}
