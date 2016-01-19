<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')



<div class="container-fluid">

  @include('/account/tutoring/sidebar')

  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

    <div class="row">
      @include('templates/feedback')
      <div class="page-header">
        <h1>Submit or Edit a Class/Level</h1>
      </div>
      <!-- <p class="alert alert-info"><i class="fa fa-info-circle"></i>  This is where you update the classes you can tutor. It is in your best interest to only select classes you can truly tutor, rather than risk negative feedback.</p> -->
    </div>
    <div class="row">
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
            <div class="row">
              <div class="col-md-4">
                Class Name: <span class="text text-danger">*</span>
              </div>
              <div class="col-md-8">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="e.g. Calculus" aria-describedby="basic-addon1">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                Select Subject: <span class="text text-danger">*</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="dropdown">
                  <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Subject
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a href="#">English</a></li>
                    <li><a href="#">Social Studies</a></li>
                    <li><a href="#">Science</a></li>
                    <li><a href="#">Math</a></li>
                    <li><a href="#">Foreign Language</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#">Elementary/Middle School English</a></li>
                    <li><a href="#">Elementary/Middle School Social Studies</a></li>
                    <li><a href="#">Elementary/Middle School Science</a></li>
                    <li><a href="#">Elementary/Middle School Math</a></li>
                    <li><a href="#">Elementary/Middle School Foreign Language</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Level Name" aria-describedby="basic-addon2">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="fa fa-plus"></i></button>
                  </span>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table id="add-classes" class="table table-striped table-bordered table-hover"></table>
            </div>
            <span class="text text-danger">* = Required</span>

            <button class="btn btn-success pull-right" type="button">
              Submit
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
var $add_classes = $('#add-classes');
var placeholder_data = [['Level 2'], ['Level 1'], ['AP 1'], ['AP 2']];
//add classes
$add_classes.dataTable( {
  data: placeholder_data,
  "dom": 't',
  columns: [
    {title: "Level"},
    {title: "Level Degree", visible: false, data: null},
    {title: "Options", "width": "10%", orderable: false, data: null, createdCell: function (td, cellData, rowData, row, col) {
      $(td).html('<i class="fa fa-chevron-down"></i><i class="fa fa-chevron-up"></i><i class="fa fa-times"></i>');
    }
  }
]
});
</script>
@stop
