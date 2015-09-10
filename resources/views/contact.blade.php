@extends('app')

@section('content')
<div class="container">
  <div class="page-header">
  <h1>Contact Us</h1>
  </div>
@include('templates/feedback')
  <div class="well col-md-6">
    {!! Form::open(['url' => route('contact.send')]) !!}
      {!! csrf_field() !!}

      <div class="form-group">
        {!! Form::label('name', 'Your name') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('subject', 'Subject') !!}
        {!! Form::text('subject', null, ['class' => 'form-control', 'placeholder' => 'Suggestion, bug report, etc...']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('email', 'Email address') !!}
        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'We will reply to this address']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('message', 'Message') !!}
        {!! Form::textarea('message', null, ['class' => 'form-control', 'rows' => '7', 'cols' => '60', 'maxlength' => '3000', 'placeholder' => 'Your message to us goes here.']) !!}
      </div>

      <button type="submit" class="btn btn-lg btn-success"> <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Send Email</button>
    {!! Form::close() !!}
  </div>
</div>
@stop
