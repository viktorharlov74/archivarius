@extends('layouts.app')
@section('content')

    <body>
@if (count($errors) > 0)
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                                        <a href="/request">Заявки</a>
                    <a href="https://laracasts.com">Контейнеры</a>
                    <a href="https://laravel-news.com">Склады</a>
                    <a href="https://blog.laravel.com">Отчёты</a>
                    <a href="https://nova.laravel.com">Настройки</a>
                    <a href="https://forge.laravel.com">Клиенты</a>
                </div>
            @endif

            <div class="container">
                <div class="row">
                    Какой-то текст
                </div>
                
            </div>
        </div>
    </body>
@endsection