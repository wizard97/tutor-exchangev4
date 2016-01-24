@extends('app')

@section('content')
<style>
#editor {overflow:scroll; max-height:300px}
#messages {overflow-y:scroll; overflow-x: hidden; max-height:500px}
</style>

<div class="container">
  <br>
    <a href="{{ route('messages.index') }}" class="btn btn-default"><i class="fa fa-chevron-left fa-fw"></i> Message Inbox</a>

  <h2 class="page-header">{{ $thread->subject }}</h2>
  <h4 class="text-info">Participants: {{ $thread->participantsString() }} </h4>
  @include('templates/feedback')
  <hr>
  <div id="messages">
  @foreach($thread->messages as $m)
  <div class="row">

    @if($m->user->id == $userId)
      <div class="col-xs-offset-1 col-xs-11">
    @else
      <div class="col-xs-11">
    @endif

      <?php $c = $m->user->id == $userId ? 'panel-info' : 'panel-default'?>
      <div class="panel hideable {{ $c }}">

        <div class="panel-body" style="">
          <div class="row col-xs-12">
            <span class="text-info">{{ $m->user->getName() }}</span> <small class="pull-right">Sent {!! $m->created_at->diffForHumans() !!}</small>
          </div>
          <div class="row">
            <div class="col-xs-3 col-sm-1">
              <img src="{{ route('profileimage.showfull', ['id' => $m->user_id]) }}" class="img-rounded" width="50" height="50">
            </div>
            <div class="col-xs-7 col-sm-11">
              {!! nl2br(strip_tags($m->body)) !!}
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
@endforeach

</div>

  <div class="row">
    <div class="col-xs-12">
      <div class="well">
        <div class="">
          {!! Form::open(['route' => ['messages.update', $thread->id], 'method' => 'PUT']) !!}

          <!-- Message Form Input -->
          <div class="form-group">
              {!! Form::textarea('message', null, ['class' => 'form-control', 'placeholder' => 'Write a reply...']) !!}
          </div>

        </div>
        <!-- Submit Form Input -->
        <div class="form-group">
            {!! Form::submit('Submit', ['class' => 'btn btn-info form-control']) !!}
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>

<script type='text/javascript'>
$(function () {
  // Scroll to bottom
  var d = $("#messages");
  d.scrollTop(d.prop("scrollHeight"));
/*
  $('html, body').animate({
    scrollTop: $(document).height()
}, 'slow');
*/
});

</script>

@stop
