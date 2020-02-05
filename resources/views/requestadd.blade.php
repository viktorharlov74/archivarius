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
            <div class="title m-b-md">Создание заявки</div>
         </div>
         <div class="col-md-3"></div>
     </div>                 
        <div class="row">
            <label class=" offset-3 col-sm-2 control-label" for="client-city">Город</label>
              <select class=" col-sm-4 form-control required" id="client-city" name="city_id">
                <option disabled="" selected="" value="-1">Выберете город</option>

             <?
                foreach ($city as $key => $value) {
                  ?><option class="city" value=<?=$key?>><?=$value?></option><?
                }
            ?>
            </select>
            <div class="col-sm-3"></div>
        </div>
         <div class="row mt-3">
            <label class=" offset-3 col-sm-2 control-label" for="client-city">Организация</label>
            <select class=" col-sm-4 form-control required" id="client-company" name="company_id">
                <option disabled="" selected="" value="-1">Выберете Организацию</option>

             <?//$("#client-city> option[value='3']").value
                foreach ($organizatinon as $gorod_id => $orginfo) {
                    if (count($orginfo)==0){
                        continue;
                    }
                    foreach ($orginfo as $company_id=> $company_name) {
                        ?><option class="company" data-org=<?=$gorod_id?> value=<?=$company_id?>><?=$company_name?></option><?
                    }
                }
            ?>
            </select>
            <div class="col-sm-3"></div>
        </div>
        <div class="row mt-3">
            <label class=" offset-3 col-sm-2 control-label" for="BP">Бизнес-процес</label>
            <select class=" col-sm-4 form-control required" id="BP" name="BP">
                <option disabled="" selected="" value="-1">Выберете бизнес-процесс</option>

             <?
                foreach ($arr_bp as $key => $value) {
                  ?><option class="BP" value=<?=$key?>><?=$value?></option><?
                }
            ?>
            </select>
            <div class="col-sm-3"></div>                 
                
        </div>

        <div class="row mt-3">
            <label class=" offset-3 col-sm-2 control-label" for="zabor" >Склад отправитель</label>
            <select class=" col-sm-4 form-control required" id="zabor" name="zabor">
                <option disabled="" selected="" value="-1">Клиентский склад</option>

             <?
                foreach ($sklad as $key => $value) {   
                  ?><option class="zabor" value=<?=$key?>><?=$value?></option><?
                }
            ?>
            </select>
            <div class="col-sm-3"></div>
        </div>
         <div class="row mt-3">
             <label class=" offset-3 col-sm-2 control-label" for="skald_poluch">Склад получатель</label>
            <select class=" col-sm-4 form-control required" id="skald_poluch" name="skald_poluch">
                <option disabled="" selected="" value="-1">Склад получатель</option>

             <?
                foreach ($sklad as $key => $value) {   
                  ?><option class="skald_poluch" value=<?=$key?>><?=$value?></option><?
                }
            ?>
            </select>
            <div class="col-sm-3"></div>                      
                
        </div>
        <div class="row mt-3">


<!--                     <div class=" offset-3 col-sm-2">
                <button id="btn-prev" type="button" class="btn btn-default btn-block">Назад</button>
            </div> -->

            <div class=" offset-sm-6 col-sm-3" style="text-align: right;">
                <button type="submit" id="btn-create-request" class="btn btn-primary btn-block " >Создать заявку
                </button>
                
            </div>
            <div class="col-sm-3">

        </div>
        <script type="text/javascript">
                // $("#client-city> option[value='3']").value
                $(document).ready(function(){

                    $("#client-company").attr("disabled","disabled");
                    $('#BP').prop('disabled',true);
                    $('#zabor').prop('disabled',true);
                    $('#skald_poluch').prop('disabled',true);
                    $('#btn-create-request').prop('disabled',true);

                    $('#client-city').change(function(){
                        $('#BP').prop('disabled',true);
                        $('#skald_poluch').prop('disabled',true);
                        $('#btn-create-request').prop('disabled',true);
                        $("#client-company").prop('disabled',false);
                        $("#client-company").val(-1);
                        $("option.company").each(function(){
                            $(this).hide();
                        });
                        var val=$(this).val();
                        str=".company[data-org='"+val+"']";
                        $(str).each(function(){
                            $(this).show();
                        });
                    });

                    $('#client-company').change(function(){
                        $('#skald_poluch').prop('disabled',true);
                        $('#btn-create-request').prop('disabled',true);
                        $('#BP').prop('disabled',false);

                    });

                    $('#BP').change(function(){
                        $('#skald_poluch').prop('disabled',false);
                        $('#btn-create-request').prop('disabled',true);
                    });

                    $('#skald_poluch').change(function(){
                        $('#btn-create-request').prop('disabled',false);
                    });
                    
                    

                          $('#btn-create-request').click(function(){
                            var data={"city":"","organzitaion":"","BP":"","otprv":"","sklad_poluch":""};
                             $.ajax({
                              type:'POST',
                              url:'/api/token/request/add',
                              data:'_token = <? echo csrf_token(); ?>',
                              success:function(data){
                                 $("#msg").html(data.msg);
                              }
                           });
                          
                       });

                    // $('option.city').click(function(){
                    //     $("#client-company").show();
                    //      $("#client-company").val(-1);
                    //      console.log('asdas');
                    //      $("option.company").each(function(){
                    //         $(this).hide();
                    //     });
                    
                        
                    //     var val=$('#client-city').val();
                    //     str=".company[data-org='"+val+"']";
                    //     $(str).each(function(){
                    //         $(this).show();
                    //     });

                    // });
                });
             
        </script>

@endsection
