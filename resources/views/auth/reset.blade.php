@extends('app')

@section('content')
<div class="container">
<div class="page-header">
<h1>Set new password</h1>
</div>

@include('templates/feedback')

<div class="row">
<div class="col-sm-6">

<form method="post" id="passwordForm" action="/password/reset">
  {!! csrf_field() !!}
<input type="hidden" name="token" value="{{ $token }}">

<div class="form-group">
  <label for="email">Email address:</label>
  <input type="email" name="email" class="input- form-control" id="email" placeholder="Email">
</div>

<div class="form-group">
  <label for="password">Your new password</label>
<input type="password" class="input form-control" name="password" id="password" placeholder="New Password" autocomplete="off">
</div>

<div class="form-group">
  <label for="password_confirmation">Repeat Password</label>
<input type="password" class="input form-control" name="password_confirmation" id="password_confirmation" placeholder="Repeat Password" autocomplete="off">
</div>

<input type="submit" class="col-xs-12 btn btn-primary btn-block" value="Change Password">

<a href="/auth/login" type="button" class="col-xs-12 btn btn-default btn-block">Back to Login</a>
</form>
</div><!--/col-sm-6-->
</div><!--/row-->
</div>
@stop
