<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')

<div class="container-fluid">
  <div class="row">
  @include('/account/tutoring/sidebar')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

      <div class="page-header">
        <h1>Tutoring Settings</h1>
      </div>
        @include('templates/feedback')

        <div class="alert alert-warning">
          <strong>Under Construction!</strong> This page is under construction.
        </div>

    </div>
  </div>
</div>

@stop
