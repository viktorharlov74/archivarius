<?php


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;



abstract class PublicationCheck {
  abstract public function checkAcsessBD();

}

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
        echo "Результат заявки \n";
        var_dump($results);
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
  public function addContainer($corob){

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
    return $id;
  }

  public function addContainersReq($corobs){
    if ($this->acses==true){
      foreach ($corobs as $corob) {
        $id=$this->addContainer($corob);
         $rez=DB::table('container_request')->insertGetId([
          'container'=>$id,
          'request'=>$this->id,
         ]);
         $this->containers_num+=1;
         DB::table('request')->where('id',$this->id)->update(['containers_num' => $this->containers_num]);

        # code...
      }
      echo "Всё должно быть хорошо";
    }

  }
}