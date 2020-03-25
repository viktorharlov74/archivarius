<?php

namespace App\Http\Controllers;

use App\Requests;
use App\RequestInfo;
use App\StepModel;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequestController extends Controller
{

  public function requestinfo(Request $request)
  {

	  	$id=$this->Clear($request->id);
	  	$reqInfo=new RequestInfo($id);
	  	$containers=$reqInfo->showContainers();
	  	$company=$reqInfo->getCompany();

		$curent_steps=$reqInfo->currentStep();

	  	if (!$reqInfo->isFinished()){
		  	$numer_current_step=$reqInfo->getNumberCurrentStep();
		  	
		  	return view('requestinfo',['id'=>$id,'containers'=>$containers,'curent_steps'=>$curent_steps,'numer_current_step'=>$numer_current_step,'company'=>$company,'bp'=>$reqInfo->getBP()]);
	  	}
	  	else return view('requestClose',['id'=>$id,'cancel'=>$reqInfo->isCanceled(),'containers'=>$containers,'curent_steps'=>$curent_steps,'company'=>$company,'bp'=>$reqInfo->getBP()]);
	  	 
  }

  public function closeStep(Request $request)
  {
  	$id=$this->Clear($request->id);
  	$requests_obj=new Requests;
	$requests=$requests_obj->getRequsets();
	$company=$requests[$id]['org'];	
  	$reqInfo=new RequestInfo($id);
  	$containers=$reqInfo->showContainers();
  	$step=new StepModel($id,$request->id_step);
  	$curent_step=$reqInfo->getCurrentStep();
  	//echo "Текущий шаги заявкasи";
  	//dump($curent_step);
  	if ($curent_step!=$request->id_step){
  		return view ('closestep/eror_no_close_step',["id_request"=>$request->id]);
  		// return "";
  	}
  	$step_id=$step->getStepTypeId();

  	  	/*
1 забор у клиента
2 погрузка в машину
3 транспортировка

4 прием складом
5 размещение на складе
6 ручное размещение на складе
7 автоматическое размещение на складе
8 забор со склада
9 прием экспедитором
10 прием клиентом
11 временное изъятие контейнера
12 безвозвратное изъятие контейнера


  	*/
  	switch ($step_id) {
  		case 1:
  			return view ('closestep/zabor_corobs',["id_request"=>$id,'containers'=>$containers,'step_model'=>$step]);
  			break;

  		case 2:
  		echo "проверка шага со сканированием коробов";
  		return view ('closestep/checkcodecorobs',["id_request"=>$id,'containers'=>$containers,'step_model'=>$step]);
  			break;

  		case 3:
  			return view ('closestep/closestep_no_check',["id_request"=>$id,'step_model'=>$step]);
  			break;
  		case 4:
  		echo "проверка шага со сканированием коробов";
  		return view ('closestep/checkcodecorobs',["id_request"=>$id,'containers'=>$containers,'step_model'=>$step]);
  			break;

  		case 5:
  			$containers_new=$reqInfo->showContainersandCells();
  			return view ('closestep/pogruzka_na_polki',["id_request"=>$id,'containers'=>$containers_new,'step_model'=>$step,'company'=>$company]);
  			break;
  		
  		default:
  			return "Выполняется закрытие шага";
  			break;
  	}



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

  public function showrequest(){
	 	$requests_obj=new Requests;
	  	$requests=$requests_obj->getRequsets();
	  	return view('requests',["zaiv"=>$requests]);
  }

  public function addCorobs(Request $request){
	$id=$this->Clear($request->id);
  	$reqInfo=new RequestInfo($id);
  	$containers=$reqInfo->showContainers();
  	return view ('requestaddCorobs',["id_request"=>$id,'containers'=>$containers]);
  }
  public function createParametrs()
	  {
		    $citys=DB::table('city')->where('deleted',0)->get();
		    $client_organisations=DB::table('client_organisation')->where('deleted','<>',1)->get();
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
		    dump($arr_city);
		    return view('requestadd', ['city' =>  $arr_city,'organizatinon'=>$client_organisation_arr,'arr_bp'=>$arr_bp,'sklad'=>$arr_sklad]);
	  }

  public function Clear($str)
	  {

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
}
