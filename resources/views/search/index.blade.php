@extends('app')

@section('content')
<div class="container">
  <div class="page-header">
    <h1>What are you looking for?</h1>
  </div>
  <div class="col-md-6 col-md-offset-3 ">
    <div class="well">
      <a class="btn btn-primary btn-block btn-lg" href="{{ route('school.index') }}"><i class="fa fa-university"></i> School Tutoring</a>
      <a class="btn btn-success btn-block btn-lg" href="{{ route('music.index') }}"><i class="fa fa-music"></i> Music Tutoring</a>
      <a class="btn btn-warning btn-block btn-lg disabled" href=""><i class="fa fa-question-circle"></i> Other <span class="label label-info">Under development...</span></a>
    </div>
  </div>
</div>
@stop
