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


    <div class="container">qw2
      <div class="row">
            <div class="col-md-6 offset-3" style="text-align: center;">
                <h1 class=" m-b-md">Закрытие шага <?=$step_model->name_step?></h1>
             </div>
             <div class="col-md-3"><a href='/request/<?=$id_request?>'>Вернуться к заявке</a></div> 
        
      </div>
        <div class="row">

             <div class="col-md-6 offset-3">
                <h3 class=" m-b-md" style="text-align: center;">Короба, которые были добавленны ранее</h3>
             </div>
             <div class="col-md-3"></div> 
        </div>
      <div class="row mt-3" style="border-bottom: 2px solid black;">
         
            <div class="col-md-3">Контейнер</div>
            <div class="col-md-3">Контейнер</div>
            <div class="col-md-3">Контейнер</div>
            <div class="col-md-3">Контейнер</div>




        </div>

        <div class="row mt-2 oldcontainers">
       <?php if (count($containers)>0){ foreach ($containers as $container ) {?>
            
            <div class="col-md-3">{{$container->barcode}}</div>
            



       <?}}?>
        </div>  
        <hr class="mt-3 mb-3">
        <div class="row">

             <div class="col-md-6 offset-3">
                <div class="title m-b-md">Добавление коробов в заявку</div>
             </div>

             <div class="col-md-3 acthref"><div class="preload" id="loader" style="display: none;"><img src="/images/wait.gif" width="25" height="25"></div><button type="submit" class="btn btn-primary"  id="createAct">Получить АктПередачи коробов</button>
             <button type="submit" class="btn btn-primary mt-3"  id="closestep">Закрыть шаг</button></div> 
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
         <button type="submit" class="btn btn-primary"   id="sendNoServCoronbs">Отправить короба на сервер</button>
        <!-- <button type="submit" class="btn btn-primary"  id="closestep">Завершить добавление коробов</button> -->
        <div class="closestep col-md-8 offset-2"></div>
        
    </div>
    <script src="{{ asset('js/main.js') }}"></script>
        <script type="text/javascript">
            var id_request=<?=$id_request?>;
            var id_step=<?=$step_model->id_step?>;
            var next_status_id=<?=$step_model->next_status_id?>;
            var token='<?php echo(csrf_token()); ?>';
            var data_info={id_req:id_request,id_step:id_step,next_status_id:next_status_id};
            
            /*function sendContainerAjax(container,pole){
              //TODO: Добавить фронт проверку на ошибки
             $.ajax({
                url: '/requestajax/<?=$id_request?>/addCorobs',
                method: 'post',
                  dataType: 'html',
                headers: {
               
                  },
                data: {corobs: container},
                success: function(data){
                  str_date='<div id="res123">'+data+'</div>';
                  pole.after(str_date);
                  console.log("Данные вернулись успешно");
                }
              });
            }*/


            $(document).ready(function(){
              


                $('#closestep').click(function(){
                    closeStep(id_request, data_info, token, id_step);
                });
                $('#createAct').click(function(){
                  $(this).hide(); 
                  console.log("Хотим получить акт передачи коробов");
                  createActCorobs(id_request, data_info, token, id_step);

                });

                $('#sendNoServCoronbs').click(function(){
                    console.log("Отправляем короба на сервер");
                  var corobs=[];
                    $('.form-control[sentserv="false"]').each(function(){
                    var temp=$(this).val();
                    sendContainerAjax($(this).val(),$(this),id_request,data_info,token,"addCorobs");
                    corobs.push(temp)
                    });
                  console.log(corobs);
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
                                  sendContainerAjax($(this).val(),$(this),id_request,data_info,token,"addCorobs");
                                  // sendContainerAjax($(this).val(),$(this));
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
