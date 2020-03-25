<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers;
use App\RequestInfo;
use App\CellModel;
use App\ContainerModel;
use App\RequestModel;
use ActModel;
include_once $_SERVER['DOCUMENT_ROOT']."/ActModel.php";


use App\FindCorobs;



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
          	 return $request_zav->addContainerReq($request->corobs);
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
                return $request_zav->checkContainerReq($request->corobs,$request->next_status_id);
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


    public function getInfoCorobsInCells(Request $request){
          if($request->ajax()){
            $request_zav=new Controllers\RequestArchive($this->Clear($request->id));
            if ($request_zav->checkAcsessBD()){
                $rez_count=$request_zav->getCorobInCells($this->Clear($request->next_status_id));
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
                  if (count($reqInfo->showContainers())!=0){
                    if ($reqInfo->closeCurentStep($this->Clear($request->id_step))==true){
                      return json_encode(array('res' =>true ,'value'=> "Шаг успешно закрыт"));
                  }
                }
                else return json_encode(array('res' =>false ,'value'=> "Шаг не закрыт. Нужно добавить короба."));

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

        $cell=new CellModel($this->Clear($request->cell_id));
        if ($cell->isset_cell){
          
          $corobs=$cell->getCorobsCell();
          $arr_corobs=array();
          foreach ($corobs as $corob) {
            // $temp=array('code' => $corob->barcode );
            $corob_good=FindCorobs::findStaticContainer($corob->barcode);
            // dump($corob_good);
            // $temp['org']=
            // $arr_corobs.push($temp);
            array_push($arr_corobs, $corob_good);
          }

          $data_res=array('res'=>true,'cap' =>$cell->capacity,'filled'=>$cell->filled,'corobs'=>$arr_corobs,'cellcode'=>$cell->cell_code);
          // dump($data_res);
          return  json_encode($data_res);
        }
        else return json_encode(array('res' =>false ,'value_eror'=>"ячейка не найденна"));
        // 
        // 

        
        // echo "Получаем информацию о ячейке".$this->Clear($request->cell_id);
      }
     }


     public function addContainerInCell(Request $request){
      if($request->ajax()){
        $cell=new CellModel($this->Clear($request->cell_id));
        if ($cell->isset_cell){
          
          $container=new ContainerModel($request->container);

          if ($container->isset_container){
            if ($container->getRequestContainer()==$this->Clear($request->id_req)){            
              $res_insert=$cell->insertContainer($container->id);
              if ($res_insert==1) { return json_encode(array('res' =>true ,'value'=>"Короб ".$container->barcode." успешно установлен"));}
              else return json_encode(array('res' =>false ,'value'=>"Не удалось добавить контейнер"));
            }
            else return json_encode(array('res' =>false ,'value'=>"Контейнера нету в заявке"));

          }
          else  return json_encode(array('res' =>false ,'value'=>"Контейнер не найден"));
          
        }
        
      }
     }


       public function createRequest(Request $request){
         if($request->ajax()){
          $city=$this->Clear($request->city);
          $organzitaion=$this->Clear($request->organzitaion);
          $BP=$this->Clear($request->BP);
          $otprv=$this->Clear($request->otprv);
          $sklad_poluch=$this->Clear($request->sklad_poluch);
          $request_model=new RequestModel( $city,$organzitaion,$BP,$otprv,$sklad_poluch,$request);
          $id_req=$request_model->createRequest();
          return ($id_req!=-1) ? json_encode(array('res' =>true ,'id'=>$id_req, 'value'=>"Заявка создана")) : json_encode(array('res' =>false ,'value'=>"Заявка не создана"));
  



        }
      }


      public function closeRequest(Request $request){
        if($request->ajax()){
          
           $reqInfo=new RequestInfo($this->Clear($request->id));
           if($reqInfo->closeRequest()==1){
            return json_encode(array('res' =>true ,'value'=>"Заявка закрыта"));
           }
        }
      }

      public function cancelRequest(Request $request){
        if($request->ajax()){
          
           $reqInfo=new RequestInfo($this->Clear($request->id));
           $res_cansel=$reqInfo->cancelRequest();
           return ($res_cansel) ? json_encode(array('res' =>true , 'value'=>"Заявка отменена")) : json_encode(array('res' =>false ,'value'=>"Заявка не отменена! Какая-то ошибка!"));
           
        }
      }

      public function createAct(Request $request){
        if($request->ajax()){
          $id_req=$this->Clear($request->id);
          $reqInfo=new RequestInfo($id_req);
          $containers=$reqInfo->showContainers();
          $act=new ActModel($reqInfo->getId(),$containers,$organzitaion=$reqInfo->getCompany());
            return $act->CreateExel();
        }
      }



}
