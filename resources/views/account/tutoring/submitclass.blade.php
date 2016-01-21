<!-- resources/views/auth/register.blade.php -->
@extends('app')
@section('content')
<div class="container-fluid">
  @include('/account/tutoring/sidebar')
  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

    <div class="row">
      @include('templates/feedback')
      <div class="page-header">
        <h1>Submit/Edit/Delete a Class/Level</h1>
      </div>
      <!-- <p class="alert alert-info"><i class="fa fa-info-circle"></i>  This is where you update the classes you can tutor. It is in your best interest to only select classes you can truly tutor, rather than risk negative feedback.</p> -->
    </div>
    <div class="row">
      <div class="col-md-6">
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
              <div class="col-md-12">
                <div class="panel panel-default">
                  <div class="panel-heading"> <!-- <i class="fa fa-bars"></i> School Classes -->
                    Enter School Info
                  </div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-xs-4">
                        {!! Form::label('name', 'School Name') !!} <span class="text text-danger">*</span>
                      </div>
                      <div class="col-xs-8">
                        {!! Form::text('name', null, ['class' => 'form-control typeahead', 'id' => 'submitclassschoolname', 'autocomplete' => 'off', 'placeholder' => 'e.g. Lexington High School']) !!}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-4">
                        {!! Form::label('subject', 'Class Name') !!} <span class="text text-danger">*</span>
                      </div>
                      <div class="col-xs-8">
                        {!! Form::text('subject', null, ['class' => 'form-control', 'id' => 'submitclassname', 'autocomplete' => 'off', 'placeholder' => 'e.g. Calculus']) !!}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-4">
                        {!! Form::label('subject', 'Subject') !!} <span class="text text-danger">*</span>
                      </div>
                      <div class="col-xs-8">
                        {!! Form::text('subject', null, ['class' => 'form-control', 'id' => 'submitclasssubjectname', 'autocomplete' => 'off', 'placeholder' => 'e.g. Math']) !!}
                      </div>
                    </div>
                    <hr>
                    <span class="text text-danger">* = Required</span>
                    {!! Form::submit('Submit', ['class' => 'btn btn-success pull-right']); !!}
                  </div>
                </div>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane fade in" id="edit">
              <div class="col-md-12">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    Enter School Info
                  </div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-xs-4">
                        {!! Form::label('school', 'School Name') !!} <span class="text text-danger">*</span>
                      </div>
                      <div class="col-xs-8">
                        {!! Form::text('school', null, ['class' => 'form-control typeahead', 'id' => 'editclassschoolname', 'autocomplete' => 'off', 'placeholder' => 'e.g. Lexington High School']) !!}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-4">
                        {!! Form::label('class', 'Class Name') !!} <span class="text text-danger">*</span>
                      </div>
                      <div class="col-xs-8">
                        {!! Form::text('class', null, ['class' => 'form-control typeahead', 'id' => 'editclassname', 'autocomplete' => 'off', 'placeholder' => 'e.g. Calculus']) !!}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-4">
                        {!! Form::label('name', 'New Name') !!} <span class="text text-danger">*</span>
                      </div>
                      <div class="col-xs-8">
                        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'editedclassname', 'autocomplete' => 'off', 'placeholder' => 'e.g. Calculus']) !!}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-4">
                        {!! Form::label('subject', 'New Subject') !!} <span class="text text-danger">*</span>
                      </div>
                      <div class="col-xs-8">
                        {!! Form::text('subject', null, ['class' => 'form-control', 'id' => 'editedclasssubject', 'autocomplete' => 'off', 'placeholder' => 'e.g. Calculus']) !!}
                      </div>
                    </div>
                    <hr>
                    <span class="text text-danger">* = Required</span>
                    {!! Form::submit('Submit', ['class' => 'btn btn-success pull-right']); !!}
                  </div>
                </div>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane fade in" id="delete">
              <div class="col-md-12">
                <div class="panel panel-default">
                  <div class="panel-heading"> <!-- <i class="fa fa-bars"></i> School Classes -->
                    Enter School Info
                  </div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-xs-4">
                        {!! Form::label('name', 'School Name') !!} <span class="text text-danger">*</span>
                      </div>
                      <div class="col-xs-8">
                        {!! Form::text('name', null, ['class' => 'form-control typeahead', 'id' => 'deleteclassschoolname', 'autocomplete' => 'off', 'placeholder' => 'e.g. Lexington High School']) !!}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-4">
                        {!! Form::label('name', 'Class Name') !!} <span class="text text-danger">*</span>
                      </div>
                      <div class="col-xs-8">
                        {!! Form::text('name', null, ['class' => 'form-control typeahead', 'id' => 'deleteclassname', 'autocomplete' => 'off', 'placeholder' => 'e.g. Calculus']) !!}
                      </div>
                    </div>
                    <hr>
                    <span class="text text-danger">* = Required</span>
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger pull-right']); !!}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading"> <!-- <i class="fa fa-bars"></i> School Classes -->
            <div class="row">
              Edit Levels
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-xs-4">
                {!! Form::label('name', 'School Name') !!} <span class="text text-danger">*</span>
              </div>
              <div class="col-xs-8">
                {!! Form::text('name', null, ['class' => 'form-control typeahead', 'id' => 'schoolname', 'data-provide' => 'typeahead', 'autocomplete' => 'off', 'placeholder' => 'e.g. Lexington High School']) !!}
              </div>
            </div>
            <div class="row">
              <div class="col-xs-4">
                <div class="dropdown">
                  <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Subject
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                    <li><a href="#">English</a></li>
                    <li><a href="#">Social Studies</a></li>
                    <li><a href="#">Science</a></li>
                    <li><a href="#">Math</a></li>
                    <li><a href="#">Foreign Language</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#">Elementary/Middle School English</a></li>
                    <li><a href="#">Elementary/Middle School Social Studies</a></li>
                    <li><a href="#">Elementary/Middle School Science</a></li>
                    <li><a href="#">Elementary/Middle School Math</a></li>
                    <li><a href="#">Elementary/Middle School Foreign Language</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-md-4">
                <div class="dropdown">
                  <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Class
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu3">
                    <li><a href="#">Dystopias</a></li>
                    <li><a href="#">Economics</a></li>
                    <li><a href="#">Biology</a></li>
                    <li><a href="#">Chemistry</a></li>
                    <li><a href="#">Calculus</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Level Name" aria-describedby="basic-addon2">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="fa fa-plus"></i></button>
                  </span>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table id="add-classes" class="table table-striped table-bordered table-hover"></table>
            </div>
            <span class="text text-danger">* = Required</span>
            <button class="btn btn-success pull-right" type="button">
              Submit
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
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
  $('.typeahead').typeahead(null, //instantiate submit typeahead
    {
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
    var $add_classes = $('#add-classes');
    var placeholder_data = [['Level 2'], ['Level 1'], ['AP 1'], ['AP 2']];
    //add classes
    $add_classes.dataTable( {
      data: placeholder_data,
      "dom": 't',
      columns: [
        {title: "Level"},
        {title: "Level Degree", visible: false, data: null},
        {title: "Options", "width": "10%", orderable: false, data: null, createdCell: function (td, cellData, rowData, row, col) {
          $(td).html('<i class="fa fa-chevron-down"></i><i class="fa fa-chevron-up"></i><i class="fa fa-times"></i>');
        }
      }
    ]
  });
});
</script>
@stop
