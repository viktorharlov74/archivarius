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

               <!-- <textarea class="form-control" rows="3" name="corobs_add"></textarea> -->
                    
               

               
               <!-- <div class="test" id="test"></div> -->

           
             
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
        <script type="text/javascript">

            function sendContainerAjax(){
              //TODO: Добавить фронт проверку на ошибки
              $.ajax({
                url: '/requestajax/<?=$id_request?>/closenocheck/<?=$step_model->id_step?>',
                method: 'post',
                  dataType: 'html',
                headers: {
                'X-CSRF-Token':'<?php echo(csrf_token()); ?>'
                  },
                data: {id_req:<?=$step_model->id_req?>,id_step:<?=$step_model->id_step?>,next_status_id:<?=$step_model->next_status_id?>,close_type_id:<?=$step_model->close_type_id?>},
                success: function(data){
                  // console.log("Данные вернулись успешно");
                  $('.res').append(data);
                }
              });
            }


                // $("#client-city> option[value='3']").value
                $(document).ready(function(){

                  $('#closenocheck').click(function(){
                    sendContainerAjax();
                    $(this).hide();
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
                                  sendContainerAjax($(this).val());
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
