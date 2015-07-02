<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')
<div class="container-fluid">
  <div class="row">
    @include('tutor/sidebar')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

  <h1>Your Classes</h1>


@include('templates/feedback')
<p class="alert alert-success"><i class="fa fa-info-circle"></i>  This is where you update the classes you can tutor. Make sure to fill it out as completely as possible and keep it updated.</p>

<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#Math">Math</a></li>
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


{!! Form::open(['url' => '/auth/register']) !!}
{!! csrf_field() !!}

<div class="tab-content">


@foreach ($subjects as $subject)
<div id="{{ str_replace(' ', '', $subject) }}" class="tab-pane fade @if($subject == 'Math') in active @endif">
  <div class="row">
    <div class="col-md-6">
      <h3>{{ $subject }}</h3>

      <label>Which of these classes can you tutor?</label>

      @foreach ($classes->get($subject) as $class)
      <?php unset($level_array); foreach($class->class_levels as $level) $level_array[$level->id] = $level->level_name; ?>

        <div class="row">

          <div class="col-xs-7">
            <div class="checkbox">
              <label>
                @if(isset($tutor->tutor_classes[$subject][$class->id]))
                {!! Form::checkbox('classes[]', $class->id, true) !!}
                @else
                {!! Form::checkbox('classes[]', $class->id, false) !!}
                @endif
                {{ $class->class_name }}
              </label>
            </div>
          </div>

          <div class="col-xs-5">
            <div class="form-group">
              @if(isset($tutor->tutor_classes[$subject][$class->id]->level_id))
              {!! Form::select('class_'.$class->id, $level_array, $tutor->tutor_classes[$subject][$class->id]->level_id, ['class' => 'form-control']) !!}
              @else
              {!! Form::select('class_'.$class->id, $level_array, null, ['class' => 'form-control']) !!}
              @endif
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
      <button type="submit" class="btn btn-lg btn-success"> <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update </button>
    </div>

{!! Form::close() !!}
</div>
</div>
</div>
@stop
