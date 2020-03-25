<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BpModel extends Model
{
	public $bp_good=false;

	public function __construct($id){
		$bp=DB::table('business_process')->where('id',$id)->first();
		if (is_null($bp)==false){
			$this->bp_good=true;
			$this->name=$bp->name;
			$this->id=$bp->id;
		}
	}
	public function getSteps($id=""){
		if ($id==""){
			$id=$this->id;
		}
		$bp_steps=DB::table('business_process_scenario')->where('business_process_id',$id)->get();
		$steps_arr=[];
		foreach ($bp_steps as $step) {
			$step_info=DB::table('step_type')->where('id',$step->step_type_id)->get()->first();
			$temp_info=[];
			$temp_info['step_type_id']=$step->step_type_id;
			$temp_info['name']=$step_info->name;
			$temp_info['close_type_id']=$step_info->close_type_id;
			$temp_info['container_status_id']=$step_info->container_status_id;
			$temp_info['container_status_name']=DB::table('container_status')->where('id',$step_info->container_status_id)->get()->first()->name;
			$temp_info['close_type_name']=DB::table('step_close_type')->where('id',$step_info->close_type_id)->get()->first()->name;
			$steps_arr[$step->step_num]=$temp_info;
			
			}
			$this->arr_steps=$steps_arr;
			return $steps_arr;
		}
    public static function showAll(){
    	$arr_bp_bd=DB::table('business_process')->where('deleted',0)->get();
    	$new_arr_bp=[];
    	foreach ($arr_bp_bd as $item_bp) {
    		$new_arr_bp[$item_bp->id]=[];
    		$temp=[];
    		$count_steps=DB::table('business_process_scenario')->where('business_process_id',$item_bp->id)->count();
    		$temp['name']=$item_bp->name;
    		$temp['count']=$count_steps;
    		$new_arr_bp[$item_bp->id]=$temp;
    		}
    	return $new_arr_bp;
	}

	public function getNameBp($id){
		return $this->name;
	}
}
