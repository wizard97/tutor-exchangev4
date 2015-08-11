<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')

<div class="container-fluid">
  <div class="row">
  @include('/account/tutoring/sidebar')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

      @include('templates/feedback')
      <div class="page-header">
        <h1>Your Profile<small> This is how others will see it</small></h1>
      </div>

      @include('/search/profile')

    </div>
  </div>
</div>

@stop
