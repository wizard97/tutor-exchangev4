<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')
<style>
.table tbody>tr>td.vert-align{
    vertical-align: middle;
}
</style>
<div class="container-fluid">
  <div class="row">
    @include('/account/tutoring/sidebar')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

      @include('templates/feedback')

      <div class="page-header">
        <h1>Your Schedule</h1>
      </div>

      <p class="alert alert-info"><i class="fa fa-info-circle"></i>  This is where you update your tutoring schedule. Make sure it accurately reflects your availability.</p>

      <form action="{{ route('tutoring.editschedule') }}" method="POST">
      {!! csrf_field() !!}


        <table class="table table-bordered table-striped table-condensed">
          <thead>
            <tr>
              <th class="text-center text-primary">Day</th>
              <th class="text-center text-primary">Range 1</th>
              <th class="text-center text-primary">Range 2</th>

            </tr>
          </thead>
          <tbody>
            <?php $days = ['mon' => 'Monday', 'tues' => 'Tuesday', 'wed' => 'Wednesday', 'thurs' => 'Thursday', 'fri' => 'Friday', 'sat' => 'Saturday', 'sun' => 'Sunday']; ?>

            @foreach($days as $key => $day)
            <tr class="time-row">
              <td class="vert-align">
                <label>{{ $day }}</label>
              </td>

              <td>

                <div class="row">
                  <div class="col-md-5">
                    <div class="input-group clockpicker">
                      <input type="text" class="form-control" @if($tutor->{$key.'1_start'}) value="{{ date('g:iA', strtotime($tutor->{$key.'1_start'})) }}" @endif name="{{ $key.'1_start' }}" style="min-width: 90px" placeholder="Empty">
                      <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                      </span>
                    </div>
                  </div>

                  <div class="col-md-1 text-center">
                    <!-- Kind of a hack, will need to find a better solution-->
                    <label style="margin-top: 7px">to</label>
                  </div>

                  <div class="col-md-5">
                    <div class="input-group clockpicker">
                      <input type="text" class="form-control" @if($tutor->{$key.'1_end'}) value="{{ date('g:iA', strtotime($tutor->{$key.'1_end'})) }}" @endif name="{{ $key.'1_end' }}" style="min-width: 90px" placeholder="Empty">
                      <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                      </span>
                    </div>
                  </div>
                </div>
              </td>

              <td>

                <div class="row">
                  <div class="col-md-5">
                    <div class="input-group clockpicker">
                      <input type="text" class="form-control" @if($tutor->{$key.'2_start'}) value="{{ date('g:iA', strtotime($tutor->{$key.'2_start'})) }}" @endif name="{{ $key.'2_start' }}" style="min-width: 90px" placeholder="Empty">
                      <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                      </span>
                    </div>
                  </div>

                  <div class="col-md-1 text-center">
                    <!-- Kind of a hack, will need to find a better solution-->
                    <label style="margin-top: 7px">to</label>
                  </div>

                  <div class="col-md-5">
                    <div class="input-group clockpicker">
                      <input type="text" class="form-control" @if($tutor->{$key.'2_end'}) value="{{ date('g:iA', strtotime($tutor->{$key.'2_end'})) }}" @endif name="{{ $key.'2_end' }}" style="min-width: 90px" placeholder="Empty">
                      <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                      </span>
                    </div>
                  </div>
                </div>
              </td>

            </tr>
            @endforeach
          </tbody>
        </table>


        <div class="row col-xs-4">
          <button type="submit" class="btn btn-lg btn-primary"> <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update </button>
        </div>


      <div class="clearfix"></div>

    </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  $('.clockpicker').clockpicker({
    align: 'top',
    donetext: 'Done',
    twelvehour: true,
    });
});
</script>
@stop
