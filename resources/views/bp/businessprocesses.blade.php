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
            <div class="title m-b-md">Текущие Бизнес процессы </div>
         </div>
         <div class="col-md-3"></div>
     </div>                 
        
        <div class="row mt-3">
            <div class="col-md-4 offset-2">Бизнес-процесс</div>
            <div class="col-md-4  offset-2">Число шагов</div>


        </div>
        <div class="row mt-3">
       <?php foreach ($arr_bp as $id=>$bp_info) {?>
            <div class="col-md-4 offset-2"><a href="/business_processes/<?=$id?>"><?=$bp_info['name']?></a> </div>
            <div class="col-md-4  offset-2"><?=$bp_info['count']?></div>

       <?}?>
        </div>  
    
</div>
       
@endsection
