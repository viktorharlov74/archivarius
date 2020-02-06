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

            <div class="title"><img src="{{ asset('images/') }}/find.png"></div>
         </div>
         <div class="col-md-3"></div>
     </div>                 
        <?php if (isset($res)){
            if (count($res)>0){
            ?>

             <div class="row" style="text-align: center;">
                 <div class="col-md-6 offset-3">
                    <div class=".title" style="text-align: center;"><h2>Результат поиска коробов:</h2></div>
                 </div>
                 <div class="col-md-3"></div>
             </div>
             <div class="row" style="text-align: center;">
              <div class="col-md-3 headercorobs">Короб</div>
              <div class="col-md-3 headercorobs">Организация</div>
              <div class="col-md-3 headercorobs">Адресс ячейки</div>
              <div class="col-md-3 headercorobs">Статус</div>
            <? foreach ($res as $corobs) {
                foreach ($corobs as $key => $value) {
                  ?><div class="col-md-3"><?=$value['barcode']?></div><?
                  ?><div class="col-md-3"><?=$value['org']?></div><?
                  ?><div class="col-md-3"><?=$value['cellcode']?></div><?
                  ?><div class="col-md-3"><?=$value['status']?></div><?

                }
              }?>
            </div>
       <? }}?> 
      <?php if (isset($not_found)){
         if (count($not_found)>0){
        ?>
        <div class="row mt-3" style="text-align: center;">
                 <div class="col-md-6 offset-3">
                    <div class=".title"  style="text-align: center;"><h2>Короба которые не нашлись:</h2> </div>
                 </div>
                 <div class="col-md-3"></div>
             </div>
             <div class="col-md-6 offset-3">
               <? foreach ($not_found as $corobs) {
                ?><div class="col-md-12"><?= $corobs?></div><?
               }?>
              </div>
        <?}}?>

        <div class="row mt-3">
           <form class="col-md-6 offset-3" action="" method="post">
             {{csrf_field()}}
            <textarea  class="col-md-12"name="q" placeholder="Искать здесь..." type="text"></textarea>
            <button  type="submit" id="btn-find" class="btn btn-primary btn-block col-md-6 offset-3 mt-3" >Поиск</button>
          </form>
        </div>

    </div>


@endsection
