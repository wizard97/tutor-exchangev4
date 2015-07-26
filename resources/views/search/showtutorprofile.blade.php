<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')
<div class="container">
<div class="page-header">
  <h1>{{ $tutor->fname.' '.$tutor->lname }}</h1>
</div>

@include('templates/feedback')

@include('/search/profile')

</div>
@stop
