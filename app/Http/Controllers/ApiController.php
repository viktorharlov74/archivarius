<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


abstract class PublicationCheck {
  abstract public function checkAcsessBD();

}
//http://skladarchive/api/b0c28fe56071e710ddbe86e38ed4023a/requests/1236/addCorobs?corobs=WyJBc2RkYSIsImFzZGFzZCIsImFzZHNzYSJd
/**
 * 
 */


/*
Класс Токена для апи
*/

class Token extends PublicationCheck
{
  
  function __construct($token)
  {
    $this->token=$token;
    $this->acses=false;
  }

  public function Clear($str){

    $input_text = trim($str);
    $input_text = htmlspecialchars($input_text);
    // $input_text = mysql_escape_string($input_text);
    return $input_text;
  }
  public function checkAcsessBD(){
    $input_token = $this->Clear($this->token);
    if (strlen($input_token)==32){
      $results = DB::table('users_api')->where('remember_token',$input_token)->get();
      if (count($results)==1){
        // echo (count($results)." Результат токена");
        $this->acses=true;
        return true;
      }
      else return false;

    }
    return false;
  }
}


//Класс Заявки

class RequestArchive extends PublicationCheck{
    function __construct($id)
  {
    $this->id=$id;
    $this->acses=false;
  }
    public function Clear($str){

    $input_text = trim($str);
    $input_text = htmlspecialchars($input_text);
    // $input_text = mysql_escape_string($input_text);
    return $input_text;
  }
  public function checkAcsessBD(){
    $id = $this->Clear($this->id);
    $results = DB::table('request')->where([
                                            ['id',$id],
                                            ['finished',0],
                                            ])->get();
     if (count($results)==1){
        // echo "Результат заявки \n";
        // var_dump($results);
        $this->status_id=1;
        foreach ($results as $result) {          
          $this->organisation_id=$result->organisation_id;
          $this->containers_num=$result->containers_num;
          break;
        }
        
        //Добавить поля организации и статуса в класс
        $this->acses=true;

        return true;
      }
    else{
      return false;
    }
  }
  public function getContainerId($codecorob){
    $corobs_id=DB::table('container')->where('barcode',$codecorob)->get();
    if (count($corobs_id)!=0){
      echo $corobs_id->first()->barcode." Такой короб уже есть";
      return $corobs_id;
    }
    return array();
  }
  public function addContainer($corob){

    $id_arr=$this->getContainerId($corob);
    // var_dump($id_arr);
     if (count($id_arr)==0){
       $id=DB::table('container')->insertGetId([
               'status_id' => $this->status_id,
               'barcode' => $corob,
               'qr_code' => $corob,
                'cell_checked'=>1,
               'organisation_id' =>$this->organisation_id,
               'destroyed'=>0,
               'duplicate'=>0,
               'deadline' => '2023-01-31 00:00:00',
                ]);
       echo "Добавляю контейнер в список коробов";
       return $id;
     }
     else return $id_arr->first()->id;    
  }

  public function addContainerReq($corob){
    if ($this->acses==true){
      $id=$this->addContainer($corob);
      $count_container=DB::table('container_request')->where(['container'=>$id,'request'=>$this->id,])->get();
      //TODO: надо проверить нету ли контайров в другой активной заявки
      if (count($count_container)!=0){
         echo "Этот короб уже добавлен";
          return false;
      }
       $rez=DB::table('container_request')->insertGetId([
        'container'=>$id,
        'request'=>$this->id,
       ]);
       $this->containers_num+=1;
       DB::table('request')->where('id',$this->id)->update(['containers_num' => $this->containers_num]);
       return true;
    }
  }
  public function addContainersReq($corobs){
    if ($this->acses==true){
      foreach ($corobs as $corob) {
        $id=$this->addContainer($corob);
        $count_container=DB::table('container_request')->where(['container'=>$id,'request'=>$this->id,])->get();
        if (count($count_container)!=0){
          echo "Этот короб уже добавлен";
            continue;
        }
         $rez=DB::table('container_request')->insertGetId([
          'container'=>$id,
          'request'=>$this->id,
         ]);
         $this->containers_num+=1;
         DB::table('request')->where('id',$this->id)->update(['containers_num' => $this->containers_num]);

        # code...
      }
    }

  }
}


class ApiController extends Controller
{
  /**
   * Показать профиль данного пользователя.
   *
   * @param  int  $id
   * 
   */

  public function Clear($str){

    $input_text = trim($str);
    $input_text = htmlspecialchars($input_text);
    // $input_text = mysql_escape_string($input_text);
    return $input_text;
  }
  public function TokenAccses($token)
  {
    $input_token = $this->Clear($token);
    echo (strlen($input_token).' Длина токена');
    if (strlen($input_token)==32){

          $results = DB::select('select * from users_api where remember_token = :remember_token', ['remember_token' => $input_token]);
        echo ($results." Результат токена");
        return true;

    }
    else{
      return false;
    }

  }
  public function store(Request $request)
  {
    $name = $request->input('token');

    //
  }
  public function addCorobs(Request $request)
  {        
    // $t =random_bytes(16); 
    // echo bin2hex($t);
    $token=new Token($request->token);
    if ($token->checkAcsessBD()==true)
    {
      $req_id=intval($this->Clear($request->id));
      $request_zav=new RequestArchive($req_id);
      if ($request_zav->checkAcsessBD()){
          $corobs =$this->corobsDecode($this->Clear($request->input('corobs')));
          var_dump($corobs);
          $request_zav->addContainersReq($corobs);
        return "Заявка найдена и активна, короба должны быть добавленны";//Добавить короба в таблицу коробок и добавить короба в промежуточную таблицу короба и заявок

      }
      else
      {
        return "Заявка не найдена";
      }
      
        //var_dump($corobs);

          // var_dump(DB::insert('INSERT INTO container (id, status_id, cell_id, cell_checked, barcode, qr_code, destroyed, duplicate, organisation_id, deadline) VALUES (NULL, 1, NULL, NULL,:barcode ,:qr_code , NULL, NULL,:organisation_id ,:deadline ); ',['barcode'=>$corob,'qr_code'=>$corob,'organisation_id'=>'53','deadline'=>'2023-01-31 00:00:00']));
         /* $id=DB::table('container')->insertGetId([
               'status_id' => 1,
               'barcode' => $corob,
               'qr_code' => $corob,
                'cell_checked'=>1,
               'organisation_id' => 53,
               'destroyed'=>0,
               'duplicate'=>0,
               'deadline' => '2023-01-31 00:00:00',
                ]);*/

        // return "Какие короба добавить?";
        //Добавить контейнер и добавить его в таблицу container request
    }
    else{
      return "Доступ запрещён";
    }

  }

  public function corobsDecode($corobs){
    $corobs=$this->Clear($corobs);
    $obj_s=json_decode(base64_decode($corobs));
    return $obj_s;
  }
  public function show($token="",$id, Request $request)
  {

     


    // echo $request->q;
    if ($request->token=='2'){
      if ($request->has('corobs')) {
        $obj_s=json_decode(base64_decode($request->input('corobs')));
        // foreach ($obj_s as $key => $value) {
        //    echo $value."\n";
        //  }
           return response()->json($obj_s);
        }
      
      else{
        return "EEE";
      }
    }
    else{
      return "Erors";
    }
    
  }
}