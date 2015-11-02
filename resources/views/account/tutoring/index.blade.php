@extends('app')

@section('content')
<style>
.table-text-center {
  text-align: center;
}
.table > tbody > tr > td {
  vertical-align: middle;
}

</style>
<div class="container-fluid">
  <div class="row">
    @include('/account/tutoring/sidebar')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

      <h1 class="page-header">My Tutoring</h1>
      @include('templates/feedback')

      <div class="row">
        <div class="col-lg-7">

          <div class="row">
            <div class="col-md-7">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <i class="fa fa-list fa-fw"></i> Tutoring Checklist
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                  <div class="list-group">
                    <a href="{{ route('tutoring.info') }}" class="list-group-item">
                      <i class="fa fa-info fa-fw"></i> Your Info
                      <span class="pull-right">
                        @if($checklist['info']) <i class="fa fa-check" style="color:green; font-size:20px" data-toggle="tooltip" data-placement="right" title="Complete!"></i>
                        @else <i class="fa fa-exclamation-triangle" style="color:orange; font-size:20px" data-toggle="tooltip" data-placement="right" title="Incomplete!"></i>
                        @endif
                      </span>
                    </a>
                    <a href="{{ route('tutoring.classes') }}" class="list-group-item">
                      <i class="fa fa-graduation-cap fa-fw"></i> Your Classes
                      <span class="pull-right">
                        @if($checklist['classes']) <i class="fa fa-check" style="color:green; font-size:20px" data-toggle="tooltip" data-placement="right" title="Complete!"></i>
                        @else <i class="fa fa-exclamation-triangle" style="color:orange; font-size:20px" data-toggle="tooltip" data-placement="right" title="Incomplete!"></i>
                        @endif
                      </span>
                    </a>
                    <a href="{{ route('tutoring.music') }}" class="list-group-item">
                      <i class="fa fa-music fa-fw"></i> Your Music
                      <span class="pull-right">
                        @if($checklist['music']) <i class="fa fa-check" style="color:green; font-size:20px" data-toggle="tooltip" data-placement="right" title="Complete!"></i>
                        @else <i class="fa fa-exclamation-triangle" style="color:orange; font-size:20px" data-toggle="tooltip" data-placement="right" title="Incomplete!"></i>
                        @endif
                      </span>
                    </a>
                    <a href="{{ route('tutoring.schedule') }}" class="list-group-item">
                      <i class="fa fa-calendar fa-fw"></i> Your Schedule
                      <span class="pull-right">
                        @if($checklist['schedule']) <i class="fa fa-check" style="color:green; font-size:20px" data-toggle="tooltip" data-placement="right" title="Complete!"></i>
                        @else <i class="fa fa-exclamation-triangle" style="color:orange; font-size:20px" data-toggle="tooltip" data-placement="right" title="Incomplete!"></i>
                        @endif
                      </span>
                    </a>

                    <a href="#" class="list-group-item list-group-item-info">
                      <i class="fa fa-bolt fa-fw"></i> Listing Active
                      <span class="pull-right">
                        @if($checklist['active']) <i class="fa fa-check" style="color:green; font-size:20px" data-toggle="tooltip" data-placement="right" title="Yes!"></i>
                        @else <i class="fa fa-exclamation-triangle" style="color:orange; font-size:20px" data-toggle="tooltip" data-placement="right" title="No!"></i>
                        @endif
                      </span>
                    </a>

                  </div>

                  <!-- /.list-group -->
                  @if(!$tutor->tutor_active)
                  <a href="{{ route('tutoring.runlisting')}}" class="btn btn-success btn-block"><i class="fa fa-play"></i> Renew Tutoring</a>
                  @else
                  <a href="{{ route('tutoring.pauselisting')}}" class="btn btn-warning btn-block"><i class="fa fa-pause"></i> Pause Tutoring</a>
                  @endif
                </div>
                <!-- /.panel-body -->
              </div>
            </div>

            <div class="col-md-5">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <i class="fa fa-camera fa-fw"></i> Profile Picture
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                  <img src="{{ route('profileimage.showfull', ['id' => Auth::user()->id]) }}" class="img-responsive img-rounded" alt="Profle Picture">
                  <br>
                  <button class="btn btn-info btn-block" data-toggle="modal" data-target="#image"><i class="fa fa-upload"></i> Upload Picutre</button>
                  @if(Auth::user()->has_picture)<a href="{{ route('profileimage.destroy') }}" class="btn btn-danger btn-block"><i class="fa fa-trash"></i> Delete Picture</a>@endif
                </div>
                <!-- /.panel-body -->
              </div>
            </div>
          </div>


          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-line-chart fa-fw"></i> Your Popularity
            </div>

            <div class="panel-body">
              <h3 style="text-align: center; margin-bottom: 0px;">Total Tutoring Inquiries</h3>
              <div id="myfirstchart"></div>

            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-comments fa-fw"></i> Tutoring Inquiries
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-striped site-datatable">
                  <thead>
                    <tr>
                      <th>From</th>
                      <th>Subject</th>
                      <th>Message</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($contacts as $contact)
                    <tr>
                      <td>{{ $contact->fname.' '.$contact->lname }}</td>
                      <td><div class="contact-subject">{{ $contact->subject }}</div></td>
                      <td> <div class="contact-message">{!! nl2br($contact->message) !!}</div></td>
                      <td>{{ date ("m/d/Y", strtotime($contact->created_at)) }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

            </div>
          </div>

        </div>

        <div class="col-lg-5">
          <div class="well well">
            <h3>Welcome {{ Auth::user()->fname }},</h3>
            <p>This is your tutoring dashboard. Use it to help manage your tutoring.</p>
          </div>

          <div class="panel panel-danger">
            <div class="panel-heading">
              <i class="fa fa-bell fa-fw"></i> Notifications
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
              @if($tutor->tutor_active && strtotime($tutor->profile_expiration) > time())
              <p class="alert alert-success"><i class="fa fa-info-circle"></i> Your listing is currently active!</p>
              @else
              <p class="alert alert-danger"><i class="fa fa-info-circle"></i> Your listing is not currently active!</p>
              @endif
              @if(strtotime($tutor->profile_expiration) < strtotime('1 week') && $tutor->tutor_active)
              <p class="alert alert-warning"><i class="fa fa-info-circle"></i> Your listing expires in less than a week!</p>
              @endif
              <p class="text bg-warning"><span class="text text-danger">Attention:</br></span>We now have an updated <a href="/LextutorexchangePrivacyPolicy.pdf" target="_blank">Privacy Policy</a> and <a href="/LextutorexchangeTermsofUse.pdf" target="_blank">Terms of Use</a>. We advise that you read these documents, as your use of this website constitutes your agreement to these terms. Thank you, </br>The Creators</p>
            </div>
            <!-- /.panel-body -->
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-user fa-fw"></i> Tutoring Stats
            </div>
            <div class="panel-body">
              <br>
              <ul class="list-group">
                <?php $expiration = new DateTime($tutor->profile_expiration); $now = new DateTime(date("Y-m-d H:i:s")); $interval = $expiration->diff($now); ?>
                <li class="list-group-item"><i class="fa fa-clock-o fa-fw"></i> Listing Expiration:<span class="pull-right text-muted">{{ $interval->days }} days ( @if(!empty($tutor->profile_expiration)){{ date('m/d/Y', strtotime($tutor->profile_expiration)) }}@else N/A @endif)</span></li>
                <li class="list-group-item"><i class="fa fa-eye fa-fw"></i> Profile Views:<span class="pull-right text-muted">{{ $tutor->profile_views }} view(s)</span></li>
                <li class="list-group-item"><i class="fa fa-envelope fa-fw"></i> Contacted:<span class="pull-right text-muted">{{ $contacts->count() }} time(s)</span></li>
              </ul>
            </div>
          </div>


          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-university fa-fw"></i> Your Schools
            </div>
            <div class="panel-body">

              <div class="row col-md-12">
                <form class="form-horizontal" method="POST" action="{{route('tutoring.addschool')}}">
                  {!! csrf_field() !!}
                  <div class="form-group">
                    <label for="school-search" class="col-sm-3 control-label">Add a School</label>
                    <div class="col-sm-9 input-group">
                      <!-- <span class="input-group-addon"><i class="fa fa-university fa-fw"></i></span> -->
                      <input type="search" id="school-search" class="typeahead form-control" name="school_name" placeholder="Add a school...">
                      <span class="input-group-btn">
                        <button class="btn btn-success" type="submit">Add!</button>
                      </span>
                    </div>

                  </div>

                </form>
              </div>

              <div class="row">
                <div class="table-responsive col-md-12">
                  <table id="tutor_schools" class="table table-striped table-bordered table-hover"></table>
                </div>
              </div>

            </div>
          </div>

        </div>


      </div>


    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        {!! Form::open(['url' => route('profileimage.store'), 'files' => true]) !!}
        {!! csrf_field() !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Upload Profile Picture</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Image</label>
            {!! Form::file('image') !!}
            <p class="help-block">Only registered users will be able to view your profile image.</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle fa-fw"></i> Cancel</button>
          <button type="submit" class="btn btn-success"><i class="fa fa-upload fa-fw"></i> Upload</button>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>

</div>

<script>
var rm_school_url = "{{route('tutoring.removeschool')}}";
$( document ).ready(function() {

  // initialize the bloodhound suggestion engine
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
          '<strong>Sorry, we could not find that school.</strong>',
          '</p>'
        ].join('\n'),
        suggestion: function(data) {
          return '<p><strong>' + data.school_name + ',</strong> <small>' + data.city + ', '+ data.state_prefix + ' '+ data.zip_code + '</small></p>';
        }

      }
    });


  $('.contact-message').readmore({
    collapsedHeight: 41,
    moreLink: '<a href="#">Read More</a>',
    lessLink: '<a href="#">Read Less</a>',
  });
  $('.contact-subject').readmore({
    collapsedHeight: 41,
    moreLink: '<a href="#">Read More</a>',
    lessLink: '<a href="#">Read Less</a>',
  });

  //tutor schools
  var $tutor_schools = $('#tutor_schools');
  var getTutorSchools = "{{route('tutoring.ajaxgetschools')}}";

  $tutor_schools.DataTable({
    dom: 't',
    searching: false,
    paging: false,
    ajax: getTutorSchools,
    columns:
    [
      {
        "title": 'School ID', "data": "id", "orderable": false, "visible": false,
      },
      {
        "title": 'School Name', "data": "school_name"
      },
      {
        "title": 'Added On', "data": "pivot.created_at", createdCell: function (td, cellData, rowData, row, col) {
          var date = new Date(rowData.pivot.created_at);
          $(td).text(date.toLocaleDateString());
        }
      },
      {
        "title": "Options",
        "orderable": false,
        "className": 'table-text-center',
        "data": null,
        "defaultContent": '<button class="btn btn-warning rm-school"><i class="fa fa-times text-danger fa-fw"></i> Remove</button>'
      },
    ]
  });

  $tutor_schools.on('click', '.rm-school', function ()
  {
    //add spinner
    $btn = $(this);
    $spin = $('<i class="fa fa-spinner fa-spin"></i>');
    $btn.prepend($spin);

    var $clicked_row = $(this).closest('tr');
    var data = $tutor_schools.DataTable().row($clicked_row).data();
    //submit ajax request to delete row
    var post = new Object();
    post.school_id = data.id;
    console.log(post);
    $.ajax({
      type: "POST",
      data: post,
      url: rm_school_url,
      success: function (data){
        //remove row
        $tutor_schools.DataTable().row($clicked_row).remove().draw();
      },
      complete: function()
      {
        //render feedback
        $btn.find($spin).remove();
        lte.feedback();
      }

    });
  });
});


$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});

new Morris.Line({
  yLabelFormat: function(y){return y != Math.round(y)?'':y;},
  // ID of the element in which to draw the chart.
  element: 'myfirstchart',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: {!! json_encode($contacts_array) !!},
  dateFormat: function (x) {
    return new Date(x).toLocaleString();
  },

  // The name of the data record attribute that contains x-values.
  xkey: 'date',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['total_contacts'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Total Tutoring Inquiries'],


  resize: true,
  parseTime: true,
  hideHover: true
});

$('#contacts').on('click', function () {
  var $clicked_row = $(this).closest('tr');
  var $icon = $clicked_row.find("i.fa");
  var data = $contacts.DataTable().row($clicked_row).data();
});
</script>
@stop
