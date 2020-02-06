<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Архивариус 2.0</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="/css/app.css">
         <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                font-size: 14px;
                margin: 0;
            }
            .form-control{
                margin-bottom: 10px;
            }
            div{
                font-size: 16px;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 48px;
                text-align: center;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .company{
                display: none;
            }
            .headercorobs {
                font-weight: 500;
                border: 29px;
                color: #1b0a0a;
                margin-bottom: 10px;
            }
        </style>
       
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
       
    </head>
<body>

    <div id="app">
        @if (session('user_name') and (session('user')))
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Архивариус 2.0
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                            <li class="nav-item">
                                    <a class="nav-link" href="/request">Заявки</a>
                            </li>
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="/business_processes">Бизнес-процессы</a>
                            </li>

                            <li class="nav-item">
                                    <a class="nav-link" href="/findcorobs">Поиск коробов</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        
                                    <li class="nav-item">
                                        <a id="navbarDropdown" class="nav-link " href="/login" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ session('user_name') }} <span class="caret"></span>
                                        </a>
                                    </li>
                                     <li class="nav-item">
                                       <a class=" nav-link dropdown-item" href="{{ route('logout') }}">
                                               Выйти
                                        </a>
                                     </li>
 

                           
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
 @endif

    @yield('content')

    </div>
</body>
</html>
