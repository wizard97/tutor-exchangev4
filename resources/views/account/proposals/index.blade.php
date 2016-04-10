<!-- resources/views/auth/register.blade.php -->
@extends('app')
@section('content')
<div class="container">
    @include('templates/feedback')
    <div class="page-header">
        <h1>Contribute new School/Subject/Class Proposals</h1>
    </div>


    <div class="list-group col-md-10">
        @foreach($proposals as $p)
        <a href="#" class="list-group-item">
            <div class="row">
                <div class="col-md-1">
                    <h4 class="text-center">
                        @if($p->status->slug == 'accepted')
                        <i class="text-success fa fa-check fa-fw"></i>
                        @elseif($p->status->slug == 'pend_acpt')
                        <i class="text-warning fa fa-clock-o"></i>
                        @else
                        <i class="text-danger fa fa-ban fa-fw"></i>
                        @endif

                    </h4>
                </div>

                <div class="col-md-10">
                    <div class="row">
                        <strong class="col-md-12">{{ $p->title }}</strong>
                    </div>

                    <div class="row">
                        <small class="col-md-12 text-muted">#{{ $p->id }} opened on {{ $p->created_at->toFormattedDateString() }}</small>
                    </div>
                </div>

                <div class="col-md-1">
                    <p class="text-right"><i class="fa fa-comment-o fa-fw"></i>3</p>
                </div>
            </div>

        </a>
        @endforeach
    </div>

    <div class="col-md-10 btn-group" role="group">
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
