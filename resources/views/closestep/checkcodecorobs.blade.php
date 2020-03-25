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

             <div class="col-md-8 offset-2">
                <h3 class="title m-b-md">Короба, которые должны быть</h3>
             </div>
             <div class="col-md-2"></div> 
            <div class="col-md-3">Всего коробов должно быть: <span id="allcorobs"><?=count($containers)?></span></div>
            <div class="col-md-3">Отсканировано: <span id="porguz">0</span></div>
            <div class="col-md-3">Осталось отсканировать: <span id="ostat">0</span></div>
            <div class="col-md-3 "><button type="submit" class="btn btn-primary" id="closestep">Завершить текущий шаг</button><div class="closestep"></div></div>
            

        </div>
      <div class="row mt-3">
         
            <div class="col-md-3">Контейнер</div>
            <div class="col-md-3">Статус</div>
            <div class="col-md-3">Контейнер</div>
            <div class="col-md-3">Статус</div>

        </div>
        <div class="row mt-2">
       <?php if (count($containers)>0){ foreach ($containers as $container ) {?>

            <div class="col-md-3">{{$container->barcode}}</div>
            <div class="col-md-3">{{$container->status_id}}</div>



       <?}}?>
        </div>  
        <div class="row">

             <div class="col-md-6 offset-3">
                <div class="title m-b-md">Погрузка коробов в машину</div>
             </div>
             <div class="col-md-3"></div> 
        </div>
        <form action="" class="addCorobsForm">
               <div class="row" id="rowform">
                <div class="col-sm-3" id="start">
                    <input type="text" id="inputas2" class="form-control" placeholder="Text input">                
                </div>
               <!-- <textarea class="form-control" rows="3" name="corobs_add"></textarea> -->
                    
               

               
               <!-- <div class="test" id="test"></div> -->
               
           
             
        </div>
        </form>

        <? //dump($step_model);?>
        
    </div>
    <script src="{{ asset('js/main.js') }}"></script>
        <script type="text/javascript">


      $(document).ready(function(){
            
            var id_request=<?=$id_request?>;
            var id_step=<?=$step_model->id_step?>;
            var next_status_id=<?=$step_model->next_status_id?>;
            var token='<?php echo(csrf_token()); ?>';
            var data_info={id_req:id_request,id_step:id_step,next_status_id:next_status_id};


            getInfoCorobs(id_request, data_info, token);
            
            $('#closestep').click(function(){

              getInfoandCloseStep(id_request, data_info, token, id_step);

            });
          var id_all=2;
          var selector_start="#start";
          var allcorobs=[];

          $(document).on('keypress touchstart', '.form-control', function(e){ 
             if (e.which == 13) {
              if ($(this).val()==""){
                  $(this).focus();
              }
              else{
                  if (allcorobs.indexOf($(this).val())=="-1"){
                      allcorobs.push($(this).val());
                      if(navigator.onLine) {
                        sendContainerAjax($(this).val(),$(this),id_request,data_info,token,);
                        getInfoCorobs(id_request, data_info, token);
                        $(this).prop('disabled',true);
                        //TODO: Добавить фронт проверку на ошибки
                      }
                      else alert("Сети нету");
                      
                      
                      str_id="input"+id_all.toString();
                      selector="#"+str_id;
                      id_all+=1;                                
                        // alert("Нажата клавиша ентер");
                        str='<input type="text" class="form-control" id="' + (str_id)+'" placeholder="Text input">'
                         $(selector_start).append(str);
                         $(selector).focus();
                          if (id_all%80==1){
                              $("#rowform").append('<div class="col-sm-12">Новый лист</div>');
                          }
                         if (id_all%20==1){
                          selector_start="start"+(id_all).toString();
                          new_stolb=' <div class="col-sm-3"  id="' + (selector_start)+'" > </div>'
                              $('#rowform').append(new_stolb);
                              selector_start="#"+selector_start;
                         }
                  }
                  else
                  {
                      $(this).val("");
                      $(this).focus();

                  }
              }
             }
          });



    });
             
        </script>

@endsection
