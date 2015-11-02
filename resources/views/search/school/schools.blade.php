@extends('app')

@section('content')

<div class="container">

  <div class="page-header">
    <h1>Select Your School</h1>
  </div>
  @include('templates/feedback')
  <div class="col-md-6 col-md-offset-3">
    <div class="well">
    <form action="{{ route('hs.submitschool') }}" method="POST">
      {!! csrf_field() !!}

      <div class="form-group">
        <label for="school-input">School Name</label>
        <div class="input-group">
          <input type="search" class="typeahead form-control" id="school-input" name="school_name">
          <span class="input-group-btn">
          <button class="btn btn-success" type="submit">Submit</button>
        </span>
        </div>
      </div>
    </div>
    </div>
    </form>
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
        tokens.push(String(datum.school_name));
        tokens.push(String(datum.city));
        tokens.push(String(datum.zip_code));
        tokens.push(String(datum.state_prefix));
        tokens.push(String(datum.school_id));
        return tokens;
      },
      prefetch: "{{route('hs.prefetch')}}",
      remote: {
        url: '{{ route('hs.query', ['query' => '%QUERY']) }}',
        wildcard: '%QUERY'
      },
    });


    $('.typeahead').typeahead(null,
      {
        source: schools.ttAdapter(),
        display: 'response',
        limit: 5,
        templates: {
          notFound: [
            '<p class="empty-message tt-suggestion">',
            '<strong>Sorry, no tutors belong to that school.</strong>',
            '</p>'
          ].join('\n'),
          suggestion: function(data) {
            return '<p><strong>' + data.school_name + ',</strong> <small>' + data.city + ', '+ data.state_prefix + ' '+ data.zip_code + '</small></p>';
          }

        }
      });

    });

    </script>
  </div>
  @stop
