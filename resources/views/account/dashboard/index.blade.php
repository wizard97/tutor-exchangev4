@extends('app')

@section('content')
<style>
@media (min-width: 992px) {
  .vertical-align {
    display: flex;
    align-items: center;
  }
}
</style>
<script>
$(document).ready(function(){
  jQuery('.readmore').readmore({collapsedHeight: 83});
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
})
</script>
<div class="container-fluid">
  @include('templates/feedback')
  <h1 class="page-header">Dashboard</h1>
  <div class="col-md-8">


        <div class="panel panel-default">
          <div class="panel-heading">
            <i class="fa fa-comments"></i> Tutoring Inquiries
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-striped site-datatable">
                <thead>
                  <tr>
                    <th>To</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  <tr role="row" class="odd">
                    <td class="vert-align sorting_1">Aaron Wisner</td>
                    <td class="vert-align">Frikkin Laravel</td>
                    <td class="vert-align">halp.</td>
                    <td class="vert-align">00/00/0000</td>
                  </tr>
                  <tr role="row" class="even">
                    <td class="vert-align sorting_1">Aaron Wisner</td>
                    <td class="vert-align">Frikkin Laravel</td>
                    <td class="vert-align">halp.</td>
                    <td class="vert-align">00/00/0000</td>
                  </tr>
                  <tr role="row" class="odd">
                    <td class="vert-align sorting_1">Aaron Wisner</td>
                    <td class="vert-align">Frikkin Laravel</td>
                    <td class="vert-align">halp.</td>
                    <td class="vert-align">00/00/0000</td>
                  </tr>
                  <tr role="row" class="even">
                    <td class="vert-align sorting_1">Aaron Wisner</td>
                    <td class="vert-align">Frikkin Laravel</td>
                    <td class="vert-align">halp.</td>
                    <td class="vert-align">00/00/0000</td>
                  </tr>
                  <tr role="row" class="odd">
                    <td class="vert-align sorting_1">Aaron Wisner</td>
                    <td class="vert-align">Frikkin Laravel</td>
                    <td class="vert-align">halp.</td>
                    <td class="vert-align">00/00/0000</td>
                  </tr>
                  <tr role="row" class="even">
                    <td class="vert-align sorting_1">Aaron Wisner</td>
                    <td class="vert-align">Frikkin Laravel</td>
                    <td class="vert-align">halp.</td>
                    <td class="vert-align">00/00/0000</td>
                  </tr>
                </tbody>
              </table>
            </div>

        </div>
      </div>


      <div class="panel panel-default">
        <div class="panel-heading">
          <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Saved Tutors
        </div>
        <div class="panel-body">
            <table class="table table-striped dataTable no-footer" id="resultsTable" role="grid" aria-describedby="resultsTable_info">

              <thead>
              <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="resultsTable" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending" style="width: 110px;" aria-sort="ascending">Name</th><th class="sorting" tabindex="0" aria-controls="resultsTable" rowspan="1" colspan="1" aria-label="Grade: activate to sort column ascending" style="width: 217px;">Grade</th><th class="sorting" tabindex="0" aria-controls="resultsTable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 69px;">Age</th><th class="sorting" tabindex="0" aria-controls="resultsTable" rowspan="1" colspan="1" aria-label="Hourly Rate: activate to sort column ascending" style="width: 155px;">Hourly Rate</th><th class="sorting" tabindex="0" aria-controls="resultsTable" rowspan="1" colspan="1" aria-label="Tutor Type: activate to sort column ascending" style="width: 177px;">Tutor Type</th><th class="sorting" tabindex="0" aria-controls="resultsTable" rowspan="1" colspan="1" aria-label="Tutor Reviews: activate to sort column ascending" style="width: 184px;">Tutor Reviews</th></tr>
              </thead>
              <tbody>
    <tr role="row" class="odd">
      <td class="vert-align sorting_1"><span style="color:blue">Aaron</span></td>
      <td class="vert-align">12th</td>
      <td class="vert-align">18</td>
      <td class="vert-align">$25</td>

      <td class="vert-align">Standard Tutor</td>
      <td class="vert-align">
          <span class="text-nowrap">
              <span style="font-size: 18px">
                  <i style="color: #FEC601" class="fa fa-star"></i><i style="color: #FEC601" class="fa fa-star"></i><i style="color: #FEC601" class="fa fa-star"></i><i style="color: #FEC601" class="fa fa-star"></i><i style="color: #FEC601" class="fa fa-star"></i>                                                </span> (<span class="text-primary">2</span>)</span>
          </td>

          </tr><tr role="row" class="even">
      <td class="vert-align sorting_1">Afareen</td>
      <td class="vert-align">11th</td>
      <td class="vert-align">0</td>
      <td class="vert-align">$15</td>

      <td class="vert-align">Standard Tutor</td>
      <td class="vert-align">
          <span class="text-nowrap">
              <span style="font-size: 18px">
                  <i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i>                                                </span> (<span class="text-primary">0</span>)</span>
          </td>

          </tr><tr role="row" class="odd">
      <td class="vert-align sorting_1">Ali</td>
      <td class="vert-align">High School Graduate</td>
      <td class="vert-align">19</td>
      <td class="vert-align">$25</td>

      <td class="vert-align">Standard Tutor</td>
      <td class="vert-align">
          <span class="text-nowrap">
              <span style="font-size: 18px">
                  <i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i>                                                </span> (<span class="text-primary">0</span>)</span>
          </td>

          </tr><tr class="success even" role="row">
      <td class="vert-align sorting_1">Amy</td>
      <td class="vert-align">College Graduate</td>
      <td class="vert-align">0</td>
      <td class="vert-align">$80</td>

      <td class="vert-align">Professional Tutor</td>
      <td class="vert-align">
          <span class="text-nowrap">
              <span style="font-size: 18px">
                  <i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i>                                                </span> (<span class="text-primary">0</span>)</span>
          </td>

          </tr><tr role="row" class="odd">
      <td class="vert-align sorting_1">Amy</td>
      <td class="vert-align">High School Graduate</td>
      <td class="vert-align">17</td>
      <td class="vert-align">$20</td>

      <td class="vert-align">Standard Tutor</td>
      <td class="vert-align">
          <span class="text-nowrap">
              <span style="font-size: 18px">
                  <i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i>                                                </span> (<span class="text-primary">0</span>)</span>
          </td>

          </tr><tr role="row" class="even">
      <td class="vert-align sorting_1">Amy</td>
      <td class="vert-align">12th</td>
      <td class="vert-align">18</td>
      <td class="vert-align">$20</td>

      <td class="vert-align">Standard Tutor</td>
      <td class="vert-align">
          <span class="text-nowrap">
              <span style="font-size: 18px">
                  <i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i>                                                </span> (<span class="text-primary">0</span>)</span>
          </td>

          </tr><tr role="row" class="odd">
      <td class="vert-align sorting_1">Armin</td>
      <td class="vert-align">11th</td>
      <td class="vert-align">16</td>
      <td class="vert-align">$20</td>

      <td class="vert-align">Standard Tutor</td>
      <td class="vert-align">
          <span class="text-nowrap">
              <span style="font-size: 18px">
                  <i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i>                                                </span> (<span class="text-primary">0</span>)</span>
          </td>

          </tr><tr role="row" class="even">
      <td class="vert-align sorting_1">Becca</td>
      <td class="vert-align">11th</td>
      <td class="vert-align">16</td>
      <td class="vert-align">$25</td>

      <td class="vert-align">Standard Tutor</td>
      <td class="vert-align">
          <span class="text-nowrap">
              <span style="font-size: 18px">
                  <i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i>                                                </span> (<span class="text-primary">0</span>)</span>
          </td>

          </tr><tr role="row" class="odd">
      <td class="vert-align sorting_1">Benjamin</td>
      <td class="vert-align">11th</td>
      <td class="vert-align">17</td>
      <td class="vert-align">$20</td>

      <td class="vert-align">Standard Tutor</td>
      <td class="vert-align">
          <span class="text-nowrap">
              <span style="font-size: 18px">
                  <i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i>                                                </span> (<span class="text-primary">0</span>)</span>
          </td>

          </tr><tr role="row" class="even">
      <td class="vert-align sorting_1">Caroline</td>
      <td class="vert-align">12th</td>
      <td class="vert-align">18</td>
      <td class="vert-align">$20</td>

      <td class="vert-align">Standard Tutor</td>
      <td class="vert-align">
          <span class="text-nowrap">
              <span style="font-size: 18px">
                  <i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i>                                                </span> (<span class="text-primary">0</span>)</span>
          </td>

          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Contacted Tutors
    </div>
    <div class="panel-body">
        <table class="table table-striped dataTable no-footer" id="resultsTable" role="grid" aria-describedby="resultsTable_info">

          <thead>
            <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="resultsTable" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending" style="width: 110px;" aria-sort="ascending">Name</th><th class="sorting" tabindex="0" aria-controls="resultsTable" rowspan="1" colspan="1" aria-label="Grade: activate to sort column ascending" style="width: 217px;">Grade</th><th class="sorting" tabindex="0" aria-controls="resultsTable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 69px;">Age</th><th class="sorting" tabindex="0" aria-controls="resultsTable" rowspan="1" colspan="1" aria-label="Hourly Rate: activate to sort column ascending" style="width: 155px;">Hourly Rate</th><th class="sorting" tabindex="0" aria-controls="resultsTable" rowspan="1" colspan="1" aria-label="Tutor Type: activate to sort column ascending" style="width: 177px;">Tutor Type</th><th class="sorting" tabindex="0" aria-controls="resultsTable" rowspan="1" colspan="1" aria-label="Tutor Reviews: activate to sort column ascending" style="width: 184px;">Tutor Reviews</th></tr>
          </thead>
          <tbody>
