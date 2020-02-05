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

    <div class="flex-center position-ref full-height">
      <div class="container">
        <div class="row">
        @if (strlen($eror) > 0) 
          <div class="offset-3 col-sm-6" >
                <strong>{{ $eror }}</strong>
           </div>
           <div class="col-sm-3"></div>
        @endif
            <form class=" offset-3 col-sm-6 " method="GET">
              <div class="form-group">
                <label for="exampleInputEmail1">Логин</label>
                <input name="login" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
              </div>
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
              </div>
              <button type="submit" class="btn btn-primary">Войти</button>
            </form> 
        </div>
     
      </div>
  </div>


    </body>

@endsection




