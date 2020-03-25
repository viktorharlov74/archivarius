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
        <div class="row">
             <div class="col-md-6 offset-3">
                <div class="title m-b-md">Закрытие шага <?=$step_model->name_step?></div>
             </div>
             <div class="col-md-3"></div> 
        </div>

         <div class="row" id="rowform">


           
             
        </div>
        <? if ($step_model->close_type_id==6){?>
          <div class="row">
            <div class="col-sm-6 offset-sm-3 text-center">
                  <h3 style="text-align: center;">Шаг закрывается без проверки. Для закрытия шага нажмите на кнопку</h3>
                  <button type="submit"  class="btn btn-primary" id="closenocheck">Закрыть шаг</button>
                 <div class="res"></div>
            </div>
          </div>
        <?}?>

      
    </div>
    <a href='/request/<?=$id_request?>'>Вернуться к заявке</a>
     <script src="{{ asset('js/main.js') }}"></script>
        <script type="text/javascript">
            var id_request=<?=$id_request?>;
            var id_step=<?=$step_model->id_step?>;
            var next_status_id=<?=$step_model->next_status_id?>;
            var token='<?php echo(csrf_token()); ?>';
            var data_info={id_req:<?=$step_model->id_req?>,id_step:<?=$step_model->id_step?>,next_status_id:<?=$step_model->next_status_id?>,close_type_id:<?=$step_model->close_type_id?>};

                // $("#client-city> option[value='3']").value
                $(document).ready(function(){

                  $('#closenocheck').click(function(){
                    closeNoCheck($('.res'),id_request,data_info,token);
                    $(this).hide();
                  });





                });
             
        </script>

@endsection
