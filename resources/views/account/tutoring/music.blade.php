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
      <p class="alert alert-info"><i class="fa fa-info-circle"></i>  This is where you update your music info. Make sure to fill it out as completely as possible and keep it updated.</p>
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-bars"></i> All Instruments

            </div>
            <div class="panel-body">

              <div class="table-responsive">
                <table id="all_instruments" class="table table-striped table-bordered table-hover"></table>
              </div>
            </div>

          </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6">
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
    tutors_music = false;
    $("#togglebutton").removeClass("btn-danger").addClass("btn-success").html("I teach an instrument");

  }
  else
  {
    tutors_music = true;
    $("#togglebutton").removeClass("btn-success").addClass("btn-danger").html("I do not teach an instrument");
  }

  $.ajax({
    type: "POST",
    url : "{{route('tutoring.ajaxstartstopmusic')}}",
    data: {'tutors_music': 1},
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
