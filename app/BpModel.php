<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BpModel extends Model
{
    public function showAll(){
    	$arr_bp_bd=DB::table('business_process')->where('deleted',0)->get();
    	$new_arr_bp=[];
    	foreach ($arr_bp_bd as $item_bp) {
    		$count_steps=DB::table('business_process_scenario')->where('business_process_id',$item_bp->id)->count();
    		$new_arr_bp[$item_bp->name]=$count_steps;
    		}
    	return $new_arr_bp;
	}
}
