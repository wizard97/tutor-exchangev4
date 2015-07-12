<script>
$( document ).ready(function() {
  //clickable contact button
  $('#contactModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id = button.data('userid'); // Extract info from data-* attributes

    //dont delete it if already opened
    if (id != $('#contactModal #contact-userid').val())
    {
      $('#contactModal .clearout').val('');
      $('#contactModal h4').text('Loading...');

      $('#contactModal #contact-userid').val(id);
      $.ajax({
        type: "POST",
        url : "{{ route("search.ajaxcontacttutor") }}",
        data : {userid: id},
        success : function(data){
          $('#contactModal h4').html('<i class="fa fa-envelope-o"></i> Contact <a href="' + data.tutor_profile + '">' + data.name + '</a>');
          $('#contactModal #recipient-name').val(data.name);
          $("#contactModal #submit-btn").data("submiturl", data.post_url);
        }
      });
    }
  });

  //ajax submit message
  $('#contact-form').submit(function(event) {

    var formData = {
        'user_id': $('#contactModal #contact-userid').val(),
        'subject': $('input[name=message-subject]').val(),
        'message': $('#contactModal #message-text').val(),
    };

    // process the form
    $.ajax({
        type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
        url         : '{{ route('search.sendmessage') }}',
        data        : formData, // our data object
        //callback
        success : function(data){
          $('#feedback').html(data);
          $('#contactModal').modal('hide');
        },
        error: function(data)
        {
          //print validation errors
          validation_errors(data, '#error-messages');
        }
    });
    // stop the form from submitting the normal way and refreshing the page
    event.preventDefault();
});

});
</script>


<div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="Contact a Tutor">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="contact-form" action="">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Loading...</h4>
      </div>
      <div class="modal-body">
        <div id="error-messages"></div>
          <input type="hidden" value id="contact-userid" class="clearout">

          <div class="form-group">
            <label for="recipient-name" class="control-label">To</label>
            <input type="text" class="form-control clearout" id="recipient-name" disabled>
          </div>

          <div class="form-group">
            <label for="users-name" class="control-label">From</label>
            <input type="text" class="form-control disabled" id="users-name" value="{{ Auth::user()->fname.' '.Auth::user()->lname }}" disabled>
          </div>

          <div class="form-group">
            <label for="users-name" class="control-label">Reply To</label>
            <input type="text" class="form-control disabled" id="users-name" value="{{ Auth::user()->email  }}" disabled>
          </div>

          <div class="form-group">
            <label for="message-subject" class="control-label">Subject</label>
            <input type="text" class="form-control clearout" id="message-subject" name="message-subject">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">Your Message</label>
            <textarea class="form-control clearout" name="message-text" id="message-text" rows="7"></textarea>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-fw"></i> Close</button>
        <button type="submit" class="btn btn-success" id="submit-btn"><i class="fa fa-paper-plane fa-fw"></i> Send</button>
      </div>
    </form>
    </div>
  </div>
</div>
