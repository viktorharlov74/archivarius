<?php 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// use Illuminate\Support\Facades\Session;
//для версии 5.2:
//use Auth;
//для версии 5.1 и ранее:
//use Illuminate\Routing\Controller;

class AuthmidlewareController extends Controller
//для версии 5.2 и ранее:
//class AuthController extends Controller
{

  public function __construct()
  {
    // echo "Вызов конструктора";
  }
  /**
    * Обработка попытки аутентификации
    *
    * @return Response
    */
    protected function GetUserInfo($user_id){
      $results = DB::table('users_api')->where('id',$user_id)->get();
        if (count($results)!=1){
          return false;
        }
        else
          return $results->first();
    }
  protected function CheackAuth($login,$password){


    if ((strlen($login)>3) and (strlen($password)>7)){
        //session_start();
        echo "Проверка авторизации";
        // $request->session()reflash();
        // print_r($login);
        // print_r($_GET);
        $results = DB::table('users_api')->where([['login',$login],['password',$password]])->get();
        if (count($results)!=1){
          return false;
        }
        else {
          $user_info=$results->first();
          echo "результат БД \n";
          print_r($results);
          return $user_info;
        }

      }
      else return false;
  }

  public function Clear($str){

    $input_text = trim($str);
    $input_text = htmlspecialchars($input_text);
    // $input_text = mysql_escape_string($input_text);
    return $input_text;
  }

  public function checkAuthRequest(Request $request){
    // echo "То что у нас в сессии сейчас\n";
    //  print_r($request->session()->all());

   if ($request->session()->has('user'))
   {
      $user_id=$request->session()->get('user');
      return true;
   }
   else{
    // echo (isset($request->login)." -----");
      if (isset($request->login)!="" and isset($request->password)!="")
      {
          $login =$this->Clear($request->login);
          $password =$this->Clear($request->password);
          $user_info=$this->CheackAuth($login,$password);
        if ($user_info!=false)
        {

             $id_session=session_create_id($user_info->id);
             $request->session()->put($user_info->id, $id_session);
             // $request->session()put($user_info->id, $id_session);
             $request->session()->put("user", $user_info->id);
             $request->session()->put("user_name", $user_info->name);

             $request->session()->save();
              // $results = DB::table('sessions')->insert([['user_id',$user_id],['ip_address',$request()->ip()],[]])->get();         
             print_r($request->session()->all());

             // $value_sessions = $request->session()->get(13);
             // echo "Сессия ". $value_sessions;
          // echo "успешно авторизованы без сесии";
          return view('home');
        }
        else{
          echo "Неверный логин или пароль";
          return  view('login',['eror' => 'Неверный логин или пароль']); 
        }

      }
        


    // print_r($request->session());
    return false;
   }  
       // $value = $request->session();
        
    // if (Auth::attempt(['login' => $email, 'password' => $password])) {
    //   // Аутентификация успешна
    //   return redirect()->intended('/');
    // }


  }
public function logout(Request $request) {
  Auth::logout();
  return redirect()->route('login');
}
}