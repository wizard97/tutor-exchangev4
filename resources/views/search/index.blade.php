@extends('app')

@section('content')
<div class="container">
<div class="page-header">
  <h1>What Kind of Help Do You Need?</h1>
</div>

  <div class="col-md-6">
    <a class="btn btn-primary btn-block" href="{{ route('school.index') }}">School Tutoring</a>
    <a class="btn btn-success btn-block disabled" href="">Music</a>
    <a class="btn btn-warning btn-block disabled" href="">Other</a>
  </div>

</div>
@stop
