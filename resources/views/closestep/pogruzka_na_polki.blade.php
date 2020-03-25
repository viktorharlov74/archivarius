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
        <div class="col-md-3 " style="text-align: center;"><a style="color: black; text-decoration: none;font-weight: bold;" href="/<?='request/'.$id_request?>/">Назад к заявке</a></div>
        <div class="col-md-6 " style="text-align: center;">
          <h1>Размещение коробов на склад</h1>
        </div>
      </div>
      
         <div class="row">

               <div class="col-md-6 offset-3">
                  <h3 class="m-b-md" style="text-align: center;">Короба, которые должны быть установленны</h3>
               </div>
               <div class="col-md-3" ><button type="submit" class="btn btn-primary" id="showcorobs">Показать короба</button></div> 
              <div class="col-md-3">Всего коробов должно быть установленно: <span id="allcorobs"><?=count($containers)?></span></div>
              <div class="col-md-3">Установленно в ячейки: <span id="porguz">0</span></div>
              <div class="col-md-3">Осталось установить: <span id="ostat">0</span></div>
              <div class="col-md-3 "><button type="submit" class="btn btn-primary" id="closestep">Завершить текущий шаг</button><div class="closestep"></div></div>
              

          </div>

    <div class="corobsinfo mt-4" style="display: none; border: 2px solid black; border-radius: 10px;">
          <div class="row mt-3">
           
              <div class="col-md-3">Контейнер</div>
              <div class="col-md-3">Код ячейки</div>
              <div class="col-md-3">Контейнер</div>
              <div class="col-md-3">Код ячейки</div>

          </div>
          <div class="row mt-3">
           <?php if (count($containers)>0){ 
            foreach ($containers as $container ) {?>
                <!-- <?var_dump($container);?> -->
                <div class="col-md-3">{{$container['info']->barcode}}</div>
                <div class="col-md-3"><?if (gettype($container['cell'])!='string') echo $container['cell']->code; else echo "Не установлен";?></div>



           <?}}?>
          </div>

      </div>

        <div class="row">

             <div class="col-md-6 offset-3">
                <h2 style="text-align: center;"> Отсканируй код ячейки</h2>
             </div>
             <div class="col-md-3"></div> 
        </div>

        <div class="row">
          <div class="col-sm-6 offset-sm-3" id="start">
           <input type="text" id="inputyach" class="cell-control" placeholder="Код ячейки">
           </div>
           <div class="col-sm-3"></div>
           <div class="resajax"></div>
        </div>
      </div>
      <div class="container mb-4">
        <div class="row mt-4 mb-4" id="headcell" style="display: none;">
          <div class="col-6 offset-sm-3 "><h3 style="text-align: center;">Текущие короба в ячейке</h3></div>
          <div class="col-sm-3"></div>
          <div class="col-sm-4">Организация</div>
          <div class="col-sm-4">Адрес ячейки</div>
          <div class="col-sm-4">Контейнер</div>
        </div>
        <div class="row mb-5" id="rescell" style="display: none;">

        </div>  
      </div>
        
    </div>

    <script src="{{ asset('js/main.js') }}"></script>
        <script type="text/javascript">

          $(document).ready(function(){

            var id_request=<?=$id_request?>;
            var id_step=<?=$step_model->id_step?>;
            var next_status_id=<?=$step_model->next_status_id?>;
            var token='<?php echo(csrf_token()); ?>';
            var data_info={id_req:id_request,id_step:id_step,next_status_id:next_status_id};


            getInfoCorobs(id_request, data_info, token,action="getInfoCorobsInCells");


            $('#showcorobs').click(function(){
              if ($(this).hasClass('closes')) {
              $('.corobsinfo').hide();
              $(this).removeClass('closes');
              $(this).text("Показать короба");
              
            }
            else{
              $('.corobsinfo').show();
              $(this).addClass('closes');
              $(this).text("Скрыть короба");
            }

            });

            $('.opencorobsinfo').click(function(){


            });

            // getInfoCorobs();


          $('#closestep').click(function(){
              getInfoandCloseStep(id_request, data_info, token, id_step,action="getInfoCorobsInCells");

            });
          });

             function createCodeCellstr(name_org){
              str='<div class="col-sm-4 codecell" >'+name_org+'</div>';
              return str;
            }

            function createOrqCellstr(name_org){
              str='<div class="col-sm-4 companyname">'+name_org+'</div>';
              return str;
            }
            function createBarcodeCellstr(code_corob){
              str='<div class="col-sm-4" ><input type="text" id=inputas2" '+'" class="form-control" value="'+code_corob+'"  disabled="" placeholder="Text input"></div>';
              return str;
            }

            function createInputCell(){

              str='<div class="col-sm-4" id="codecell"><input type="text" id=addCorob  class="form-control addContainer no_disabled"   placeholder="Номер короба"> <div class="resvalue" style="display:none;"></div></div>';
               return str;
            }

            function createButtonEndStr(){

              str='<div class=" mt-3 col-sm-6 offset-3 " style="text-align:center;"><button  class="btn btn-primary" id="closeCell">Завершить установку коробов в эту ячейку</button></div>';
               return str;
            }



          // function closeStep(){
          //     $.ajax({
          //       url: '/requestajax/<?=$id_request?>/closeStep/<?=$step_model->id_step?>',
          //       method: 'post',
          //         dataType: 'html',
          //       headers: {
          //       
          //         },
          //       
          //       success: function(data){
          //         // data=JSON.parse(data);
          //         str_date='<div id="rezclose">'+data+'</div>';
          //          $('.closestep').html(str_date);
          //          $('#closestep').hide();
          //         // $('#porguz').text(data['scan']);
          //         // $('#ostat').text(data['ost']);
          //         // console.log(data['scan']);
          //       }
          //     });
          // }

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
                  
                  
                  str_cell_container_no='<div class="col-sm-2">Ячейка:</div><div class="col-sm-3" id="codecell">01.01.01.01.01</div><div class="col-sm-2">Код контейнера:</div><div class="col-sm-5"><input type="text" id="inputas2" class="form-control" placeholder="Text input"></div>';
                  str_cell_container_yes='<div class="col-sm-2">Ячейка:</div><div class="col-sm-3" id="codecell">01.01.01.01.01</div><div class="col-sm-2">Код контейнера:</div><div class="col-sm-5"><input type="text" id="inputas" value="ASD123"  disabled="" class="form-control" placeholder="Text input"></div>';

                  // $('#rescell').append(str_cell_container_no);
                  // $('#rescell').append(str_cell_container_yes);

                  // $('.resajax').append(data);
                  data_res=jQuery.parseJSON(data);
                  if (data_res.res){
                    $('#headcell').show();
                    $('#rescell').show();

                    
                        data_res.corobs.forEach(function(corob, i, data_res) {
                          console.log(corob);
                          var org=createOrqCellstr(corob.org);
                          var cellcode=createCodeCellstr(corob.cellcode);
                          var barcode=createBarcodeCellstr(corob.barcode);

                          $('#rescell').append(org);
                          $('#rescell').append(cellcode);
                          $('#rescell').append(barcode);

                        });

                        if (data_res.cap!=data_res.filled){

                          str_clear='<div class="col-6 offset-sm-3"><h3 style="text-align: center;">Свободные ячейки</h3></div><div class="col-sm-3"></div>';
                          $('#rescell').append(str_clear);
                          for (var i = 0; i < (data_res.cap-data_res.filled); i++) {
                              var org=createOrqCellstr('<?=$company?>');
                              var cellcode=createCodeCellstr(data_res.cellcode);
                              var new_cell=createInputCell();
                              $('#rescell').append(org);
                              $('#rescell').append(cellcode);
                              $('#rescell').append(new_cell);

                               
                          }
                        }
                        else{
                          $("#headcell>.col-6").prepend("<h2 class='notice'> В данной ячейке нет места!!!</h2>");
                        }
                        $('#rescell').append(createButtonEndStr());
                        
                        $('.resajax').text("");
                  }
                  else{
                      $('.resajax').text(data_res.value_eror);
                      $('.cell-control').prop('disabled',false);
                      $('.cell-control').addClass('eror');
                  }
                }
              }); 
          }


          function getInfoCorobs_old(){
              $.ajax({
                url: '/requestajax/<?=$id_request?>/getInfoCorobsInCells',
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

          function sendaddContainerinCellAjax(container,pole,cell="",organzation){
            //TODO: Добавить фронт проверку на ошибки
            $.ajax({
              url: '/requestajax/<?=$id_request?>/addContainerInCell',
              method: 'post',
                dataType: 'html',
              headers: {
              'X-CSRF-Token':'<?php echo(csrf_token()); ?>'
                },
              data: {container: container,id_req:<?=$step_model->id_req?>,id_step:<?=$step_model->id_step?>,cell_id:cell,organzation:organzation},
              success: function(data){
                data=JSON.parse(data);
                if (data.res){
                  pole.prop('disabled',true);
                  pole.removeClass('no_disabled');
                  $('.addContainer.no_disabled').each(function(index){
                    if (index==0) {
                      $(this).focus();
                    }
                  });

                }
                res_selector=pole.next(".resvalue");
                res_selector.text(data.value);
                res_selector.show();
                console.log("Данные вернулись успешно");
                //str_date='<div class="resvalue">'++'</div>';

              }
            });
          }




                // $("#client-city> option[value='3']").value
                $(document).ready(function(){

                  $(document).on('click touchstart','#closeCell', function(e){
                    $("#headcell").hide();
                    $('#rescell').empty();
                    $('#rescell').hide();
                    $(".notice").remove();

                    $('.cell-control').prop('disabled',false);
                    $('.cell-control').val('');
                    $('.cell-control').focus();

                  });

                  $(document).on('keypress touchstart', '.cell-control', function(e){
                      if (e.which == 13) {
                        if ($(this).val()==""){
                            $(this).focus();
                        }
                      else{
                            var codecell=$(this).val();
                            if (codecell.length==17) {

                                  if(navigator.onLine) {
                                  getInfoCell(codecell);
                                  $(this).prop('disabled',true);
                                  //TODO: Добавить фронт проверку на ошибки
                                }
                            }
                            else
                            {
                               $(".resajax").show();
                              $(".resajax").html('<p>"Неккоректный код ячейки"<\p>');
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
                                  var cellcode=$(this).parent().prev(".codecell").text();
                                  var organzation=$(this).parent().prev(".codecell").prev(".companyname").text();
                                  sendaddContainerinCellAjax($(this).val(),$(this),cellcode,organzation);
                                  // getInfoCorobs(id_request, data_info, token,action="getInfoCorobsInCells");
                                  // $(this).prop('disabled',true);
                                  //TODO: Добавить фронт проверку на ошибки
                                }
                                else alert("Сети нету");

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
