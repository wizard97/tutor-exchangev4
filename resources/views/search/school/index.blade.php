@extends('app')

@section('content')

<div class="container">

  <div class="page-header">
    <h1>Select Your School</h1>
  </div>
@include('templates/feedback')
<div class="col-md-6">
<div class="form-group">
  <label for="school-input">School Name</label>
  <input type="text" class="typeahead form-control" id="school-input">
</div>
</div>

<script>
// instantiate the bloodhound suggestion engine
$( document ).ready(function() {
  var schools = new Bloodhound({
    sufficient: 10,
    identify: function(obj) { return obj.id; },
    queryTokenizer: function(query) {
      var no_commas = query.replace(/,/g , '');
      return Bloodhound.tokenizers.whitespace(no_commas);
    },
    datumTokenizer: function(datum) {
        var tokens = [];
        tokens.push(datum.school_name);
        tokens.push(datum.city);
        tokens.push(datum.zip_code);
        tokens.push(datum.state_prefix);
        return tokens;
      },
    remote: {
      url: '{{ route('school.query', ['query' => '%QUERY']) }}',
      wildcard: '%QUERY'
    },
  });

  // initialize the bloodhound suggestion engine
  schools.initialize();

  $('.typeahead').typeahead(null,
  {
  source: schools.ttAdapter(),
  display: 'response',
  limit: 15,
  templates: {
    notFound: [
      '<p class="empty-message tt-suggestion">',
        'Unable to find your school',
      '</p>'
    ].join('\n'),
    suggestion: function(data) {
      return '<p><strong>' + data.school_name + '</strong> <small>' + data.city + ', '+ data.state_prefix + ' '+ data.zip_code + '</small></p>';
    }

  }
  });

});

</script>
</div>
@stop
