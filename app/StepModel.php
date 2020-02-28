<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StepModel extends Model
{
	public function __construct($id_req,$id_step){
		$this->id_req=$id_req;
		$this->id_step=$id_step;
		$step_info=DB::table('step')->where([['id',$id_step],['request_id',$id_req]])->get();
		echo "infostep";
		 // var_dump($step_info);
		// dump($step_type_id);
		$this->step_type_id=$step_info[0]->step_type_id;
		$this->name_step=$step_info[0]->name;
		$this->number=$step_info[0]->number;
		$this->next_status_id=DB::table('step_type')->where('id',$this->step_type_id)->pluck('container_status_id')->first();
		$this->close_type_id=$step_info[0]->close_type_id;

		 // dump($this->close_type_id);
		$this->typeStep=DB::table('step_close_type')->where('id',$this->step_type_id)->get()->first();
		// dump($this->close_type);
		/*
		6-Без проверки
		5-По запросу
		7-Проверка дубликатов контейнеров
		2=Проверка кодов контейнеров
		3=Проверка кодов контейнеров и ячеек
		4=Проверка кодов контейнеров и ячеек (авто)
		1-Проверка количества контейнеров (от забора до) 
		*/
	}
	public function getTypeStep(){
		return $this->typeStep;
	}
	public function getCloseTypeStep(){
		return $this->close_type_id;
	}
	public function getIdStep(){
		return $this->id_step;
	}
	public function getIdReq(){
		return $this->id_req;
	}
	public function getIdNextStatus(){
		return $this->next_status_id;
	}
    //
}
