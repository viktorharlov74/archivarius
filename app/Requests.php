<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Requests extends Model
{
	public function __construct(){
		$reqs=DB::table('request')->where('finished',0)->get();
		$arr_req=[];
		foreach ($reqs as $item) {
			$arr_req[$item->id]=[];
			$arr_req[$item->id]['org']=DB::table('client_organisation')->where('id',$item->organisation_id)->get()->first()->name;
			$arr_req[$item->id]['bp']=DB::table('business_process')->where('id',$item->business_process_id)->get()->first()->name;
			$stor=DB::table('storage')->where('id',$item->target_storage_id)->get()->first();
			$arr_req[$item->id]['adr']=$stor->address;
			$arr_req[$item->id]['sity']=DB::table('city')->where('id',$stor->city_id)->get()->first()->city;
			$arr_req[$item->id]['allcorobs']=$item->containers_num;
			$arr_req[$item->id]['start']=$item->start_time;
			// $arr_req['start']=DB::table('client_organisation')->where('id',$item->id)->get()->first();


			# code...
		}
		$this->arr_req=$arr_req;
		
	}
	public function find(){
		  // $arr_req=DB::table('request')->where('finished',0)->get();
		return   $this->arr_req;
	}
    //
}

/**
 * 
 */

