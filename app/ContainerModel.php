<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContainerModel extends Model{
	public $isset_cell=false;
	public $isset_container=false;
	public function __construct($container){

		$container_info=DB::table('container')->where('barcode',$container)->first();
		// dump($container_info);
		if ( is_null($container_info)==false){
			$this->id=$container_info->id;
			$this->barcode=$container_info->barcode;
			$this->organisation_id=$container_info->organisation_id;
			$this->cell_id=$container_info->cell_id;
			$this->isset_container=true;
		}
	}

	public function getRequestContainer(){
		if($this->isset_container==true){
			$req_info=DB::table('container_request')->where('container',$this->id)->first();
			if ( is_null($req_info)==false){
				$this->request=$req_info->request;
				return $this->request;
			}
			else return -1;
		}
		else return -1;
		
	}


}