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
    identify: function(obj) { return obj.title; },
    queryTokenizer: function(query) {
      var no_commas = query.replace(/,/g, '');
      return Bloodhound.tokenizers.whitespace(no_commas);
    },
    datumTokenizer: function(datum) {
      var tokens = [];
      tokens.push(String(datum.title));
      return tokens;
    },
    prefetch: "{{ route('messages.prefetch') }}",
    remote: {
      url: '{{ route('messages.query', ['query' => '%QUERY']) }}',
      wildcard: '%QUERY'
    },
  });
  $('#recipients').tagsinput({
    //itemValue: 'id',
    //itemText: 'fname',
    typeaheadjs: {
      name: 'name',
      displayKey: 'fname',
      valueKey: 'id',
      source: recipientshound.ttAdapter(),
      suggestion: function (user) {
            return '<p>' + user.fname + '</p>';
        }
    }
  });
});
</script>
@stop
