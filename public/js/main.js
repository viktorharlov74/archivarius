
 function getInfoandCloseStep(id_request,data_info,token,id_step,action="getInfoCorobs",pole=$('.closestep')){
       $.ajax({
        url: '/requestajax/'+id_request+'/'+action,
        method: 'post',
          dataType: 'html',
        headers: {
        'X-CSRF-Token':token
          },
        data:data_info,
        success: function(data){
          data=JSON.parse(data);

          if (data['ost']==0) {
            closeStep(id_request,data_info,token,id_step);
          }
          else{
            pole.hide(200);
            pole.text('Нельзя закрыть текущий шаг. Не все короба отсканированы.');
            pole.show(700);
          }            // str_date='<div id="rez">'+data+'</div>';
        },
              error : function(data){
            alert("Ошибка ответа от сервера ");
            console.log(data);
        }
      });

  }

    function createActCorobs(id_request,data_info,token, id_step,pole=$('.acthref')){
      $.ajax({
        url: '/requestajax/'+id_request+'/createAct/'+id_step+'',
        method: 'post',
          dataType: 'html',
        headers: {
        'X-CSRF-Token':token
          },
        data: data_info,
        beforeSend: function() {
          $('#loader').show();
        },
        success: function(data){
           $('#loader').hide();
           pole.html(data);
        },
              error : function(data){
            alert("Ошибка ответа от сервера ");
            console.log(data);
        }
      });
  }


  function closeStep(id_request,data_info,token, id_step,pole=$('.closestep')){
      $.ajax({
        url: '/requestajax/'+id_request+'/closeStep/'+id_step+'',
        method: 'post',
          dataType: 'html',
        headers: {
        'X-CSRF-Token':token
          },
        data: data_info,
        success: function(data){
          data=JSON.parse(data);
           pole.hide(200);
           str_date='<div id="rezclose">'+data.value+' <a href="/request/'+id_request+'">Вернуться к заявке</a></div>';
           pole.html(str_date);
           pole.show(600);
          if (data.res){
            $('#closestep').hide();
            $('#sendNoServCoronbs').hide();
            $('.addCorobsForm').hide();
          }

        },
              error : function(data){
            alert("Ошибка ответа от сервера ");
            console.log(data);
        }
      });
  }


  function closeNoCheck(pole,id_request,data_info={id_req:0,id_step:0,next_status_id:0,close_type_id:0},token){
    //TODO: Добавить фронт проверку на ошибки
    $.ajax({
      url: '/requestajax/'+id_request+'/closenocheck/'+id_step,
      method: 'post',
        dataType: 'html',
      headers: {
      'X-CSRF-Token':token
        },
      data:data_info,
      success: function(data){
        str= '<a href="/request/'+id_request+'">Вернуться к заявке</a>';
        // console.log("Данные вернулись успешно");
        pole.append(data);
        pole.append(str);

      },
              error : function(data){
            alert("Ошибка ответа от сервера ");
            console.log(data);
        }
    });
  }

  function getInfoCorobs(id_request,data_info,token,action="getInfoCorobs"){
      $.ajax({
        url: '/requestajax/'+id_request+'/'+action,
        method: 'post',
          dataType: 'html',
        headers: {
        'X-CSRF-Token':token
          },
        data: data_info,
        success: function(data){
          data=JSON.parse(data);
          // str_date='<div id="rez">'+data+'</div>';
          $('#porguz').text(data['scan']);
          $('#ostat').text(data['ost']);
          console.log('Обновляем');

          console.log(data);
        },
              error : function(data){
            alert("Ошибка ответа от сервера ");
            console.log(data);
        }
      });
  }

  function sendContainerAjax(container,pole,id_request,data_info,token,action="checkCorobs"){

    data_info.corobs=container;
    console.log("Данные для отправки");
    console.log(data_info);
    //TODO: Добавить фронт проверку на ошибки
    $.ajax({
      url: '/requestajax/'+id_request+'/'+action,
      method: 'post',
        dataType: 'html',
      headers: {
      'X-CSRF-Token':token
        },
      data: data_info,
      success: function(data){
        data=JSON.parse(data);
        str_date='<div id="res123">'+data.value+'</div>';
        if (data.res){
          $('.oldcontainers').append('<div class="col-md-3" style="color:red;"> '+container+'</div>');
          pole.attr('sentserv',true);
        }
        pole.after(str_date);
        console.log("Данные вернулись успешно");
      },
      error : function(data){
            pole.attr('sentserv',false);
            $('#sendNoServCoronbs').show();
            $('#closestep').hide();

            console.log("Ошибка ответа от сервера ");
            // console.log(data);
        }
    });
  }




