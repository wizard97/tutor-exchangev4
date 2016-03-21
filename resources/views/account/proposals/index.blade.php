<!-- resources/views/auth/register.blade.php -->
@extends('app')
@section('content')
<div class="container">
    @include('templates/feedback')
    <div class="page-header">
        <h1>Contribute new School/Subject/Class Proposals</h1>
    </div>
    <div class="btn-group" role="group">
        <!--<a href="{{ route('proposals.submitclass') }}"><button class="btn btn-primary">Submit Class</button></a>
        <a href="{{ route('proposals.submitschool') }}"><button class="btn btn-primary">Submit School</button></a>
        <a href="{{ route('proposals.submitsubject') }}"><button class="btn btn-primary">Submit Subject</button></a>-->
        <a class="btn btn-primary btn-lg" href="{{ route('proposals.submitclass') }}">Submit Class</a>
        <a class="btn btn-success btn-lg" href="{{ route('proposals.submitschool') }}">Submit School</a>
        <a class="btn btn-default btn-lg" href="{{ route('proposals.submitsubject') }}">Submit Subject</a>
    </div>
</div>
<script>
</script>
@stop
