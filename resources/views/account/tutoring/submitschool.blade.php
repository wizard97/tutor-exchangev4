<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')



<div class="container-fluid">

  @include('/account/tutoring/sidebar')

  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

    <div class="row">
      @include('templates/feedback')
      <div class="page-header">
        <h1>Submit or Edit a School</h1>
      </div>
      <!-- <p class="alert alert-info"><i class="fa fa-info-circle"></i>  This is where you update the classes you can tutor. It is in your best interest to only select classes you can truly tutor, rather than risk negative feedback.</p> -->
    </div>

    <div class="row">
      <ul class="nav nav-tabs" role="tablist">

        <li role="presentation" class="active"><a href="#submit" aria-controls="submitEdit" role="tab" data-toggle="tab">Submit</a></li>
        <li role="presentation"><a href="#edit" aria-controls="edit" role="tab" data-toggle="tab">Edit</a></li>
        <li role="presentation"><a href="#delete" aria-controls="delete" role="tab" data-toggle="tab">Delete</a></li>
      </ul>
      <br>
    </div>

    <div class="row">
      <div class="tab-content">

        <div role="tabpanel" class="tab-pane fade in active" id="submit">
          <div class="col-md-8">
            <div class="panel panel-default">
              <div class="panel-heading"> <!-- <i class="fa fa-bars"></i> School Classes -->
                Enter School Info
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-xs-3">
                    School Name: <span class="text text-danger">*</span>
                  </div>
                  <div class="col-xs-9">

                    <!--<input type="text" class="typeahead form-control" id="searchform" spellcheck="false">-->
                    <input type="text" class="typeahead form-control" id="searchform" data-provide="typeahead">
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-3">
                    School Address: <span class="text text-danger">*</span>
                  </div>
                  <div class="col-xs-9">

                    <input type="text" class="typeahead form-control" spellcheck="false">

                  </div>
                </div>
                <hr>
                <span class="text text-danger">* = Required</span>

                <button class="btn btn-success pull-right" type="button">
                  Submit
                </button>
              </div>
            </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane fade in" id="delete">
          <div class="col-md-8">
            <div class="panel panel-default">
              <div class="panel-heading">
              </div>
              <div class="panel-body">
              </div>
            </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane fade in" id="edit">
          <div class="col-md-8">
            <div class="panel panel-default">
              <div class="panel-heading">
              </div>
              <div class="panel-body">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){

  $('#searchform').typeahead(null,
    {
      name: 'planets',
      local: [ "Mercury", "Venus", "Earth", "Mars", "Jupiter", "Saturn", "Uranus", "Neptune" ]
    });

  });


});
</script>
@stop
