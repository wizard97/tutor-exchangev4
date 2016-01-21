<!-- resources/views/auth/register.blade.php -->
@extends('app')
@section('content')
<div class="container-fluid">
  @include('/account/tutoring/sidebar')
  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div class="row">
      @include('templates/feedback')
      <div class="page-header">
        <h1>Submit/Edit/Delete a Subject</h1>
      </div>
      <!-- <p class="alert alert-info"><i class="fa fa-info-circle"></i>  This is where you update the classes you can tutor. It is in your best interest to only select classes you can truly tutor, rather than risk negative feedback.</p> -->
    </div>
    <div class="row">
      <div class="col-md-8">
        <div class="panel panel-default">
          <div class="panel-heading"> <!-- <i class="fa fa-bars"></i> School Classes -->
            Submit/Edit/Delete a Subject
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-7">
                <div class="btn-group" role="group">
                  <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-success" id="submitbutton">
                      {!! Form::radio(null) !!} Submit
                    </label>
                    <label class="btn btn-primary" id="editbutton">
                      {!! Form::radio(null) !!} Edit
                    </label>
                    <label class="btn btn-danger" id="deletebutton">
                      {!! Form::radio(null) !!} Delete
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-xs-4">
                {!! Form::label('name', 'Search School') !!}
              </div>
              <div class="col-xs-8">
                {!! Form::text('name', null, ['class' => 'form-control typeahead', 'id' => 'schoolname', 'data-provide' => 'typeahead', 'autocomplete' => 'off', 'placeholder' => 'e.g. Lexington High School']) !!}
              </div>
            </div>
            <div class="row">
              <div class="col-xs-4">
                {!! Form::label('name', 'Search Subject') !!}
              </div>
              <div class="col-xs-8">
                {!! Form::text('name', null, ['class' => 'form-control typeahead', 'id' => 'subjectname', 'data-provide' => 'typeahead', 'autocomplete' => 'off', 'placeholder' => 'e.g. Math']) !!}
              </div>
            </div>
            <div class="row">
              <div class="col-xs-4">
                {!! Form::label('address', 'New Subject Name') !!}
              </div>
              <div class="col-xs-8">
                {!! Form::text('address', null, ['class' => 'form-control typeahead', 'id' => 'newsubjectname', 'autocomplete' => 'off', 'placeholder' => 'e.g. Math']) !!}
              </div>
            </div>
            <hr>
            {!! Form::submit('Submit', ['class' => 'btn btn-success pull-right']); !!}
          </div>
        </div>
      </div>
    </div>
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
  $('#schoolname').typeahead(null, {//instantiate submit typeahead
    source: schools.ttAdapter(),
    display: 'response',
    limit: 5,
    templates: {
      notFound: [
        '<p class="empty-message tt-suggestion">',
        '<strong>No schools with that name.</strong>',
        '</p>'
      ].join('\n'),
      suggestion: function(data) {
        return '<p><strong>' + data.school_name + ',</strong> <small>' + data.city + ', '+ data.state_prefix + ' '+ data.zip_code + '</small></p>';
      }
    }
  });
  $('#schoolname').prop('disabled', true); //disable all buttons by default
  $('#subjectname').prop('disabled', true);
  $('#newsubjectname').prop('disabled', true);

  $('#submitbutton').click(function() {
    $('#schoolname').prop('disabled', false);
    $('#subjectname').prop('disabled', true);
    $('#newsubjectname').prop('disabled', false);
  });
  $('#editbutton').click(function() {
    $('#schoolname').prop('disabled', false);
    $('#subjectname').prop('disabled', false);
    $('#newsubjectname').prop('disabled', false);
  });
  $('#deletebutton').click(function() {
    $('#schoolname').prop('disabled', false);
    $('#subjectname').prop('disabled', false);
    $('#newsubjectname').prop('disabled', true);
  });
});
</script>
@stop
