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
    @include('templates/feedback')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

      <div class="page-header">
        <h1>Step 3. Select Your Classes</h1>
      </div>
      <p class="alert alert-info"><i class="fa fa-info-circle"></i>  This is where you update the classes you can tutor. It is in your best interest to only select classes you can truly tutor, rather than risk negative feedback.</p>

      <div class="row">
        <h2>Classes</h2>
        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading"> <!-- <i class="fa fa-bars"></i> School Classes -->
              <div class="dropdown" id="school-dropdown">
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
            <div class="panel-body">

                <div class="table-responsive">
                  <table id="school-classes" class="table table-striped table-bordered table-hover"></table>
                </div>
              </div>

          </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading"><i class="fa fa-bars"></i> Your Classes: Lexington High School</div>
            <div class="panel-body">
              <div class="table-responsive">
                <table id="tutor-classes" class="table table-striped table-bordered table-hover"></table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <button class="btn btn-default" id="submit-button">Submit</button>
    </div>
  </div>

</div>
<script>
$( document ).ready(function() {
  var tutor_class_url = "{{ route('tutoring.ajaxgettutorschoolclasses') }}";
  var school_class_url = "{{ route('tutoring.ajaxgetschoolclasses') }}"
  var tutor_id = {{ $tutor->user_id }};

  var $school_classes = $('#school-classes');
  var $tutor_classes = $('#tutor-classes');

  //set up the dropdown events
  $('.school-anchor').click( function (e) {
    e.preventDefault();
    var $clicked = $(this);
    var $li_parent = $clicked.closest('li');
    $li_parent.siblings().removeClass('active');
    $li_parent.addClass('active');
    //update dropdown
    $('#school-dropdown').find('#school-dropdown-text').html($clicked.html());
    $tutor_classes.DataTable().ajax.reload();
    $school_classes.DataTable().ajax.reload();
  });

  //choose the first li and select it
  var $first_a = $('#school-dropdown').find('.school-anchor').first();
  if($first_a.length)
  {
    $first_a.closest('li').addClass('active');
    $('#school-dropdown').find('#school-dropdown-text').html($first_a.html());

    //initialize datatable for tutors classes
    $tutor_classes.dataTable({
      ajax: {
        url: tutor_class_url,
        data: function ( d ) {
          d.school_id = $('#school-dropdown').find('li.active').find('.school-anchor').data('schoolid');
          }
      },
      processing: true,
      "order": [[0, 'asc']],
      pageLength: 10,
      columns: [
        { "visible": false, "title": 'Level ID', "data": 'id'},
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
        { "title": 'Class Subject', "data": 'subject_name'},
        { "title": 'Class Level', "data": null, orderable: false, createdCell: function (td, cellData, rowData, row, col) {

          var sel = $('<select class="form-control class-level"></select>').attr("id", 'class-' + rowData.id).attr("name", 'class-' + rowData.id);
          var val = null;
          $(rowData.levels).each(function() {
            sel.append($("<option>").attr('value',this.level_num).text(this.level_name));
            //check if tutor has this
            if (this.selected == 'TRUE') val = this.level_num;
          });
          $(td).html(sel.wrap('<div class="form-group"></div>').prop('outerHTML'));
          if (val != null)
          {
            $row = $(td).closest('tr');
            $(td).find('select').val(val).prop("disabled", true);
            $row.find('i.fa').replaceWith('<i style="font-size: 20px;" class="fa fa-minus"></i>');
            $row.addClass('success');
          }
        }
      }]
    });

    //remove row when clicked_row
    $tutor_classes.on( 'draw.dt', function () {
      $rows = $tutor_classes.find('tr');
      $rows.on( "click", function() {
        $tutor_classes.DataTable().row(this).remove().draw();
      });
    });


    //post update classes
    $('#submit-button').click( function () {
      //start the pretty spinner
      var btn = $(this);
      btn.find('#search-spinner').show();
      var level_ids = [];
      var url = "{{ route('tutoring.editclasses') }}";
      $.each($tutor_classes.DataTable().rows().data(), function(key, value)
      {
        level_ids.push(value.id);
      });

      $.ajax({
        type: "POST",
        data: {'level_ids': level_ids, 'school_id': $('#school-dropdown').find('li.active').find('.school-anchor').data('schoolid')},
        url: url,
        success: function (data){
          $tutor_classes.DataTable().ajax.reload();
          $school_classes.DataTable().ajax.reload();
          btn.find('#search-spinner').hide();
        },
        error: function ()
        {
          btn.find('#search-spinner').hide();
        }
      });
    });

    //remove selected classes


  }

});
</script>
{!! Form::close() !!}

@stop
