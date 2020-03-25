<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CellModel extends Model
{
	public $isset_cell=false;
	// protected $cell_info="";
	public function __construct($code_cell){
		$this->code=$code_cell;
		$cell_info=DB::table('cell')->where('code',$code_cell)->first();
		if ( is_null($cell_info)==false){
			$this->cell_info=$cell_info;
			$this->capacity=$cell_info->capacity;
			$this->filled=$cell_info->filled;
			$this->id=$cell_info->id;
			$this->isset_cell=true;
			$this->cell_code=$cell_info->code;
		}



	}

	protected function updateFiled(){
		if ($this->filled<$this->capacity){
			$this->filled+=1;
			$res=DB::table('cell')->where('id',$this->id)->update(['filled'=>$this->filled]);
			//dump($res);
			
			return true;
		}
		else false;
	}

	public function insertContainer($id_container){
		$container=DB::table('container')->where('id',$id_container)->first();
		if (is_null($container->cell_id)){
			if ($this->updateFiled()){
				$res=DB::table('container')->where('id',$id_container)->update(['cell_id'=>$this->id]);
			}
			else {
				$res=false;
			}
		}
		else return false;

		
		return $res;
	}

	public function getCorobsCell(){
		$this->corobsCell=DB::table('container')->where('cell_id',$this->getCellId())->get();
		// dump()
		return $this->corobsCell;
	}

	public function getCellId(){
		if ( isset($this->cell_info)){
			return $this->cell_info->id;
		}
		else{
			return -1;
		}
	}

	public function addCorobs($corob){
		
	}

    //
}