<tr role="row" class="odd">
  <td class="vert-align sorting_1"><span style="color:blue">Aaron</span></td>
  <td class="vert-align">12th</td>
  <td class="vert-align">18</td>
  <td class="vert-align">$25</td>

  <td class="vert-align">Standard Tutor</td>
  <td class="vert-align">
      <span class="text-nowrap">
          <span style="font-size: 18px">
              <i style="color: #FEC601" class="fa fa-star"></i><i style="color: #FEC601" class="fa fa-star"></i><i style="color: #FEC601" class="fa fa-star"></i><i style="color: #FEC601" class="fa fa-star"></i><i style="color: #FEC601" class="fa fa-star"></i>                                                </span> (<span class="text-primary">2</span>)</span>
      </td>

      </tr><tr role="row" class="even">
  <td class="vert-align sorting_1">Afareen</td>
  <td class="vert-align">11th</td>
  <td class="vert-align">0</td>
  <td class="vert-align">$15</td>

  <td class="vert-align">Standard Tutor</td>
  <td class="vert-align">
      <span class="text-nowrap">
          <span style="font-size: 18px">
              <i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i>                                                </span> (<span class="text-primary">0</span>)</span>
      </td>

      </tr><tr role="row" class="odd">
  <td class="vert-align sorting_1">Ali</td>
  <td class="vert-align">High School Graduate</td>
  <td class="vert-align">19</td>
  <td class="vert-align">$25</td>

  <td class="vert-align">Standard Tutor</td>
  <td class="vert-align">
      <span class="text-nowrap">
          <span style="font-size: 18px">
              <i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i>                                                </span> (<span class="text-primary">0</span>)</span>
      </td>

      </tr><tr class="success even" role="row">
  <td class="vert-align sorting_1">Amy</td>
  <td class="vert-align">College Graduate</td>
  <td class="vert-align">0</td>
  <td class="vert-align">$80</td>

  <td class="vert-align">Professional Tutor</td>
  <td class="vert-align">
      <span class="text-nowrap">
          <span style="font-size: 18px">
              <i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i>                                                </span> (<span class="text-primary">0</span>)</span>
      </td>

      </tr><tr role="row" class="odd">
  <td class="vert-align sorting_1">Amy</td>
  <td class="vert-align">High School Graduate</td>
  <td class="vert-align">17</td>
  <td class="vert-align">$20</td>

  <td class="vert-align">Standard Tutor</td>
  <td class="vert-align">
      <span class="text-nowrap">
          <span style="font-size: 18px">
              <i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i>                                                </span> (<span class="text-primary">0</span>)</span>
      </td>

      </tr><tr role="row" class="even">
  <td class="vert-align sorting_1">Amy</td>
  <td class="vert-align">12th</td>
  <td class="vert-align">18</td>
  <td class="vert-align">$20</td>

  <td class="vert-align">Standard Tutor</td>
  <td class="vert-align">
      <span class="text-nowrap">
          <span style="font-size: 18px">
              <i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i>                                                </span> (<span class="text-primary">0</span>)</span>
      </td>

      </tr><tr role="row" class="odd">
  <td class="vert-align sorting_1">Armin</td>
  <td class="vert-align">11th</td>
  <td class="vert-align">16</td>
  <td class="vert-align">$20</td>

  <td class="vert-align">Standard Tutor</td>
  <td class="vert-align">
      <span class="text-nowrap">
          <span style="font-size: 18px">
              <i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i>                                                </span> (<span class="text-primary">0</span>)</span>
      </td>

      </tr><tr role="row" class="even">
  <td class="vert-align sorting_1">Becca</td>
  <td class="vert-align">11th</td>
  <td class="vert-align">16</td>
  <td class="vert-align">$25</td>

  <td class="vert-align">Standard Tutor</td>
  <td class="vert-align">
      <span class="text-nowrap">
          <span style="font-size: 18px">
              <i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i>                                                </span> (<span class="text-primary">0</span>)</span>
      </td>

      </tr><tr role="row" class="odd">
  <td class="vert-align sorting_1">Benjamin</td>
  <td class="vert-align">11th</td>
  <td class="vert-align">17</td>
  <td class="vert-align">$20</td>

  <td class="vert-align">Standard Tutor</td>
  <td class="vert-align">
      <span class="text-nowrap">
          <span style="font-size: 18px">
              <i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i>                                                </span> (<span class="text-primary">0</span>)</span>
      </td>

      </tr><tr role="row" class="even">
  <td class="vert-align sorting_1">Caroline</td>
  <td class="vert-align">12th</td>
  <td class="vert-align">18</td>
  <td class="vert-align">$20</td>

  <td class="vert-align">Standard Tutor</td>
  <td class="vert-align">
      <span class="text-nowrap">
          <span style="font-size: 18px">
              <i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i><i style="color: #FEC601" class="fa fa-star-o"></i>                                                </span> (<span class="text-primary">0</span>)</span>
      </td>

      </tr>
    </tbody>
  </table>

</div>
</div>
  </div>
  <div class="col-md-4">
    <div class="well well">
      <h3>Welcome Matan,</h3>
      <p>This is your account dashboard, use it to help manage your account.</p>
    </div>
    <div class="panel panel-danger">
      <div class="panel-heading">
        <i class="fa fa-bell fa-fw"></i> Notifications
      </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
      </div>
      <!-- /.panel-body -->
    </div>
  </div>
</div>
<script>
$( document ).ready(function() {
  $('.contact-message').readmore({
    collapsedHeight: 100,
    moreLink: '<a href="#">Expand »</a>',
    lessLink: '<a href="#">Close</a>',
  });
});
</script>
@stop
