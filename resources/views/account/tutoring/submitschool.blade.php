<!-- resources/views/auth/register.blade.php -->
@extends('app')

@section('content')



<div class="container-fluid">

  @include('/account/tutoring/sidebar')

  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

    <div class="row">
      @include('templates/feedback')
      <div class="page-header">
        <h1>Submit or Edit a School</h1>
      </div>
      <!-- <p class="alert alert-info"><i class="fa fa-info-circle"></i>  This is where you update the classes you can tutor. It is in your best interest to only select classes you can truly tutor, rather than risk negative feedback.</p> -->
    </div>

    <div class="row">
      <ul class="nav nav-tabs" role="tablist">

        <li role="presentation" class="active"><a href="#submit" aria-controls="submitEdit" role="tab" data-toggle="tab">Submit</a></li>
        <li role="presentation"><a href="#edit" aria-controls="edit" role="tab" data-toggle="tab">Edit</a></li>
        <li role="presentation"><a href="#delete" aria-controls="delete" role="tab" data-toggle="tab">Delete</a></li>
      </ul>
      <br>
    </div>

    <div class="row">
      <div class="tab-content">

        <div role="tabpanel" class="tab-pane fade in active" id="submit">
          <div class="col-md-8">
            <div class="panel panel-default">
              <div class="panel-heading"> <!-- <i class="fa fa-bars"></i> School Classes -->
                Enter School Info
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-xs-3">
                    School Name: <span class="text text-danger">*</span>
                  </div>
                  <div class="col-xs-9">

                    <!--<input type="text" class="typeahead form-control" id="searchform" spellcheck="false">-->
                    <input type="text" class="typeahead form-control" id="submitschoolname" data-provide="typeahead">
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-3">
                    School Address: <span class="text text-danger">*</span>
                  </div>
                  <div class="col-xs-9">

                    <input type="text" class="typeahead form-control" spellcheck="false">

                  </div>
                </div>
                <hr>
                <span class="text text-danger">* = Required</span>

                <button class="btn btn-success pull-right" type="button">
                  Submit
                </button>
              </div>
            </div>
          </div>
        </div>

        <div role="tabpanel" class="tab-pane fade in" id="edit">
          <div class="col-md-8">
            <div class="panel panel-default">
              <div class="panel-heading"> <!-- <i class="fa fa-bars"></i> School Classes -->
                Enter School Info
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-xs-3">
                    School Name: <span class="text text-danger">*</span>
                  </div>
                  <div class="col-xs-9">

                    <!--<input type="text" class="typeahead form-control" id="searchform" spellcheck="false">-->
                    <input type="text" class="typeahead form-control" id="editschoolname" data-provide="typeahead">
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-3">
                    School Address: <span class="text text-danger">*</span>
                  </div>
                  <div class="col-xs-9">

                    <input type="text" class="typeahead form-control" spellcheck="false">

                  </div>
                </div>
                <hr>
                <span class="text text-danger">* = Required</span>

                <button class="btn btn-success pull-right" type="button">
                  Submit
                </button>
              </div>
            </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane fade in" id="delete">
          <div class="col-md-8">
            <div class="panel panel-default">
              <div class="panel-heading"> <!-- <i class="fa fa-bars"></i> School Classes -->
                Enter School Info
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-xs-3">
                    School Name: <span class="text text-danger">*</span>
                  </div>
                  <div class="col-xs-9">

                    <!--<input type="text" class="typeahead form-control" id="searchform" spellcheck="false">-->
                    <input type="text" class="typeahead form-control" id="deleteschoolname" data-provide="typeahead">
                  </div>
                </div>
                <hr>
                <span class="text text-danger">* = Required</span>

                <button class="btn btn-danger pull-right" type="button">
                  Delete
                </button>
              </div>
            </div>
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


  $('#editschoolname').typeahead(null, //instantiate edit typeahead
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

    $('#submitschoolname').typeahead(null, //instantiate submit typeahead
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

      $('#deleteschoolname').typeahead(null, //instantiate submit typeahead
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
@stop
