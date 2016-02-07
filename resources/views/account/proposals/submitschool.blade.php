<!-- resources/views/auth/register.blade.php -->
@extends('app')
@section('content')
<div class="container">
  <div class="">
    <div class="row">
      @include('templates/feedback')
      <div class="page-header">
        <h1>Submit/Edit/Delete a School</h1>
      </div>
      <!-- <p class="alert alert-info"><i class="fa fa-info-circle"></i>  This is where you update the classes you can tutor. It is in your best interest to only select classes you can truly tutor, rather than risk negative feedback.</p> -->
    </div>
    <div class="row">
      <div class="col-md-8">
        <div class="panel panel-default">
          <div class="panel-heading"> <!-- <i class="fa fa-bars"></i> School Classes -->
            Submit/Edit/Delete a School
          </div>
          <div class="panel-body">
            {!! Form::open(array('url' => route('proposals.submitschoolproposal'))) !!}
            <div class="row">
              <div class="col-md-7">
                <div class="btn-group" role="group">
                  <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-success" id="submitbutton">
                      {!! Form::radio('proposal_type', 'create') !!} Create
                    </label>
                    <label class="btn btn-primary" id="editbutton">
                      {!! Form::radio('proposal_type', 'edit') !!} Edit
                    </label>
                    <label class="btn btn-danger" id="deletebutton">
                      {!! Form::radio('proposal_type', 'delete') !!} Delete
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-xs-4">
                {!! Form::label('school_search', 'Search School') !!}
              </div>
              <div class="col-xs-8">
                {!! Form::text('school_search', null, ['class' => 'form-control typeahead', 'id' => 'schoolname', 'data-provide' => 'typeahead', 'autocomplete' => 'off', 'placeholder' => 'e.g. Lexington High School']) !!}
              </div>
            </div>
            <div class="row">
              <div class="col-xs-4">
                {!! Form::label('school_name', 'School Name') !!}
              </div>
              <div class="col-xs-8">
                {!! Form::text('school_name', null, ['class' => 'form-control typeahead', 'id' => 'newschoolname', 'data-provide' => 'typeahead', 'autocomplete' => 'off', 'placeholder' => 'e.g. Lexington High School']) !!}
              </div>
            </div>
            <div class="row">
              <div class="col-xs-4">
                {!! Form::label('address', 'School Address') !!}
              </div>
              <div class="col-xs-8">
                {!! Form::text('address', null, ['class' => 'form-control typeahead', 'id' => 'schooladdress', 'autocomplete' => 'off', 'placeholder' => 'e.g. 78 Main Street, Boston, MA 02115, USA']) !!}
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
  $('#newschoolname').prop('disabled', true);
  $('#schooladdress').prop('disabled', true);

  $('#submitbutton').click(function() {
    $('#schoolname').prop('disabled', true);
    $('#newschoolname').prop('disabled', false);
    $('#schooladdress').prop('disabled', false);
  });
  $('#editbutton').click(function() {
    $('#schoolname').prop('disabled', false);
    $('#newschoolname').prop('disabled', false);
    $('#schooladdress').prop('disabled', false);
  });
  $('#deletebutton').click(function() {
    $('#schoolname').prop('disabled', false);
    $('#newschoolname').prop('disabled', true);
    $('#schooladdress').prop('disabled', true);
  });
});
</script>
@stop
