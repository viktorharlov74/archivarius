<?php
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Маршруты аутентификации...
Route::get('/login', 'LoginController@starts')->name('login');
Route::get('/home', 'LoginController@home')->name('home');
Route::get('request',['uses'=>'RequestController@showrequest']);
Route::get('/request/{id}/addCorobs','RequestController@addCorobs');
Route::get('/findcorobs','FindController@show');
Route::post('/findcorobs','FindController@find');


Route::post('/requestajax/{id}/addCorobs','RequestAjaxController@addCorobs');
Route::get('/requestajax/{id}/addCorobs' ,function () {
  abort(404);
});


// Route::post('auth/login', 'Auth\AuthController@postLogin');
// Route::get('auth/logout', 'Auth\AuthController@getLogout');

// // Маршруты регистрации...
// Route::get('auth/register', 'Auth\AuthController@getRegister');
// Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('/', function () {
    return view('tasks');
});
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('request/add',['uses'=>'RequestController@createParametrs']);

Route::get('/foo', function () {
  return 'Hello World';
});



Route::get('requests/', function () {
  return 'Все заявки';
});

Route::get('erors/', function () {
  return 'Ошибка Авторизации';
});

Route::get('requests/{id?}',  'UserController@show');


Route::group(['prefix' => 'api'], function ($tokens) {

	Route::get('requests/{id}', function ($id) {
	   return 'АПИ заявка '.$id;
	});
	Route::get('{token}/requests/{id}',['middleware' => 'token','uses' =>'UserController@show']); 

	Route::get('{token}/requests/{id}/addCorobs',['middleware' => 'token','uses' =>'ApiController@addCorobs']); 
});





 // Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
