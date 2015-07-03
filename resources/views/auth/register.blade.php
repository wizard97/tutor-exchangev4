<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')
<div class="container">
  <div class="page-header">
    <h1>Register</h1>
  </div>

@include('templates/feedback')
    <div class="col-md-6 well">
        <!-- register form -->
        {!! Form::open(['url' => '/auth/register']) !!}
        {!! csrf_field() !!}

        <div class="form-group">
          {!! Form::label('fname', 'First name') !!}
          {!! Form::text('fname', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
          {!! Form::label('lname', 'Last name') !!}
          {!! Form::text('lname', null, ['class' => 'form-control']) !!}
        </div>


        <div class="form-group">
          {!! Form::label('email', 'Email') !!}
          {!! Form::email('email', null, ['class' => 'form-control']) !!}
        <p class="help-block">Please use a real email, you'll recieve an email with an activation link</p>
        </div>

        <div class="form-group">
          {!! Form::label('zip', 'Zip Code') !!}
          {!! Form::number('zip', null, ['class' => 'form-control']) !!}
        <p class="help-block">This will help us with performing tutor searches</p>
        </div>

        <div class="form-group">
          {!! Form::label('password', 'Password') !!}
          {!! Form::password('password', ['class' => 'form-control']) !!}
        <p class="help-block">Minimum 6 characters</p>
        </div>


        <div class="form-group">
          {!! Form::label('password_confirmation', 'Repeat Password') !!}
          {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
        </div>


        {!! Form::label('Account Type') !!}
        <br>
        <div class="btn-group" data-toggle="buttons">
          <label class="btn btn-primary @if (Input::old('account_type') == 1) active @endif">
            {!! Form::radio('account_type', '1') !!} Standard
          </label>
          <label class="btn btn-primary @if (Input::old('account_type') == 2) active @endif">
            {!! Form::radio('account_type', '2') !!} Tutor
          </label>
          <label class="btn btn-primary @if (Input::old('account_type') == 3) active @endif">
            {!! Form::radio('account_type', '3') !!} Professional Tutor
          </label>
        </div>
        <p class="help-block">Select "Search Only" if you are looking for a tutor, "Tutor" if you are a standard tutor, and "Professional Tutor" if tutoring is a legitimate job for you and you consider yourself to be a professional.</p>


        <div class="checkbox">
            <label>
              {!! Form::checkbox('terms_conditions', '1') !!} I agree to the <a href="#">Terms and Conditions</a>
            </label>
        </div>

        <button type="submit" class="btn btn-lg btn-success">
          <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Register
        </button>

      {!! Form::close() !!}
    </div>
  </div>
@stop
