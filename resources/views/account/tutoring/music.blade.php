<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')
<div class="container-fluid">
  <div class="row">
    @include('/account/tutoring/sidebar')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      @include('templates/feedback')
      <div class="page-header">
        <h1>My Music</h1>
        <button type='button' id="togglebutton" class='btn btn-danger dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> I do not teach an instrument </button>
      </div>
      <!--
      <p class="alert alert-info"><i class="fa fa-info-circle"></i>  This is where you update your music info. Make sure to fill it out as completely as possible and keep it updated.</p>
    -->
      <div id="to-hide">
        <div class="row">
          <div class="well col-md-10">
            <h3>Add an Instrument</h3>
            <form class="">

              <div class="form-group">
                <label for="instrument">Instrument</label>
                <select class="form-control" id="instrument">
                  @foreach ($instruments as $inst)
                  <option value="{{ $inst->id }}">{{ $inst->music_name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label for="years-experiance">Experience Playing Instrument (Years)</label>
                <input type="number" class="form-control" id="years-experiance" placeholder="7">
              </div>

              <div class="form-group">
                <label for="student-experiance">Max Student Experience (Years)</label>
                <input type="number" class="form-control" id="student-experiance" placeholder="3">
              </div>

              <button type="submit" class="btn btn-success pull-right">Add</button>

            </form>
          </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-primary">
              <div class="panel-heading"><i class="fa fa-bars"></i> Your Instruments</div>
              <div class="panel-body">
                <div class="table-responsive">
                  <table id="your_instruments" class="table table-striped table-bordered table-hover"></table>
                </div>
              </div>
            </div>
          </div>
        </div>

    </div>

    </div>
  </div>
</div>

<script>
$( document ).ready(function() {
  var data1 = [['Flute', 'French']];
  var data2 = [['Flute', '11 years', '2 years']]
  var $all_instruments = $('#all_instruments');
  var $your_instruments = $('#your_instruments');
  $all_instruments.DataTable({
    data: data1,
    columns: [{'title': 'Instrument'}, {'title': 'Options', 'orderable': false, 'data': null, createdCell: function(td, cellData, rowData, row, col){
      var string = "<button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Add </button>"
      $(td).html(string);
    }}
  ]
});
$your_instruments.DataTable({
  data: data2,
  columns: [{'title': 'Instrument:'}, {'title': 'Your Experience'}, {'title': 'Student Experience'}
  , {'orderable': false, 'data': null, createdCell: function(td, cellData, rowData, row, col) {
    var string = '<i style="font-size: 20px;" class="fa fa-fw fa-minus text-danger"></i>';
    $(td).html(string);
  }}]
});
});
$("#togglebutton").click(function() {
  var tutors_music;
  if ($("#togglebutton").hasClass("btn-danger"))
  {
    tutors_music = 0;
    $("#togglebutton").removeClass("btn-danger").addClass("btn-success").html("I teach an instrument");

  }
  else
  {
    tutors_music = 1;
    $("#togglebutton").removeClass("btn-success").addClass("btn-danger").html("I do not teach an instrument");
  }

  $.ajax({
    type: "POST",
    url : "{{route('tutoring.ajaxstartstopmusic')}}",
    data: {'tutors_music': tutors_music},
    success : function(data){
      $.ajax({
        type: "GET",
        url : "{{ route('feedback') }}",
        success: function (data){
          $("#feedback").replaceWith(function() {
            return $(data).hide().fadeIn('slow');
          });
        }
      });
    }
  });
});
</script>
@stop
