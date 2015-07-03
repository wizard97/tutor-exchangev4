<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')
<div class="container-fluid">
  <div class="row">
    @include('tutor/sidebar')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

@include('templates/feedback')

  <div class="page-header">
  <h1>Your Info</h1>
</div>

<p class="alert alert-success"><i class="fa fa-info-circle"></i>  This is where you update your tutoring info. Make sure to fill it out as completely as possible and keep it updated.</p>

{!! Form::open(['url' => '/tutor/info']) !!}
{!! csrf_field() !!}
<div class="col-md-6">
<div class="panel panel-primary">
  <div class="panel-heading">Your Info</div>
  <div class="panel-body">
    <div class="col-md-12">
    <div class="row">
          <div class="form-group">
            {!! Form::label('age', 'Your age') !!}
            {!! Form::number('age', $tutor->age, ['class' => 'form-control', 'placeholder' => 'Optional']) !!}
          </div>

          <div class="form-group">
            {!! Form::label('grade', 'Your grade') !!}
            <?php foreach($grades as $grade) $grade_array[$grade->id] = $grade->grade_name; ?>
            {!! Form::select('grade', $grade_array, $tutor->grade, ['class' => 'form-control']) !!}
          </div>

          <div class="form-group">
            {!! Form::label('rate', 'Requested hourly rate') !!}
            {!! Form::number('rate', !empty($tutor->rate) ? $tutor->rate : '', ['class' => 'form-control', 'placeholder' => 'in $/hour']) !!}
          </div>

          <div class="form-group">
            {!! Form::label('about_me', 'About me') !!}
            {!! Form::textarea('about_me', $tutor->about_me, ['class' => 'form-control', 'rows' => '10', 'cols' => '50', 'maxlength' => '3000', 'placeholder' => 'Tell people a little about yourself/your tutoring ability. Are you an NHS member? Maybe mention your schedule. This is confidential, and will only be viewable by people with registered accounts.']) !!}
          </div>
        </div>
      </div>
      </div>
  </div>

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
