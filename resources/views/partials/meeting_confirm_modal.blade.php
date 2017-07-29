<div id="confirm-modal">
    <div class="container">
        <div class="w-form">
            <form action="#" id="task-confirm-form">
                {{csrf_field()}}
                <h3>Create Task</h3>
                <input type="hidden" id="meeting_id" value="{{$meeting->id}}"/>
                <label for="modal-title">Title:</label>
                <input class="w-input" id="modal-title" maxlength="256" name="modal-title"
                       placeholder="Enter the title" style="color: black;">
                <label for="modal-date">Due Date:</label>
                <input class="w-input" id="modal-date" maxlength="256" name="modal-date"
                       placeholder="Enter the date" style="color: black;">
                <label for="modal-coach_id">Coach</label>
                <select class="w-select" name="modal-coach_id" id="modal-coach_id">
                    @foreach($users as $user)
                    <option value="{{$user->id}}" @if(Auth::user()->id == $user->id) selected @endif>{{$user->name}}</option>
                    @endforeach
                </select>
                <input type="submit" class="submit-button w-button" value="Submit"/>
                <a href="#" class="modal-cancel" style="margin-left: 10px;">Cancel</a>
            </form>
        </div>
    </div>
</div>

@section('body_javascripts')
    @parent
    <script type="text/javascript">
      var openTaskModal = function (title) {
        console.log("öffne task modal... ");
        $('#confirm-modal').css('display', "flex");
        $('#modal-title').val(title).focus();
        $(document).bind('keyup', function (e) {
          if (e.keyCode === 27) { // escape key maps to keycode `27`
            closeTaskModal();
          }
        });
      };

      var closeTaskModal = function () {
        $(document).unbind('keyup');
        $('#confirm-modal').css('display', "none");
        $('#task-confirm-form #modal-title').val('');
        $('#task-confirm-form #modal-date').val('');
//        $('#task-confirm-form #modal-coach_id').val('')
      };

      $(document).ready(function () {

        $('#modal-date').datetimepicker({
          format: 'd.m.Y',
          minDate: new Date(Date.now()).toLocaleString(),
          timepicker: false,
//          maxTime: '21:00',
          dayOfWeekStart: 1
        });

        $('.modal-cancel').click(function () {
          closeTaskModal();
        });

        $('#task-confirm-form').submit(function (event) {
          event.preventDefault();
          console.log("SUBMITTEED: ");
          var task = {
            title: $('#task-confirm-form #modal-title').val(),
            duedate: $('#task-confirm-form #modal-date').val(),
            user_id: $('#task-confirm-form #modal-coach_id').val(),
            meeting_id: $('#task-confirm-form #meeting_id').val(),
            _token: $('#task-confirm-form').find('input[name="_token"]').val()
          };
          console.log("Titel: " + JSON.stringify(task));
          $.ajax({
            url: '/api/tasks',
            type: "POST",
            data: task,
            cache: false,
            success: function(msg) // Success
            {
              closeTaskModal();
//              $form.append("<div id='form-alert'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>"+$form.attr('success-msg')+"</strong></div></div>");
            },
            error: function(msg) // Fail
            {
              alert("ERROR: " + msg.responseJSON.error);
//              $form.append("<div id='form-alert'><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>"+$form.attr('fail-msg')+"</strong></div></div>");
            },
            complete: function() // Clear
            {
//              $form.trigger("reset");
            }
          });
        });

        $('.CodeMirror').keydown(function (e) {
          if (e.metaKey && e.keyCode === 57) {
            var title = simplemde.codemirror.getSelection();
            openTaskModal(title);
          }
        });
      });
    </script>
@endsection