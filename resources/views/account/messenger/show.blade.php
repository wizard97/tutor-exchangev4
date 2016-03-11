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
  @include('templates/feedback')
  {!! Form::open(['route' => ['messages.update', $thread->id], 'method' => 'PUT']) !!}
  <div class="well">
    <div class="form-group">
      {!! Form::label('recipients', 'Recipients', ['class' => 'control-label']) !!}
      {!! Form::select('recipients[]', [], null, ['class' => 'form-control typeahead', 'id' => 'recipients', 'data-provide' => 'typeahead', 'autocomplete' => 'off', 'multiple' => 'multiple']) !!}
      <p class="help-block">
        Key:
        <span class="label label-warning">Standard Users</span>
        <span class="label label-info">Tutors</span>
        <span class="label label-success">Professional Tutors</span>
      </p>
    </div>
  </div>

  <hr>
  <div id="messages" class="row">
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
            <!-- Message Form Input -->
            <div class="form-group">
              {!! Form::textarea('message', null, ['class' => 'form-control', 'placeholder' => 'Write a reply...']) !!}
            </div>
          </div>
          <!-- Submit Form Input -->
          <div class="form-group">
            {!! Form::submit('Submit', ['class' => 'btn btn-info form-control']) !!}
          </div>
        </div>
      </div>
    </div>
    {!! Form::close() !!}
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
$(document).ready(function(){
  var recipientshound = new Bloodhound({
    sufficient: 10,
    identify: function(obj) { return obj.id; },
    queryTokenizer: function(query) {
      var no_commas = query.replace(/,/g, '');
      return Bloodhound.tokenizers.obj.whitespace(no_commas);
    },
    datumTokenizer: function(datum) {
      var tokens = [];
      tokens.push(String(datum.full_name));
      tokens.push(String(datum.city));
      tokens.push(String(datum.state_prefix));
      tokens.push(datum.id);
      return tokens;
    },
    prefetch: "{{ route('messages.prefetch') }}",
    remote: {
      url: '{{ route('messages.query', ['query' => '%QUERY']) }}',
      wildcard: '%QUERY'
    },
  });
  $('#recipients').tagsinput({
    itemValue: 'id',
    itemText: 'full_name',
    tagClass: function(user) {
      switch (user.account_type) {
        case 1  : return 'label label-warning';
        case 2  : return 'label label-info';
        case 3  : return 'label label-success';
      }
    },
    typeaheadjs: {
      name: 'user',
      display: 'full_name',
      source: recipientshound.ttAdapter(),
      templates: {
        notFound: [
          '<p class="empty-message tt-suggestion">',
          '<strong>No users with that name.</strong>',
          '</p>'
        ].join('\n'),
        suggestion: function (user) {
          var $element = $('<p><strong>' + user.full_name + ',</strong> <small>' + user.city  + ' ' + user.state_prefix + '</small></p>');
          switch (user.account_type) {
            case 1  : $element.find('strong').addClass('text-warning'); break;
            case 2  : $element.find('strong').addClass('text-info'); break;
            case 3  : $element.find('strong').addClass('text-success'); break;
          }
          return $element;
        }
      }
    }
  });
  @foreach ($recipients as $recipient)
  $('#recipients').tagsinput('add', { id: '{{ $recipient->user_id }}', full_name: '{{ $recipient->full_name }}', account_type: {{ $recipient->account_type }} });
  @endforeach
});

</script>

@stop
