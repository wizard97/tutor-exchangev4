<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')
<div class="container">
<div class="page-header">
  <h1>Find Me a Tutor</h1>
</div>

@include('templates/feedback')
<p class="alert alert-success"><i class="fa fa-info-circle"></i> Just select all the credentials you would like your tutor to have, and we will try and find you the best match.</p>

<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#Criteria">Tutor Criteria</a></li>
  <li><a data-toggle="tab" href="#Math">Math</a></li>
  <li><a data-toggle="tab" href="#Science">Science</a></li>
  <li><a data-toggle="tab" href="#SocialStudies">Social Studies</a></li>
  <li><a data-toggle="tab" href="#English">English</a></li>
    <li role="presentation" class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
      Language <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
    <li><a data-toggle="tab" href="#French">French</a></li>
    <li><a data-toggle="tab" href="#German">German</a></li>
    <li><a data-toggle="tab" href="#Italian">Italian</a></li>
    <li><a data-toggle="tab" href="#Mandarin">Mandarin</a></li>
    <li><a data-toggle="tab" href="#Spanish">Spanish</a></li>
    </ul>
  </li>
    <li><a data-toggle="tab" href="#music">Music</a></li>
</ul>


<form method="POST" action="{{ route('search.search') }}">
{!! csrf_field() !!}
<div class="tab-content">
  <div id="Criteria" class="tab-pane fade in active">
  <div class="row">
  <div class="col-md-6">
    <h3>Tutor Criteria</h3>
              <label for="start_rate">Price range</label>
              <div class="row">
              <div class="col-xs-4">
              <input type="number" class="form-control" name="start_rate" id="start_rate" size="5" maxlength="3" placeholder="min">
              </div>
               <div class="col-xs-4">
              <input class="form-control" type="number" name="end_rate" id="end_rate" size="5" maxlength="3" placeholder="max">
              </div>
            </div>
            <p class="help-block">Enter your price range in dollars per hour</p>

            <div class="form-group">
              <label for="min_grade">Minimum grade</label>
              <select class="form-control" name="min_grade" id ="min_grade">
                <option value="">No Preference</option>
                @foreach($grades as $grade)
                <option value="{{ $grade->id }}">{{ $grade->grade_name }}</option>
                @endforeach
              </select>
              <p class="help-block">The minimum grade your tutor should be in</p>
            </div>
  </div>

  </div>
  </div>

@foreach ($subjects as $subject)
<div id="{{ str_replace(' ', '', $subject) }}" class="tab-pane fade">
  <div class="row">
    <div class="col-md-6">
      <h3>{{ $subject }}</h3>
    @foreach ($classes->get($subject) as $class)
      <div class="row">

        <div class="col-xs-7">
          <div class="checkbox">
            <label>
              <input type="checkbox" name="classes[]" value="{{ $class->id }}">
              {{ $class->class_name }}
            </label>
          </div>
        </div>
        <div class="col-xs-5">
          <div class="form-group">
            <select class="form-control" name="class_{{ $class->id }}" id="class_{{ $class->id }}">
              @foreach($class->class_levels as $level)
              <option value="{{ $level->level_num }}">{{ $level->level_name }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
    @endforeach
    </div>
  </div>
</div>
@endforeach
</div>

<div class="clearfix"></div>

<hr>
    <div class="pull-left">
      <button type="submit" class="btn btn-lg btn-success"> <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search </button>
    </div>
</form>
</div>
@stop
