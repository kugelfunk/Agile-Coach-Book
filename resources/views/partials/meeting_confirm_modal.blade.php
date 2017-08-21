<style type="text/css">
    .select2-container--default .select2-selection--multiple {
        border-color: #CCCCCC;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #3898EC;
    }
</style>
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
                        <option value="{{$user->id}}"
                                @if(Auth::user()->id == $user->id) selected @endif>{{$user->name}}</option>
                    @endforeach
                </select>
                <label for="tags">Tags</label>
                <select name="tags[]" id="tags" class="w-select w-input" multiple="multiple">
                    @foreach($tags as $tag)
                        <option value="{{$tag->id}}">{{$tag->name}}</option>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
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
      };

      $(document).ready(function () {

        $('#modal-date').datetimepicker({
          format: 'd.m.Y',
          minDate: new Date(Date.now()).toLocaleString(),
          timepicker: false,
          dayOfWeekStart: 1
        });

        $('.modal-cancel').click(function () {
          closeTaskModal();
        });

        $('#task-confirm-form').submit(function (event) {
          event.preventDefault();
          var task = {
            title: $('#task-confirm-form #modal-title').val(),
            duedate: $('#task-confirm-form #modal-date').val(),
            user_id: $('#task-confirm-form #modal-coach_id').val(),
            meeting_id: $('#task-confirm-form #meeting_id').val(),
            tags: $('#task-confirm-form #tags').val(),
            _token: $('#task-confirm-form').find('input[name="_token"]').val()
          };
          $.ajax({
            url: '/api/tasks',
            type: "POST",
            data: task,
            cache: false,
            success: function (msg) // Success
            {
              closeTaskModal();
//              $form.append("<div id='form-alert'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>"+$form.attr('success-msg')+"</strong></div></div>");
            },
            error: function (msg) // Fail
            {
              alert("ERROR: " + msg.responseJSON.error);
//              $form.append("<div id='form-alert'><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>"+$form.attr('fail-msg')+"</strong></div></div>");
            },
            complete: function () // Clear
            {
            }
          });
        });

        $('.CodeMirror').keydown(function (e) {
          if (e.metaKey && e.keyCode === 57) {
            var title = simplemde.codemirror.getSelection();
            openTaskModal(title);
          }
        });

        // Tags Editor
        $('#tags').select2({
          tags: true,
          placeholder: "Select tag or add new one...",
          width: "100%"
        });
      });
    </script>
@endsection
