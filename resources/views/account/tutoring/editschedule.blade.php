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

      <p class="alert alert-info"><i class="fa fa-info-circle"></i>  This is where you update your tutoring schedule. Make sure it accurately reflects your availability.</p>

      {!! Form::open(['url' => route('tutoring.editinfo')]) !!}
      {!! csrf_field() !!}
      <div class="col-md-10">

        <table class="table table-condensed">
          <thead>
            <tr>
              <th class="text-center text-primary">Day</th>
              <th class="text-center text-primary">Ideal Time 1</th>
              <th class="text-center text-primary">Ideal Time 2</th>
              <th class="text-center text-primary">Ideal Time 3</th>
              <th class="text-center text-primary">Ideal Time 4</th>

            </tr>
          </thead>
          <tbody>
            <?php $days = ['mon' => 'Monday', 'tues' => 'Tuesday', 'wed' => 'Wednesday', 'thurs' => 'Thursday', 'fri' => 'Friday', 'sat' => 'Saturday', 'sun' => 'Sunday']; ?>

            @foreach($days as $key => $day)
            <tr class="time-row">
              <td>
                <div class="checkbox row-checkbox">
                  <label>
                    <input type="checkbox" value="1" name="{{$key}}_checked"> {{ $day }}
                  </label>
                </div>
              </td>

              <td>
                <div class="input-group clockpicker">
                  <input type="text" class="form-control" value="03:00PM" name="{{$key}}">
                  <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                  </span>
                </div>
              </td>
              <td>
                <div class="input-group clockpicker">
                  <input type="text" class="form-control" value="03:00PM" name="{{$key}}">
                  <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                  </span>
                </div>
              </td>
              <td>
                <div class="input-group clockpicker">
                  <input type="text" class="form-control" value="03:00PM" name="{{$key}}">
                  <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                  </span>
                </div>
              </td>
              <td>
                <div class="input-group clockpicker">
                  <input type="text" class="form-control" value="03:00PM" name="{{$key}}">
                  <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                  </span>
                </div>
              </td>

            </tr>
            @endforeach
          </tbody>
        </table>

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
