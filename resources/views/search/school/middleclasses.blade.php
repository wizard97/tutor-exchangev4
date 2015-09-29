<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')
<style>
.table > tbody > tr > td {
  vertical-align: middle;
}
.table-text-center {
  text-align: center;
}
</style>

<div class="container">
  <div class="page-header">
    <h1>Select Your Classes</h1>
  </div>

  @include('templates/feedback')


  <div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7">
      <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-bars"></i> Classes</div>
        <div class="panel-body">
          <div class="table-responsive">
            <table id="school-classes" class="table table-striped table-bordered table-hover"></table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xs-12 col-sm-5 col-md-5">
      <div class="panel panel-primary">
        <div class="panel-heading"><i class="fa fa-bars"></i> Your selections</div>
        <div class="panel-body">
          <div class="table-responsive">
            <table id="selected-classes" class="table table-condensed"></table>
          </div>
          <button id="search-button" class="btn btn-success btn-block"><i id="search-spinner" class="fa fa-spinner fa-spin" style="display: none;"></i> Search For Tutors</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

$(document).ready(function() {

  //selected classes table
  var $selected = $('#selected-classes');
  $selected.dataTable( {
    paging: true,
    searching: false,
    stateSave: false,
    ordering: false,
    dom: 'rtip',
    columns: [
      { "visible": false, "title": 'Class ID', "data": 'id'},
      { "title": 'Class Name', "data": 'class_name'},
      { "title": 'Subject', "data": 'subject_name'},
      {
        "orderable":      false,
        "className":      'details-control table-text-center',
        "data":           null,
        "defaultContent": '<button class="btn btn-danger class-remove-btn">Remove</button>'
      },
    ]
  });


  //array of array of classes keyed by subject
  var class_subjects = {};
  $.each(classes, function(idx, val) {
    if (typeof class_subjects[val.subject_name] == 'undefined') {
      class_subjects[val.subject_name] = new Array();
    }
    class_subjects[val.subject_name].push(val.id);
  });

  var $class_table = $('#school-classes');
  $class_table.dataTable( {
    data: classes,
    processing: true,
    stateSave: true,
    "order": [],
    "dom": 'lfrtip',
    columns: [
      {
        "orderable":      false,
        "className":      'details-control table-text-center',
        "data":           null,
        "defaultContent": '<a href="javascript:void(0)"><i style="font-size: 20px;" class="fa fa-plus"></i></a>'
      },
      { "visible": false, "title": 'Class ID', "data": 'id'},
      { "title": 'Class Name', "data": 'class_name'},
      { "title": 'Class Subject', "data": 'subject_name'},
    ]
  });


  $('#school-classes tbody').on( 'click', '.table-text-center', function () {
    var $clicked_row = $(this).closest('tr');
    var $icon = $clicked_row.find("i.fa");
    var data = $class_table.DataTable().row($clicked_row).data();

    if ($icon.hasClass('fa-plus'))
    {
      var search_class = new Object();
      search_class.id = data.id;
      search_class.class_name = data.class_name;
      search_class.subject_name = data.subject_name;
      $button = $($selected.DataTable().row.add(search_class).draw().node()).find('.class-remove-btn');
      $button.on( "click", function() {
        var $clicked_row = $(this).closest('tr');
        var data = $selected.DataTable().row($clicked_row).data();

        var all_rows = $class_table.DataTable().rows().every( function () {
          var rowdata = this.data();
          if (rowdata.id == data.id)
          {
            $(this.node()).hide();
            $(this.node()).removeClass('success');
            ($(this.node()).find("i.fa")).replaceWith('<i style="font-size: 20px;" class="fa fa-plus"></i>');
            $(this.node()).fadeIn();
            return false;
          }
        });
        $selected.DataTable().row($clicked_row).remove().draw();
      });
      $clicked_row.hide();
      $icon.replaceWith('<i style="font-size: 20px;" class="fa fa-minus"></i>');
      $clicked_row.addClass('success');
      $clicked_row.fadeIn();

    }
    else {
      var to_remove;
      var all_rows = $selected.DataTable().rows().every( function () {
        var rowdata = this.data();
        if (rowdata.id == data.id)
        {
          //exception thrown, if removed in loop
          to_remove = this;
          $clicked_row.hide();
          $icon.replaceWith('<i style="font-size: 20px;" class="fa fa-plus"></i>');
          $clicked_row.removeClass('success');
          $clicked_row.fadeIn();
          return false;
        }
      });
      to_remove.remove().draw();
    }

  });



  $('#search-button').click( function () {
    //start the pretty spinner
    var btn = $(this);
    btn.find('#search-spinner').show();
    var class_ids = [];
    var url = "{{ route('middle.submitclasses') }}";
    $.each($selected.DataTable().rows().data(), function(key, value)
    {
      class_ids.push(value.id);
    });
          console.log(class_ids);
    $.ajax({
      type: "POST",
      data: {'class_ids': class_ids},
      url: url,
      success: function (data){
        location.href= data;
        btn.find('#search-spinner').hide();
      },
      error: function ()
      {
        btn.find('#search-spinner').hide();
      }
    });
  });

});


</script>
@stop
