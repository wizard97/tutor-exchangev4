<!-- resources/views/auth/register.blade.php -->
@extends('app')
@section('content')
<div class="container">
{{ \Auth::user()->getName() }}
<a href="{{ route('proposals.submitclass') }}"><button class="btn btn-primary">Submit Class</button></a>
<a href="{{ route('proposals.submitschool') }}"><button class="btn btn-primary">Submit School</button></a>
<a href="{{ route('proposals.submitsubject') }}"><button class="btn btn-primary">Submit Subject</button></a>
</div>
<script>
</script>
@stop
