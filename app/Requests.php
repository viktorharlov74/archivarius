<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Requests extends Model
{
	public static function find(){
		  $arr_req=DB::table('request')->where('finished',0)->get();
		return   $arr_req;
	}
    //
}
