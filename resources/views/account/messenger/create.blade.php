@extends('app')
@section('content')
<div class="container">
  <h1>Create a new message</h1>
  {!! Form::open(['route' => 'messages.store']) !!}
  <div class="col-md-6">
    <div class="form-group">
      {!! Form::label('recipients', 'Recipients', ['class' => 'control-label']) !!}
      {!! Form::text('recipients', null, ['class' => 'form-control typeahead', 'id' => 'recipients', 'data-provide' => 'typeahead', 'autocomplete' => 'off', 'placeholder' => 'e.g. John Smith']) !!}
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
        case 1  : return 'label label-primary';
        case 2  : return 'label label-warning';
        case 3  : return 'label label-success';
      }
    },
    typeaheadjs: {
      name: 'name',
      displayKey: 'full_name',
      //display: 'users',
      //valueKey: 'id',
      source: recipientshound.ttAdapter(),
      templates: {
        notFound: [
          '<p class="empty-message tt-suggestion">',
          '<strong>No users with that name.</strong>',
          '</p>'
        ].join('\n'),
        suggestion: function (user) {
          return '<p>' + user.full_name + '</p>' + '<p class="text-uppercase text-muted">' + user.address + '</p>';
        }
      }
    }
  });
});
</script>
@stop
