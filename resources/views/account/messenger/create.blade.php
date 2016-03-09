@extends('app')
@section('content')
<div class="container">
  @include('templates/feedback')
  <h1>Create a new message</h1>
  <hr>
  {!! Form::open(['route' => 'messages.store']) !!}
  <div class="col-md-6">
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
    <div class="form-group">
      {!! Form::label('subject', 'Subject', ['class' => 'control-label']) !!}
      {!! Form::text('subject', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('message', 'Message', ['class' => 'control-label']) !!}
      {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
    </div>
  </div>
  <div class="col-md-12">
    <div class="form-group">
      {!! Form::submit('Submit', ['class' => 'btn btn-primary form-control']) !!}
    </div>
  </div>
  {!! Form::close() !!}
</div>
<script>
$(document).ready(function() {
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
        case '1'  : return 'label label-warning';
        case '2'  : return 'label label-info';
        case '3'  : return 'label label-success';
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
            case '1'  : $element.find('strong').addClass('text-warning'); break;
            case '2'  : $element.find('strong').addClass('text-info'); break;
            case '3'  : $element.find('strong').addClass('text-success'); break;
          }
          return $element;
        }
      }
    }
  });
});
</script>
@stop
