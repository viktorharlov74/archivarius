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
      <div class="row mb-4">
        <div class="col-md-6 offset-3" style="text-align: center;">
          <h1>Размещение коробов на склад</h1>
        </div>
      </div>
       <div class="row">

             <div class="col-md-6 offset-3">
                <h3 class="m-b-md" style="text-align: center;">Короба, которые должны быть</h3>
             </div>
             <div class="col-md-3"></div> 
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
            <!-- <?var_dump($container);?> -->
            <div class="col-md-3">{{$container->barcode}}</div>
            <div class="col-md-3">{{$container->status_id}}</div>



       <?}}?>
        </div>
        <div class="row">

             <div class="col-md-6 offset-3">
                <div class="title m-b-md">Отсканируй код ячейки</div>
             </div>
             <div class="col-md-3"></div> 
        </div>

        <div class="row">
          <div class="col-sm-6 offset-sm-3" id="start">
           <input type="text" id="inputyach" class="cell-control" placeholder="Text input">
           </div>
           <div class="col-sm-3"></div>
           <div class="rescellsccan"></div>
        </div>

        <div class="row mt-4 " id="rescell" style="display: none;">
          <div class="col-6 offset-sm-3"><h3 style="text-align: center;">Текущие короба на полке</h3></div>
          <div class="col-sm-3"></div>
          <div class="col-sm-2">Ячейка:</div>
          <div class="col-sm-3" id="codecell">01.01.01.01.01</div>
          <div class="col-sm-2">Код контейнера:</div>
          <div class="col-sm-5"><input type="text" id="inputas2" class="form-control" placeholder="Text input"></div>
          

        </div>
        <div class="resajax"></div>


<!--         <form action="">
               <div class="row" id="rowform">
                <div class="col-sm-3" id="start">
                    <input type="text" id="inputas2" class="form-control" placeholder="Text input">                
                </div>
              <textarea class="form-control" rows="3" name="corobs_add"></textarea>
                    
               

               
              <div class="test" id="test"></div> 
               
           
             
        </div>
        </form> -->

        <? //dump($step_model);?>
        
    </div>
        <script type="text/javascript">

          $(document).ready(function(){
            getInfoCorobs();
            $('#closestep').click(function(){
              var allcorobs=$('#allcorobs').text();              
              var scan=$('#porguz').text();
              if (allcorobs==scan){
                closeStep();
              }
              else{
                $('.closestep').text('Нельзя закрыть текущий шаг. Не все короба отсканированы.');
              }
            });
          });



          function closeStep(){
              $.ajax({
                url: '/requestajax/<?=$id_request?>/closeStep/<?=$step_model->id_step?>',
                method: 'post',
                  dataType: 'html',
                headers: {
                'X-CSRF-Token':'<?php echo(csrf_token()); ?>'
                  },
                data: {id_req:<?=$step_model->id_req?>,id_step:<?=$step_model->id_step?>,next_status_id:<?=$step_model->next_status_id?>},
                success: function(data){
                  // data=JSON.parse(data);
                  str_date='<div id="rezclose">'+data+'</div>';
                   $('.closestep').html(str_date);
                   $('#closestep').hide();
                  // $('#porguz').text(data['scan']);
                  // $('#ostat').text(data['ost']);
                  // console.log(data['scan']);
                }
              });
          }

          function getInfoCell(cell_id){
                $.ajax({
                url: '/requestajax/getInfoCell',
                method: 'post',
                  dataType: 'html',
                headers: {
                'X-CSRF-Token':'<?php echo(csrf_token()); ?>'
                  },
                data: {id_req:<?=$step_model->id_req?>,cell_id:cell_id},
                success: function(data){
                  // data=JSON.parse(data);
                  $('#rescell').show();
                  
                  str_cell_container_no='<div class="col-sm-2">Ячейка:</div><div class="col-sm-3" id="codecell">01.01.01.01.01</div><div class="col-sm-2">Код контейнера:</div><div class="col-sm-5"><input type="text" id="inputas2" class="form-control" placeholder="Text input"></div>';
                  str_cell_container_yes='<div class="col-sm-2">Ячейка:</div><div class="col-sm-3" id="codecell">01.01.01.01.01</div><div class="col-sm-2">Код контейнера:</div><div class="col-sm-5"><input type="text" id="inputas" value="ASD123"  disabled="" class="form-control" placeholder="Text input"></div>';

                  $('#rescell').append(str_cell_container_no);
                  $('#rescell').append(str_cell_container_yes);

                  $('.resajax').append(data);
                  // str_date='<div id="rez">'+data+'</div>';
                  // $('#porguz').text(data['scan']);
                  // $('#ostat').text(data['ost']);
                  // console.log(data);
                }
              }); 
          }


          function getInfoCorobs(){
              $.ajax({
                url: '/requestajax/<?=$id_request?>/getInfoCorobs',
                method: 'post',
                dataType: 'html',
                headers: {
                'X-CSRF-Token':'<?php echo(csrf_token()); ?>'
                  },
                data: {id_req:<?=$step_model->id_req?>,id_step:<?=$step_model->id_step?>,next_status_id:<?=$step_model->next_status_id?>},
                success: function(data){
                  data=JSON.parse(data);
                  // str_date='<div id="rez">'+data+'</div>';
                  $('#porguz').text(data['scan']);
                  $('#ostat').text(data['ost']);
                  console.log(data['scan']);
                }
              });
          }

            function sendContainerAjax(container,pole){
              //TODO: Добавить фронт проверку на ошибки
              $.ajax({
                url: '/requestajax/<?=$id_request?>/checkCorobs',
                method: 'post',
                  dataType: 'html',
                headers: {
                'X-CSRF-Token':'<?php echo(csrf_token()); ?>'
                  },
                data: {corobs: container,id_req:<?=$step_model->id_req?>,id_step:<?=$step_model->id_step?>,next_status_id:<?=$step_model->next_status_id?>},
                success: function(data){
                  str_date='<div id="res123">'+data+'</div>';
                  pole.after(str_date);
                  console.log("Данные вернулись успешно");
                }
              });
            }


                // $("#client-city> option[value='3']").value
                $(document).ready(function(){

                  $(document).on('keypress touchstart', '.cell-control', function(e){
                      if (e.which == 13) {
                        if ($(this).val()==""){
                            $(this).focus();
                        }
                      else{
                            var codecell=$(this).val();
                            if (codecell.length!=17) {
                               $(".rescellsccan").hide();
                                  if(navigator.onLine) {
                                  getInfoCell(codecell);
                                  $(this).prop('disabled',true);
                                  //TODO: Добавить фронт проверку на ошибки
                                }
                            }
                            else
                            {
                               $(".rescellsccan").show();
                              $(".rescellsccan").html('<p>"Неккоректный код ячейки"<\p>');
                            }

                          }
                    }
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
                                  sendContainerAjax($(this).val(),$(this));
                                  getInfoCorobs();
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
