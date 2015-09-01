
<div class="panel panel-primary">
  <div class="panel-heading">Your selections</div>
  <div class="panel-body">
    <table id="selected-classes"></table>
  </div>
</div>

<div id="toolbar">
  <div class="dropdown">
    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
      Subjects
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" id="subjects_dropdown" aria-labelledby="dropdownMenu1">
    </ul>
  </div>
</div>
        <table id="search-classes"></table>




//bootstrap tables
$( document ).ready(function() {
  var $s_table = $('#selected-classes');
  $s_table.bootstrapTable(
    {
      idField: 'id',
      uniqueId: 'id',
      sortName: 'class_name',
      sortOrder: 'asc',
      pagination: true,
      classes: 'table table-no-bordered',
      pageSize: 25,

      columns: [{
          field: 'id',
          title: 'Class ID',
        }, {
          field: 'id',
          title: 'class_id',
          visible: false,
        }, {
          field: 'class_name',
          title: 'Class Name',
          sortable: true,
        }, {
          field: 'class_type',
          title: 'Subject',
          sortable: true,
        }, {
          field: 'level',
          title: 'Level',
          sortable: true,
        }, {
          field: 'actions',
          title: 'Actions',
      }],

      data: {},
    });

  var $table = $('#search-classes');
  $table.bootstrapTable(
    {
      clickToSelect: true,
      checkbox: true,
      striped: false,
      search: true,
      idField: 'id',
      uniqueId: 'id',
      sortName: 'class_name',
      sortOrder: 'asc',
      pagination: true,
      pageSize: 25,
      toolbar: '#toolbar',

      columns: [{
          field: 'checkbox',
          checkbox: true,
        },{
          field: 'id',
          title: 'Class ID',
          visible: false,
        }, {
          field: 'class_name',
          title: 'Class Name',
          sortable: true,
        }, {
          field: 'class_type',
          title: 'Subject',
          sortable: true,
        }, {
          field: 'level',
          title: 'Level',
          align: 'center',
          clickToSelect: false,
          events: levelEvents,
          formatter: levelFormatter,
      }],

      data: classes,
    });

  $button = $('#button');
  $(function () {
      $button.click(function () {
          alert('getSelections: ' + JSON.stringify($table.bootstrapTable('getSelections')));
      });
  });

  //array of array of classes keyed by subject
  var class_subjects = {};

  $.each(classes, function(idx, val) {
    if (typeof class_subjects[val.class_type] == 'undefined') {
    class_subjects[val.class_type] = new Array();
    }
    class_subjects[val.class_type].push(val.id);
  });

  var $dropdown = $('#subjects_dropdown');
  //create all dropdown
  ($('<li><a id="all-subjects" href="#">All Subjects <span class="badge alert-success">' + classes.length + '</span></a></li>').appendTo($dropdown)).on( "click", function() {
    $table.bootstrapTable('getRowsHidden', true);
    //$table.bootstrapTable('uncheckAll');
    $table.bootstrapTable('showColumn', 'class_type');
    $('#subjects_dropdown > li').removeClass('active');
    $table.bootstrapTable('filterBy', null);
    $(this).addClass('active');
  });
  $("#subjects_dropdown li:first-child").addClass('active');
  $dropdown.append('<li role="separator" class="divider"></li>');
  //create other subjects
  $.each(class_subjects, function(idx, val) {
    ($('<li><a class="class-subject" href="#">' + idx + ' <span class="badge">' + val.length + '</span></a></li>').appendTo($dropdown)).on( "click", function() {
      $table.bootstrapTable('getRowsHidden', true);
      //$table.bootstrapTable('uncheckAll');
      $table.bootstrapTable('hideColumn', 'class_type');
      $table.bootstrapTable('filterBy', {class_type: idx});
      $('#subjects_dropdown > li').removeClass('active');
      $(this).addClass('active');
    });
  });


});

function levelFormatter(value, row, index) {
  var sel = $('<select class="form-control"></select>').attr("id", 'class-' + row.id).attr("name", name);

  $(levels[row.id]).each(function() {
    sel.append($("<option>").attr('value',this.level_num).text(this.level_name));
  });

  return sel.wrap('<div class="form-group"></div>').prop('outerHTML');
}

window.levelEvents = {
    'click .like': function (e, value, row, index) {
        alert('You click like action, row: ' + JSON.stringify(row));
    },
    'click .remove': function (e, value, row, index) {
        $table.bootstrapTable('remove', {
            field: 'id',
            values: [row.id]
        });
    }
};
