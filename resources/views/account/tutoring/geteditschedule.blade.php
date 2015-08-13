<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')
<div class="container-fluid">
  <div class="row">
    @include('/account/tutoring/sidebar')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

      @include('templates/feedback')

      <div class="page-header">
        <h1>Your Schedule</h1>
      </div>

      <p class="alert alert-info"><i class="fa fa-info-circle"></i>  This is where you update your tutoring info. Make sure to fill it out as completely as possible and keep it updated.</p>

      {!! Form::open(['url' => route('tutoring.editinfo')]) !!}
      {!! csrf_field() !!}
      <div class="col-md-6">

        <div class="col-xs-4">
          <button type="submit" class="btn btn-lg btn-primary"> <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update </button>
        </div>

      </div>


      <div class="clearfix"></div>

      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop
