@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Личный кабинет</div>

                <div class="card-body">
                    @if (session('user_name') and (session('user')))
                        <div class="alert alert-success" role="alert">
                            {{ session('user_name') }}
                            Вы успешно авторизовались <a href="/logout">Выйти</a>
                        </div>

                    @endif                     
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
