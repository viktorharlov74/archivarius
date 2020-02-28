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


    <div class="container mt-4">
        <div class="row mt-4">
             <div class="col-md-6 offset-3 mt-4">
                <h3>Ошибка. Этот шаг или не начат или уже закончен. <a href='/request/<?=$id_request?>'>Вернуться к заявке</a></h3>
             </div>
             <div class="col-md-3"></div> 
        </div>

    </div>
        

@endsection
