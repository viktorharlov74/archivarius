<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RequestInfo extends Model
{
    function __construct($id)
	{
		$this->id=$id;
		$this->count_steps=count(DB::table('step')->where('request_id',$id)->get());
	}
	protected function isCurentStep($start_time,$end_time){
		if (is_null($end_time)){
			if (is_null($start_time)){
				return "Не начат";
			}
			else{
				return "Исполняется";
			}
		}
		else return "Закрыт";

	}

	public function getCurrentStep(){
		$curent_table_steps=DB::table('step')->where('request_id',$this->id)->get();
		foreach ($curent_table_steps as $step) {
			$temp_curent=$this->isCurentStep($step->start_time,$step->end_time);
			if ($temp_curent=="Исполняется"){
				$this->current_step=$step->id;
				return $this->current_step;
			}
		}
		return -1;
	}

	public function currentStep(){
		// SELECT * FROM `step` ORDER BY `request_id` DESC LIMIT 10;
		$curent_table_steps=DB::table('step')->where('request_id',$this->id)->get();
		
		$steps_arr=[];
		foreach ($curent_table_steps as $step) {
			// $step_info=DB::table('step_type')->where('id',$step->step_type_id)->get()->first();
			$temp_info=[];
			$temp_info['name']=$step->name;
			$temp_info['id']=$step->id;
			$temp_info['curent']=$this->isCurentStep($step->start_time,$step->end_time);
			if ($temp_info['curent']=="Исполняется"){
				$this->current_step=$step->id;
			}
			$temp_info['start_time']=$step->start_time;
			$temp_info['end_time']=$step->end_time;			
			$temp_info['max_hours']=$step->max_hours;
			$temp_info['close_type_id']=$step->close_type_id;
			$temp_info['container_status_id']=$step->container_status_id;
			$temp_info['container_status_name']=DB::table('container_status')->where('id',$step->container_status_id)->get()->first()->name;
			$temp_info['close_type_name']=DB::table('step_close_type')->where('id',$step->close_type_id)->get()->first()->name;
			$steps_arr[$step->number]=$temp_info;
			
			}

		return $steps_arr;
	}

	public function closeCurentStep($id_step=""){
		if ($id_step==""){
			$id_step==$this->getCurrentStep();
			if ($id_step==-1){
				return false;
			}
		}
		$curent_table_steps=DB::table('step')->where('request_id',$this->id)->get();
		foreach ($curent_table_steps as $step) {
			if (($this->isCurentStep($step->start_time,$step->end_time)=="Исполняется") and ($id_step==$step->id))
			{
				if ($this->count_steps>$step->number){
					$new_number=$step->number+1;
					echo "Закрыли шаг: ".$step->id;
					$close=DB::table('step')->where('id',$step->id)->update(['end_time' => date("Y-m-d H:i:s")]);
					$this->current_step=DB::table('step')->where(['request_id'=>$this->id,'number'=>$new_number])->get()->first();
					dump($this->current_step);
					$new_curent_step=DB::table('step')->where(['id'=>$this->current_step->id])->update(['start_time' => date("Y-m-d H:i:s")]);
					echo "Новый шаг: ";
					dump($this->current_step->id);
					return true;
				}
				else if($this->count_steps==$step->number){
					$close=DB::table('step')->where('id',$step->id)->update(['end_time' => date("Y-m-d H:i:s")]);
					return true;
				}
				// $this->current_step=DB::table('step')->where(['request_id'=>$this->id,'number'=>$step->number])->get();

			}
		}
		return false;
	}

	public function showStatus(){}

	public function showContainers(){
		// container_request
		$containers=DB::table('container_request')->where('request',$this->id)->get();
		$container_arr=[];
		foreach ($containers as $container ) {
			$container_arr[$container->container]=[];
			$container_arr[$container->container]=DB::table('container')->where('id',$container->container)->get()->first();
		}
		// dump($this->id);
		return $container_arr;
	}
}
