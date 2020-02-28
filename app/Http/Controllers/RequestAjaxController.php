<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers;
use App\RequestInfo;

class RequestAjaxController extends Controller
{
    public function Clear($str){

    $input_text = trim($str);
    $input_text = htmlspecialchars($input_text);
    // $input_text = mysql_escape_string($input_text);
    return $input_text;
  }
    //
	protected function getTokenApi($id){
    		$results = DB::table('users_api')->where([['id',$id]])->get();
    		if (count($results)==1){
    			$token=$results->first()->remember_token;
    			return $token;
    		}
    		else return false;

  	}

    public function addCorobs(Request $request){
    	if($request->ajax()){
    		// var_dump(($request->session()->all()));
    		// echo("Получение токена123");
    		$token=$this->getTokenApi($request->session()->get('user'));
            //Нужна проверка прав пользовател
    		// echo "ID";
    		// echo ($this->Clear($request->id));
    		$str="home";
    		$request_zav=new Controllers\RequestArchive($this->Clear($request->id));
    		// var_dump($request_zav);
    		if ($request_zav->checkAcsessBD()){
          		//$corobs =$this->corobsDecode($this->Clear($request->input('corobs')));
          	 // var_dump($request->corobs);
          	 $request_zav->addContainerReq($request->corobs);
          	}
        	//return "Заявка найдена и активна, короба должны быть добавленны";//Добавить короба в таблицу коробок и добавить короба в промежуточную таблицу короба и заявок

		// return "AJAX";
		}
		else return "http";
    }

     public function checkCorobs(Request $request){
        if($request->ajax()){
            $request_zav=new Controllers\RequestArchive($this->Clear($request->id));
            // var_dump($request_zav);
            if ($request_zav->checkAcsessBD()){
                $request_zav->checkContainerReq($request->corobs,$request->next_status_id);
            }
        }
     }

     public function getInfoCorobs(Request $request){
          if($request->ajax()){
            $request_zav=new Controllers\RequestArchive($this->Clear($request->id));
            if ($request_zav->checkAcsessBD()){
                $rez_count=$request_zav->getOstCorobs($this->Clear($request->next_status_id));
                return json_encode($rez_count);
            }

          }
          else return "Доступ запрещён";

     }

     public function closeStep(Request $request){
        if($request->ajax()){
            $request_zav=new Controllers\RequestArchive($this->Clear($request->id));
            if ($request_zav->checkAcsessBD()){
                $reqInfo=new RequestInfo($this->Clear($request->id));
                if ($reqInfo->closeCurentStep($this->Clear($request->id_step))==true){
                    echo "Шаг успешно закрыт";
                };
                // $rez_count=$request_zav->getOstCorobs($this->Clear($request->next_status_id));
                // return json_encode($rez_count);
            }

          }
        else return "Доступ запрещён";
     }

     public function closenocheckStep(Request $request){
      if($request->ajax()){
            $request_zav=new Controllers\RequestArchive($this->Clear($request->id));
            if ($request_zav->checkAcsessBD()){
              $reqInfo=new RequestInfo($this->Clear($request->id));
               if ($reqInfo->closeCurentStep($this->Clear($request->id_step))==true){
                    echo "Шаг успешно закрыт";
                };
            }
        // echo "Закрываем шаг без проверки";
      }
      else return  "Доступ запрещён";
     }

     public function getInfoCell(Request $request){
      if($request->ajax()){
        
        echo "Получаем информацию о ячейке".$this->Clear($request->cell_id);
      }
     }



}
