<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RequestInfo extends Model
{
    function __construct($id)
	{
		$this->id=$id;
	}

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
