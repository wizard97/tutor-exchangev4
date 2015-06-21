<!-- resources/views/auth/password.blade.php -->
@extends('app')

@section('content')
<div class="container">
  <div class="page-header">
  <h1>Request a password reset</h1>
</div>

@include('templates/feedback')

  <!-- request password reset form box -->
  <form method="post" action="/password/email" name="password_reset_form">
    {!! csrf_field() !!}
    <div class="col-md-5">
      <div class="form-group">
        <label for="email"> <p class="bg-info">Enter your email and you'll get a message shortly with instructions: </p></label>
        <input id="email" class="password_reset_input form-control" type="email" name="email" value="{{ old('email') }}">

      </div>
      <input type="submit"  class="btn btn-primary form-control" name="request_password_reset" value="Reset my password" />
    </div>
  </form>
</div>

@stop
