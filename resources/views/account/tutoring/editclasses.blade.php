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

<div class="container-fluid">
  <div class="row">
    @include('/account/tutoring/sidebar')

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <div class="row">
        @include('templates/feedback')
        <div class="page-header">
          <h1>Edit Your Classes</h1>
        </div>
        <p class="alert alert-info"><i class="fa fa-info-circle"></i>  This is where you update the classes you can tutor. It is in your best interest to only select classes you can truly tutor, rather than risk negative feedback.</p>
      </div>

      <div class="row">
        <h2>Middle School and Below Classes</h2>
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-bars"></i> All Classes
            </div>
            <div class="panel-body">

                <div class="table-responsive">
                  <table id="middle-classes" class="table table-striped table-bordered table-hover"></table>
                </div>
              </div>

          </div>
        </div>

        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <div class="row">
                <div class="col-md-6">
                  <i class="fa fa-bars fa-fw"></i> Your Classes:
                </div>
                <div class="col-md-offset-2 col-md-4">
                  <button class="btn btn-success pull-right" id="submit-button-md" disabled><i class="fa fa-floppy-o"></i> Save Changes</button>
                </div>
              </div>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table id="tutor-middle-classes" class="table table-striped table-bordered table-hover"></table>
              </div>
            </div>
          </div>
        </div>
      </div>



      <div class="row">
        <h2>High School and Above Classes</h2>
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading"> <!-- <i class="fa fa-bars"></i> School Classes -->
              <div class="row">
                <div class="dropdown col-md-6" id="school-dropdown">
                  <button class="btn btn-default dropdown-toggle"type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <span id="school-dropdown-text">My Schools</span>
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    @foreach($schools as $school)
                    <li><a href="#" class="school-anchor" data-schoolid="{{ $school->id }}">{{ $school->school_name }} <span class="badge">{{ $school->num_classes }}</span></a></li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
            <div class="panel-body">

                <div class="table-responsive">
                  <table id="school-classes" class="table table-striped table-bordered table-hover"></table>
                </div>
              </div>

          </div>
        </div>

        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <div class="row">
                <div class="col-md-8">
                  <i class="fa fa-bars fa-fw"></i> Your Classes: <span id="current-school"></span>
                </div>
                <div class="col-md-4">
                  <button class="btn btn-success pull-right" id="submit-button" disabled><i class="fa fa-floppy-o"></i> Save Changes</button>
                </div>
              </div>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table id="tutor-classes" class="table table-striped table-bordered table-hover"></table>
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
  var tutor_class_url = "{{ route('tutoring.ajaxgettutorschoolclasses') }}";
  var school_class_url = "{{ route('tutoring.ajaxgetschoolclasses') }}";
  var edit_t_class_url = "{{ route('tutoring.editclasses') }}";

  var t_middle_class_url = "{{ route('tutoring.ajaxgettutormiddleclasses') }}";
  var mid_class_url = "{{ route('tutoring.ajaxgetmiddleclasses') }}";
  var edit_middle_classes_url = "{{ route('tutoring.editmiddleclasses') }}";

  var tutor_id = {{ $tutor->user_id }};

  var $school_classes = $('#school-classes');
  var $tutor_classes = $('#tutor-classes');

  var $tutor_middle_classes = $('#tutor-middle-classes');
  var $middle_classes = $('#middle-classes');

  //middle school and below

  //classes availible
  $middle_classes.dataTable( {
    "lengthMenu": [ 5, 10, 25, 50, 75, 100 ],
    ajax: {
      url: mid_class_url,
    },
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
      { "title": 'Name', "data": 'class_name'},
      { "title": 'Subject', "data": 'subject_name'},
    ],
    createdRow: function( row, data, dataIndex ) {
      //if selected
      if ( data.selected == "TRUE" ) {
        $row = $(row);
        $row.find('i.fa').replaceWith('<i style="font-size: 20px;" class="fa fa-times text-danger"></i>');
        $row.addClass('success');
      }
    },
  });

  //tutors classes
  $tutor_middle_classes.dataTable({
    ajax: {
      url: t_middle_class_url,
    },
    processing: true,
    "order": [],
    pageLength: 10,
    columns: [
      {
        "orderable":      false,
        "className":      'details-control table-text-center',
        "data":           null,
        "defaultContent": '<a href="javascript:void(0)"><i style="font-size: 20px;" class="fa fa-times text-danger"></i></a>'
      },
      { "visible": false, "title": 'Class ID', "data": 'id'},
      { "title": 'Name', "data": 'class_name'},
      { "title": 'Subject', "data": 'subject_name'},
      { "title": 'Added On', "data": 'pivot.created_at', createdCell: function (td, cellData, rowData, row, col) {
        var date = new Date(rowData.pivot.created_at);
        $(td).text(date.toLocaleDateString());
        }
      },
    ]
  });

  //remove row when clicked_row
  $tutor_middle_classes.on( 'draw.dt', function () {
    $rows = $tutor_middle_classes.find('tr');
    //unhook any events
    $rows.off( "click", 'i.fa-times');

    //set up remove class event
    $rows.on( "click", 'i.fa-times', function() {
      var $clicked_row = $(this).closest('tr');
      var data = $tutor_middle_classes.DataTable().row($clicked_row).data();

      //update school classes table
      $middle_classes.DataTable().rows().every( function () {
        var rowdata = this.data();
        if (rowdata.id == data.id)
        {
          //reset it
          $(this.node()).removeClass('success');
          $(this.node()).find('td a').first().html('<i style="font-size: 20px;" class="fa fa-plus"></i>');
          //break out of loop
          return false;
        }
      });
      //enable save button
      $('#submit-button-md').prop("disabled", false).removeClass('btn-success').addClass('btn-danger');
      //remove this row, and draw
      $tutor_middle_classes.DataTable().row($clicked_row).remove().draw();
    });
  });


  //add class event
  $middle_classes.on( 'click', '.table-text-center i.fa', function () {
    var $clicked_row = $(this).closest('tr');
    var $icon = $(this);
    var data = $middle_classes.DataTable().row($clicked_row).data();

    //removing row
    if ($clicked_row.hasClass('success'))
    {
      //update current row
      $icon.replaceWith('<i style="font-size: 20px;" class="fa fa-plus"></i>');
      $clicked_row.removeClass('success');
      //remove it from the tutor classes table
      var $to_remove;
      $tutor_middle_classes.DataTable().rows().every( function () {
        var rowdata = this.data();
        if (rowdata.id == data.id)
        {
          //save the row
          $to_remove = this;
          //break out of loop
          return false;
        }
      });

      $to_remove.remove().draw();

    }
    else
    {
      //update current row
      $icon.replaceWith('<i style="font-size: 20px;" class="fa fa-times text-danger"></i>');
      $clicked_row.addClass('success');
      //add it to the tutor classes table
      var clicked_class = new Object();
      clicked_class.id = data.id;
      clicked_class.class_name = data.class_name;
      clicked_class.subject_name = data.subject_name;
      //insert created at date
      var date = new Date();
      clicked_class.pivot = new Object();
      clicked_class.pivot.created_at = date.toString();
      $tutor_middle_classes.DataTable().row.add(clicked_class).draw();
    }
    //enable save button
    $('#submit-button-md').prop("disabled", false).removeClass('btn-success').addClass('btn-danger');
  });


  //post update classes
  $('#submit-button-md').click( function () {
    //start the pretty spinner
    var $btn = $(this);
    //$btn.find('#search-spinner').show();
    var data = new Object();
    data.class_ids = [];
    $.each($tutor_middle_classes.DataTable().rows().data(), function(key, value)
    {
      data.class_ids.push(value.id);
    });

    $.ajax({
      type: "POST",
      data: data,
      url: edit_middle_classes_url,
      success: function (data){
        $tutor_middle_classes.DataTable().ajax.reload();
        $middle_classes.DataTable().ajax.reload();
        //$btn.find('#search-spinner').hide();

        $('#submit-button-md').removeClass('btn-danger').addClass('btn-success').prop("disabled", true);
      },
      complete: function()
      {
        //render feedback
        lte.feedback();
      }

    });
  });


  //high school and above

  //set up the dropdown events
  $('.school-anchor').click( function (e) {
    e.preventDefault();
    var $clicked = $(this);
    var $li_parent = $clicked.closest('li');
    $li_parent.siblings().removeClass('active');
    $li_parent.addClass('active');
    //update dropdown
    $('#school-dropdown').find('#school-dropdown-text').html($clicked.html());
    $('#current-school').text($clicked.clone().children().remove().end().text());
    $tutor_classes.DataTable().ajax.reload();
    $school_classes.DataTable().ajax.reload();
  });

  //choose the first li and select it
  var $first_a = $('#school-dropdown').find('.school-anchor').first();
  if($first_a.length)
  {
    $first_a.closest('li').addClass('active');
    $('#school-dropdown').find('#school-dropdown-text').html($first_a.html());
    $('#current-school').text($first_a.clone().children().remove().end().text());

    //initialize datatable for tutors classes
    $tutor_classes.dataTable({
      ajax: {
        url: tutor_class_url,
        data: function ( d ) {
          d.school_id = $('#school-dropdown').find('li.active').find('.school-anchor').data('schoolid');
          }
      },
      processing: true,
      "order": [],
      pageLength: 10,
      columns: [
        {
          "orderable":      false,
          "className":      'details-control table-text-center',
          "data":           null,
          "defaultContent": '<a href="javascript:void(0)"><i style="font-size: 20px;" class="fa fa-times text-danger"></i></a>'
        },
        { "visible": false, "title": 'Level ID', "data": 'id'},
        { "visible": false, "title": 'Class ID', "data": 'class_id'},
        { "title": 'Class Name', "data": 'class_name'},
        { "title": 'Highest Level', "data": 'level_name'},
        { "title": 'Subject', "data": 'subject_name'},
        { "title": 'Added On', "data": 'pivot.created_at', createdCell: function (td, cellData, rowData, row, col) {
          var date = new Date(rowData.pivot.created_at);
          $(td).text(date.toLocaleDateString());
          }
        },
      ]
    });

    //datatable for schools classes
    $school_classes.dataTable( {
      "lengthMenu": [ 5, 10, 25, 50, 75, 100 ],
      ajax: {
        url: school_class_url,
        data: function ( d ) {
          d.school_id = $('#school-dropdown').find('li.active').find('.school-anchor').data('schoolid');
          }
      },
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
        { "title": 'Subject', "data": 'subject_name'},
        { "title": 'Class Level', "data": null, orderable: false, createdCell: function (td, cellData, rowData, row, col) {

          var sel = $('<select class="form-control class-level"></select>').attr("id", 'class-' + rowData.id).attr("name", 'class-' + rowData.id);
          var val = null;
          $(rowData.levels).each(function() {
            sel.append($("<option>").attr('value',this.id).text(this.level_name));
            //check if tutor has this
            if (this.selected == 'TRUE') val = this.id;
          });
          $(td).html(sel.wrap('<div class="form-group"></div>').prop('outerHTML'));
          if (val != null)
          {
            $row = $(td).closest('tr');
            $(td).find('select').val(val).prop("disabled", true);
            $row.find('i.fa').replaceWith('<i style="font-size: 20px;" class="fa fa-times text-danger"></i>');
            $row.addClass('success');
          }
        }
      }]
    });

    //remove row when clicked_row
    $tutor_classes.on( 'draw.dt', function () {
      $rows = $tutor_classes.find('tr');
      //unhook any events
      $rows.off( "click", 'i.fa-times');

      //set up remove class event
      $rows.on( "click", 'i.fa-times', function() {
        var $clicked_row = $(this).closest('tr');
        var data = $tutor_classes.DataTable().row($clicked_row).data();

        //update school classes table
        $school_classes.DataTable().rows().every( function () {
          var rowdata = this.data();
          if (rowdata.id == data.class_id)
          {
            //reset it
            $(this.node()).removeClass('success');
            $(this.node()).find('select.class-level').prop('selectedIndex',0).prop("disabled", false);
            $(this.node()).find('td a').first().html('<i style="font-size: 20px;" class="fa fa-plus"></i>');
            //break out of loop
            return false;
          }
        });
        //enable save button
        $('#submit-button').prop("disabled", false).removeClass('btn-success').addClass('btn-danger');
        //remove this row, and draw
        $tutor_classes.DataTable().row($clicked_row).remove().draw();
      });
    });


    //post update classes
    $('#submit-button').click( function () {
      var url = edit_t_class_url;
      //start the pretty spinner
      var $btn = $(this);
      $btn.find('#search-spinner').show();
      var data = new Object();
      data.school_id = $('#school-dropdown').find('li.active').find('.school-anchor').data('schoolid');
      data.level_ids = [];
      $.each($tutor_classes.DataTable().rows().data(), function(key, value)
      {
        data.level_ids.push(value.id);
      });

      $.ajax({
        type: "POST",
        data: data,
        url: url,
        success: function (data){
          $tutor_classes.DataTable().ajax.reload();
          $school_classes.DataTable().ajax.reload();
          $btn.find('#search-spinner').hide();

          $('#submit-button').removeClass('btn-danger').addClass('btn-success').prop("disabled", true);
        },
        complete: function()
        {
          //render feedback
          lte.feedback();
        }

      });
    });

    //add class event
    $school_classes.on( 'click', '.table-text-center i.fa', function () {
      var $clicked_row = $(this).closest('tr');
      var $icon = $(this);
      var data = $school_classes.DataTable().row($clicked_row).data();

      //removing row
      if ($clicked_row.hasClass('success'))
      {
        //update current row
        $clicked_row.find('select.class-level').prop("disabled", false);
        $icon.replaceWith('<i style="font-size: 20px;" class="fa fa-plus"></i>');
        $clicked_row.removeClass('success');
        //remove it from the tutor classes table
        var $to_remove;
        var level_id = $clicked_row.find('select option:selected').val();
        $tutor_classes.DataTable().rows().every( function () {
          var rowdata = this.data();
          if (rowdata.id == level_id)
          {
            //save the row
            $to_remove = this;
            //break out of loop
            return false;
          }
        });

        $to_remove.remove().draw();

      }
      else
      {
        //update current row
        $clicked_row.find('select.class-level').prop("disabled", true);
        $icon.replaceWith('<i style="font-size: 20px;" class="fa fa-times text-danger"></i>');
        $clicked_row.addClass('success');
        //add it to the tutor classes table
        var clicked_class = new Object();
        clicked_class.class_id = data.id;
        clicked_class.class_name = data.class_name;
        clicked_class.subject_name = data.subject_name;
        clicked_class.id = $clicked_row.find('select.class-level').val();
        clicked_class.level_name = $clicked_row.find('select.class-level option:selected').text();
        //insert created at date
        var date = new Date();
        clicked_class.pivot = new Object();
        clicked_class.pivot.created_at = date.toString();
        $tutor_classes.DataTable().row.add(clicked_class).draw();
      }
      //enable save button
      $('#submit-button').prop("disabled", false).removeClass('btn-success').addClass('btn-danger');
    });


  }

});
</script>

@stop
