@extends('app')

@section('content')
<style>
#editor {overflow:scroll; max-height:300px}
</style>

<div class="container">

  <h2 class="page-header">[Bob Smith] Are you free this saturday?</h2>
  @include('templates/feedback')

  <button class="btn btn-default">Message Inbox</button>
  <hr>

  <div class="row">
    <div class="col-xs-12">
      <div class="panel panel-info">
        <div class="panel-heading">
          <h5>Reply to Bob</h5>
        </div>
        <div class="panel-body">

          <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
				<div class="btn-group">
					<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a data-edit="fontSize 5" class="fs-Five">Huge</a></li>
						<li><a data-edit="fontSize 3" class="fs-Three">Normal</a></li>
						<li><a data-edit="fontSize 1" class="fs-One">Small</a></li>
					</ul>
				</div>
				<div class="btn-group">
					<a class="btn btn-default" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
					<a class="btn btn-default" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
					<a class="btn btn-default" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
					<a class="btn btn-default" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
				</div>
				<div class="btn-group">
					<a class="btn btn-default" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
					<a class="btn btn-default" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
					<a class="btn btn-default" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-outdent"></i></a>
					<a class="btn btn-default" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
				</div>
				<div class="btn-group">
					<a class="btn btn-default" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
					<a class="btn btn-default" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
					<a class="btn btn-default" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
					<a class="btn btn-default" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
				</div>
				<div class="btn-group">
					<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
					<div class="dropdown-menu input-append">
						<input placeholder="URL" type="text" data-edit="createLink" />
						<button class="btn" type="button">Add</button>
					</div>
				</div>
				<div class="btn-group">
					<a class="btn btn-default" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-unlink"></i></a>
					<span class="btn btn-default" title="Insert picture (or just drag & drop)" id="pictureBtn"> <i class="fa fa-picture-o"></i>
						<input class="imgUpload" type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
					</span>
				</div>
				<div class="btn-group">
					<a class="btn btn-default" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
					<a class="btn btn-default" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
					<a class="btn btn-default" data-edit="html" title="Clear Formatting"><i class='glyphicon glyphicon-pencil'></i></a>
				</div>
			</div>
			<div id="editorPreview"></div>

			<form action="php/upload.php" method="post" enctype="multipart/form-data" id='submitForm'>
					<div id="editor" class="lead" data-placeholder="Your message goes here."></div>
					<a class="btn btn-large btn-default jumbo" href="#!" onClick="$('#mySubmission').val($('#editor').cleanHtml(true));$('#submitForm').submit();">Submit</a>
				<input type='hidden' name='formSubmission' id='mySubmission'/>
			</form>

        </div>
      </div>
    </div>
  </div>

  <hr>

  <div class="row">
    <div class="col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          Bob <small class="pull-right"> 2 hours ago</small>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-xs-2 col-md-1">
              <img src="/img/default_thumb.jpg" class="img-rounded" width="50" height="50">
            </div>
            <div class="col-xs-10 col-md-10">
              I am very boring
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <div class="panel panel-info">
        <div class="panel-heading">
          <img src="/img/Aaron.jpg" class="img-rounded" width="50" height="50">
        </div>
        <div class="panel-body">
          Panel content
        </div>
      </div>
    </div>
  </div>

</div>

<script type='text/javascript'>
$(function () {
  $('#editor').wysiwyg(
  {
    'form':
    {
      'text-field': 'mySubmission',
      'seperate-binary': false
    }
  });

  $(".dropdown-menu > input").click(function (e) {
        e.stopPropagation();
    });
    $('a[title]').tooltip({container:'body'});
});

</script>
  @stop
