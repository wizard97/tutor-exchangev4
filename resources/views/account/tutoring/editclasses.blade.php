<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')
<div class="container-fluid">
  <div class="row">
    @include('/account/tutoring/sidebar')
    @include('templates/feedback')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

      <div class="page-header">
        <h1>Step 3. Select Your Classes</h1>
      </div>
      <div class="row">
        <h2>School</h2>
        <div class="col-xs-12 col-sm-6 col-md-6">

          <div class="input-group">
            <input type="text" class="typeahead form-control tt-input" id="school-input" name="school_name" autocomplete="off" spellcheck="false" dir="auto" style="position: relative; vertical-align: top; background-color: transparent;">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Go!</button>
            </span>
          </div>
        </div>
      </div>
      <div class="row">
        <h2>Classes</h2>
        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-bars"></i> School Classes</div>
            <div class="panel-body">
              <div class="table-responsive">
                <table id="school_classes" class="table table-striped table-bordered table-hover"></table>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading"><i class="fa fa-bars"></i> Your Classes</div>
            <div class="panel-body">
              <div class="table-responsive">
                <table id="your_classes" class="table table-striped table-bordered table-hover"></table>
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
  var data = [['French Film', 'French'],['American History', 'Social Studies'],['Holocaust', 'English']];
  var $school_classes = $('#school_classes');
  var $your_classes = $('#your_classes');
  $school_classes.DataTable({
    data: data,
    columns: [{'title': 'Class Name:'}, {'title': 'Class Subject'}, {'title': 'Class Level', 'orderable': false, 'data': null, createdCell: function(td, cellData, rowData, row, col){
      var string = "<div class='btn-group'><button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Level <span class='caret'></span></button><ul class='dropdown-menu'><li><a href='#'>Level 2</a></li><li><a href='#'>Level 1</a></li><li><a href='#'>Honors</a></li><li><a href='#'>AP</a></li></ul></div>"
      $(td).html(string);
    }}, {'orderable': false, 'data': null, createdCell: function(td, cellData, rowData, row, col) {
      var string = '<i style="font-size: 20px;" class="fa fa-fw fa-plus text-success"></i>';
      $(td).html(string);
    }}]
  });
  $your_classes.DataTable({
    data: data,
    columns: [{'title': 'Class Name:'}, {'title': 'Class Subject'}, {'title': 'Class Level', 'orderable': false, 'data': null, createdCell: function(td, cellData, rowData, row, col){
      var string = "<div class='btn-group'><button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Level <span class='caret'></span></button><ul class='dropdown-menu'><li><a href='#'>Level 2</a></li><li><a href='#'>Level 1</a></li><li><a href='#'>Honors</a></li><li><a href='#'>AP</a></li></ul></div>"
      $(td).html(string);
    }}, {'orderable': false, 'data': null, createdCell: function(td, cellData, rowData, row, col) {
      var string = '<i style="font-size: 20px;" class="fa fa-fw fa-minus text-danger"></i>';
      $(td).html(string);
    }}]
  });
});
</script>
{!! Form::close() !!}

@stop
