<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')

<div class="container-fluid">
  <div class="row">
  @include('/account/tutoring/sidebar')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

      <div class="page-header">
        <h1>Run Your Tutoring Listing</h1>
      </div>
        @include('templates/feedback')

      {!! Form::open(['url' => route('tutoring.submitlisting')]) !!}
      {!! csrf_field() !!}
      <div class="col-md-6">
      <div class="well">

          <div class="form-group">
            {!! Form::label('days', 'How long do you want your tutoring listing to run?') !!}
            {!! Form::select('days', ['7' => 'One Week', '14' => 'Two Weeks', '21' => 'Three Weeks', '30' => 'One Month', '42' => 'Six Weeks', '60' => 'Two Months'], $tutor->grade, ['class' => 'form-control']) !!}
          </div>

        <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-play"></i> Run Tutoring Listing</button>
        </div>
      </div>

      {!! Form::close() !!}

    </div>
  </div>
</div>

@stop
