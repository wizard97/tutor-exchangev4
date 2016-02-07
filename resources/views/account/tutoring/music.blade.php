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
        @if($tutor->tutors_music)
        <button type='button' id="togglebutton" class='btn btn-danger dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> I do not teach an instrument </button>
        @else
        <button type='button' id="togglebutton" class='btn btn-success dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> I teach an instrument </button>
        @endif

      </div>
      <!--
      <p class="alert alert-info"><i class="fa fa-info-circle"></i>  This is where you update your music info. Make sure to fill it out as completely as possible and keep it updated.</p>
    -->
    <div id="to-hide">
      <div class="row">
        <div class="well col-md-10">
          <h3>Add an Instrument</h3>
          <form class="" action="{{ route("tutoring.addmusic") }}" method="POST">
            {!! csrf_field() !!}
            <div class="col-md-12">
            <div class="row">
              <div class="form-group">
                <label for="instrument">Instrument</label>
                <select name="music_id" class="form-control" id="instrument">
                  @foreach ($instruments as $inst)
                  <option value="{{ $inst->id }}">{{ $inst->music_name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label for="years-experiance">Experience Playing Instrument (Years)</label>
                <input type="number" class="form-control" name="years-experiance" placeholder="7">
              </div>

              <div class="form-group">
                <label for="student-experiance">Max Student Experience (Years)</label>
                <input type="number" class="form-control" name="student-experiance" placeholder="3">
              </div>
            </div>
            <div class="row">

              <button type="submit" class="btn btn-success pull-right">Add</button>
            </div>
          </div>
          </form>
        </div>
      </div>

      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-10">
          <div class="panel panel-primary">
            <div class="panel-heading"><i class="fa fa-bars"></i> Your Instruments</div>
            <div class="panel-body">
              <div class="table-responsive">
                <table id="your_instruments" class="table table-striped table-bordered table-hover">

                </table>
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
function hideUnhide()
{
  // currently tutors
  if ($("#togglebutton").hasClass("btn-danger")) $('#to-hide').show();
  else $('#to-hide').hide();
}
$( document ).ready(function() {

  hideUnhide();


  var insts = {!! $tutor->music()->get()->toJson() !!}

  var $your_instruments = $('#your_instruments');

  $your_instruments.DataTable({
    data: insts,
    columns:
    [{'title': 'Instrument:', 'data': 'music_name'},
    {'title': 'Your Years of Experience', 'data': 'pivot.years_experiance'},
    {'title': 'Max Years of Student Experience', 'data': 'pivot.upto_years'},
    {'title': 'Options', 'orderable': false, 'data': null, createdCell: function(td, cellData, rowData, row, col) {
      var string = '<span class="music-remove" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Remove"><i style="font-size: 24px;" class="fa fa-fw fa-minus text-danger center-block"></i></span>';
      $(td).html(string);
      $(td).find(".music-remove").attr('data-musicid', rowData.id);
    }}]
  });
  $(".music-remove").on("click", function( event ){
    var $clk = $(this)
    var id = $clk.data("musicid");
    $.ajax({
      type: "POST",
      url : "{{ route('tutoring.ajaxremovemusic') }}",
      data: {"music_id": id},
      success: function (data){
        $your_instruments.DataTable().row($clk.closest("tr")).remove().draw();
        $('#instrument').prepend($('<option>', {
          value: data.id,
          text: data.music_name
        }));
      }
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
        hideUnhide();
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
  $('[data-toggle="tooltip"]').tooltip()
});
</script>
@stop
