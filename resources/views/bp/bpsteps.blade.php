@extends('layouts.app')

@section('content')

<!--             @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif -->


<div class="container">
    <div class="row mt-3    ">
         <div class="col-md-10 offset-1">
            <h1 style="text-align: center;">Текущие шаги Бизнеса процесса <?=$name_bp?></h1> 
         </div>
         <div class="col-md-3"></div>
     </div>                 
        
        <div class="row mt-5">
            <div class="col-md-3 " >Номер шага</div>
            <div class="col-md-3 ">Шаг</div>
            <div class="col-md-3  ">Тип закрытия</div>
            <div class="col-md-3  ">Статус короба после закрытия</div>



        </div>
        <div class="row mt-3">
       <?php foreach ($arr_steps as $number=>$steps_info) {?>

            <div class="col-md-3 " ><?=$number?></div>
            <div class="col-md-3 "><?=$steps_info['name']?></div>
            <div class="col-md-3  "><?=$steps_info['close_type_name']?></div>
            <div class="col-md-3  "><?=$steps_info['container_status_name']?></div>

       <?}?>
        </div>  
    
</div>
       
@endsection
