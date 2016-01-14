<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')



<div class="container-fluid">

  @include('/account/tutoring/sidebar')

  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

    <div class="row">
      @include('templates/feedback')
      <div class="page-header">
        <h1>Submit a New School</h1>
      </div>
      <!-- <p class="alert alert-info"><i class="fa fa-info-circle"></i>  This is where you update the classes you can tutor. It is in your best interest to only select classes you can truly tutor, rather than risk negative feedback.</p> -->
    </div>
    <div class="row">
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

                  <input type="text" class="form-control" placeholder="e.g. Lexington High School" aria-describedby="basic-addon1">

              </div>
            </div>
            <div class="row">
              <div class="col-xs-3">
                School Address: <span class="text text-danger">*</span>
              </div>
              <div class="col-xs-9">

                  <input type="text" class="form-control" placeholder="e.g. # Streetname Ave, Town, MA Zip, Country" aria-describedby="basic-addon1">

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
  </div>
</div>
@stop
