@extends('layouts.app')
@section('content')


@if (count($errors) > 0)
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

 <div class="flex-center full-height" style="background-image: url(https://архивныйдом.рф/img/common/bg-main.jpg);background-size: 100% auto;">   
      <div class="container">
        <div class="row ">
          <div class="col-md-6 offset-3"> <div class="title">Авторизуйтесь</div></div>         
        </div>
        <div class="row mt-2">
        @if (strlen($eror) > 0) 
          <div class="offset-3 col-sm-6" >
                <strong>{{ $eror }}</strong>
           </div>
           <div class="col-sm-3"></div>
        @endif
            <form class=" offset-4 col-sm-4 " method="POST">
              {!! csrf_field() !!}
              <div class="form-group">
                <label for="exampleInputEmail1">Логин</label>
                <input name="login" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Пароль</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
              </div>
<!--               <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
              </div> -->
              <button type="submit" class="btn btn-primary btn-right">Войти</button>
            </form>
            <div class="col-sm-4"></div>
        </div>
     
      </div>
  </div>


@endsection








