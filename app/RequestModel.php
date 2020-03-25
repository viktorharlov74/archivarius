<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\BpModel;

class RequestModel extends Model
{
	public $req_insert=false;
	// protected $cell_info="";
	public function __construct($city=1,$organzitaion,$idbp,$otprv="",$sklad_poluch){
		$bp_obj=new BpModel($idbp);
		if ($bp_obj->bp_good){
			$this->bp=$bp_obj;
		}
		$this->organzitaion=$organzitaion;
		$this->sklad_poluch=$sklad_poluch;
		$this->city=$city;

		if($otprv!=""){
			$this->otprv=$otprv;
		}
		else $this->otprv=NULL;
		
		}

		public function createRequest(){
			if ($this->bp->bp_good){
				$id_req=DB::table('request')->insertGetId(
					  ['containers_num' => '0','organisation_id'=>$this->organzitaion,'finished'=>0,'overdue'=>0, 'is_cancelled'=>0,'business_process_id' => $this->bp->id,'target_storage_id'=>$this->sklad_poluch,'source_storage_id'=>$this->otprv,'creation_time'=>date("Y-m-d H:i:s")]
					);
				// echo "Заявка создана ";
				// dump($id_req);
				$steps=$this->bp->getSteps();
				foreach ($steps as $number=> $step) {
					$start_time= ($number==1) ? date("Y-m-d H:i:s") : NULL;
					$id_step=DB::table('step')->insertGetId(
					  ['request_id'=>$id_req,
					   'step_type_id'=>$step['step_type_id'],
					   'number'=>$number,
					   'start_time'=>$start_time ,
					   'iteration'=>1,
					   'name'=>$step['name'],
					   'close_type_id'=>$step['close_type_id'],
					   'container_status_id'=>$step['container_status_id'] ,
					   'responsible_position_id'=>4, 
					   'max_hours'=>10]);
					$steps[$number]['id']=$id_step;
					//echo "Шаг ". $id_step."добавлен";
				}
				// echo "Шаги";
				// dump($steps);
				return $id_req;
			}
			else return -1;
		}


}
