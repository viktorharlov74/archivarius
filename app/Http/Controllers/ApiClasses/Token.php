<?php


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


abstract class PublicationCheck {
  abstract public function checkAcsessBD();

}
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