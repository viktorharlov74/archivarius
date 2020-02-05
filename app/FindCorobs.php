<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FindCorobs extends Model
{
    public function __construct($corobs='')
    {
    	$this->corobs=$corobs;
    }
    public function findContainer($container=""){
    	if ($container==""){
    		$container=$this->corobs;
    	}
    	$containers=DB::table('container')->where('barcode',$container)->get();
    	$result_arr=[];
    	if (count($containers)>0){
    		foreach ($containers as $container) {
    			$result_arr[$container->id]=[];
    			$result_arr[$container->id]['barcode']=$container->barcode;
    			$cell=DB::table('cell')->where('id',$container->cell_id)->get()->first();
				$org=DB::table('client_organisation')->where('id',$container->organisation_id)->get()->first();
				$result_arr[$container->id]['org']=$org->name;
				if ($cell!=NULL){
					$result_arr[$container->id]['cellcode']=$cell->code;
				}
				else{
					$result_arr[$container->id]['cellcode']="Без ячейки";
				}
				
				$result_arr[$container->id]['status']=DB::table('container_status')->where('id',$container->status_id)->get()->first()->name;
    		}
    		return $result_arr;
    	}
    	else return array();

    }
}
