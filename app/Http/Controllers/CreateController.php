<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



//http://skladarchive/api/b0c28fe56071e710ddbe86e38ed4023a/requests/1236/addCorobs?corobs=WyJBc2RkYSIsImFzZGFzZCIsImFzZHNzYSJd
/**
 * 
 */


/*
Класс Токена для апи
*/



class CreateController extends Controller
{
  /**
   * Показать профиль данного пользователя.
   *
   * @param  int  $id
   * 
   */

  public function createParametrs(){
    $citys=DB::table('city')->where('deleted',0)->get();
    $client_organisations=DB::table('client_organisation')->where('deleted',0)->get();
    $bps=DB::table('business_process')->where('deleted',0)->get();
    $storage=DB::table('storage')->get();
    $arr_city= array();
    $arr_bp=array();
    $arr_sklad=array();
    foreach ($storage as $key => $value) {
      $citys_name=DB::table('city')->where('id',$value->id)->value('city');
      $arr_sklad[ $value->id]=$value->address." г. ".$citys_name;
    }
    var_dump($arr_sklad);
    foreach ($bps as $bp) {
      # code...
      $arr_bp[$bp->id]=$bp->name;
    }
    $client_organisation_arr[]=array();
    foreach ($client_organisations as $organization) {
      // array_push($client_organisation_arr[$organization->city_id],$organization->name)
      if (!isset($client_organisation_arr[$organization->city_id])){
        $client_organisation_arr[$organization->city_id]=[];
        $client_organisation_arr[$organization->city_id][$organization->id]=$organization->name;
      }
      else{
        $client_organisation_arr[$organization->city_id][$organization->id]=$organization->name;
      }
    }
    
    // var_dump($client_organisation_arr);
    foreach ($citys as $city) {
      // var_dump($city);
      $arr_city[$city->id]=$city->city;
      # code...
    }
    // var_dump($arr_city);
    return view('request', ['city' =>  $arr_city,'organizatinon'=>$client_organisation_arr,'arr_bp'=>$arr_bp,'sklad'=>$arr_sklad]);
  }

  public function Clear($str){

    $input_text = trim($str);
    $input_text = htmlspecialchars($input_text);
    // $input_text = mysql_escape_string($input_text);
    return $input_text;
  }

  public function store(Request $request)
  {
    $name = $request->input('token');

    //
  }
 

  public function corobsDecode($corobs){
    $corobs=$this->Clear($corobs);
    $obj_s=json_decode(base64_decode($corobs));
    return $obj_s;
  }
  public function show($token="",$id, Request $request)
  {

     


    
  }
}