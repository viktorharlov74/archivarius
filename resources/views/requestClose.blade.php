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
        <div class="row mt-5">
             <div class="col-md-12">
                <h1 style="text-align: center;">Информация по заявке <?=$id?> </h1>
             </div>
         </div>
                  <div class="row mt-3">
           <div class="col-md-6"><h3>Организация: <span style="color: black; font-weight: bold;"><?=$company?></span></h3> </div>
           <div class="col-md-6"><h3>Бизнес-процесс:  <span style="color: black; font-weight: bold;"><?=$bp?></span><h3></div>

         </div>

         <div class="row mt-3">
           <div class="col-md-8 offset-2">

             <h3 style="text-align: center;"> <?echo 'Заявка '.($cancel==true ? 'Была Отменена' : 'Закрыта!');  ?></h3>
           </div>
         </div>

        <div class="row mt-3">
                 <h2>Информация:</h2>
         </div>
      @if ($curent_steps)
            <div class="row mt-2">
                <div class="col-md-2">Шаг</div>
                <div class="col-md-2">Время-старта</div>
                <div class="col-md-2">Время закрытия</div>
                <div class="col-md-2">Тип проверки</div>
                <div class="col-md-2">Статус</div>
                <div class="col-md-2">Действие</div>

            </div>
            
              <?ksort($curent_steps);?>
            <? foreach ($curent_steps as $number => $step) {?>
              <div class="row mt-2">
                <div class="col-md-2">{{ $number }}. {{ $step['name'] }}</div>
                <div class="col-md-2">{{ $step['start_time'] }}</div>
                <div class="col-md-2">{{ $step['end_time'] }}</div>
                <div class="col-md-2">{{ $step['close_type_name'] }}</div>
                <div class="col-md-2">{{ $step['curent'] }}</div>
                <div class="col-md-2">
                    <? if ($step['curent']=="Исполняется"){
                        ?><a href="/request/<?=$id?>/closeStep/<?=$step['id']?>" id="btn-close-step" class="btn btn-primary btn-block " style="text-align: center;">Закрыть</a> 
                        <?}?>
                </div>
              </div>

            <?}?>
            

      @endif

      <div class="row mt-3">
        <div class="col-md-3 offset-9 " style="text-align: right;">
          <a href="/request" style="text-align: right;">Вернуться к заявкам</a>
        </div>
      </div>

         <div class="row mt-3">
             <h2>Контейнера в заявке</h2>
         </div>
        <div class="row mt-3">
            <div class="col-md-2">Контейнер</div>
            <div class="col-md-2">Cтатус</div>
            <div class="col-md-2">Дедлайн</div>
            <div class="col-md-2">Контейнер</div>
            <div class="col-md-2">Cтатус</div>
            <div class="col-md-2">Дедлайн</div>
        </div>
        <div class="row mt-2">
       <?php if (count($containers)>0){ foreach ($containers as $container ) {?>
            <!-- <?var_dump($container);?> -->
            <div class="col-md-2">{{$container->barcode}}</div>
            <div class="col-md-2">{{$container->status_id}}</div>
            <div class="col-md-2">{{$container->deadline}}</div>




       <?}}?>
        </div>  
    

    </div>

    <script type="text/javascript">


          function sendContainerAjax(){
            //TODO: Добавить фронт проверку на ошибки
            $.ajax({
              url: '/requestajax/<?=$id?>/closeRequest',
              method: 'post',
                dataType: 'html',
              headers: {
              'X-CSRF-Token':'<?php echo(csrf_token()); ?>'
                },
              data: {id_req:<?=$id?>},
              success: function(data){
                // console.log("Данные вернулись успешно");
                $('.resajax').html(data);
              }
            });
          }

      
      $(document).ready(function() {
        $("#btn-close-req").click(function(){
             sendContainerAjax();
        });
      });
    </script>
@endsection
