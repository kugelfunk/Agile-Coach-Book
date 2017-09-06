@extends('layout')

@section('styles')
    <link rel="stylesheet" href="/css/jquery.datetimepicker.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <style type="text/css">
        .editor-toolbar {
            color: #000;
            text-shadow: none;
            background-color: white;
        }

        #notes {
            text-shadow: none;
        }

    </style>
@endsection

@section('content')
    <div class="container">
        <div class="w-form">
            @include('partials.errors')
            <form action="/api/tasks" id="task-confirm-form" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <h3>Create Task</h3>
                <label for="title">Title:</label>
                <input class="w-input" id="title" maxlength="256" name="title" placeholder="Enter the title">
                <label for="duedate">Due Date:</label>
                <input class="w-input" id="duedate" maxlength="40" name="duedate" placeholder="Enter the date">
                <label for="user_id">Coach</label>
                <select class="w-select" name="user_id" id="user_id">
                    @foreach($users as $user)
                        <option value="{{$user->id}}"
                                @if(Auth::user()->id == $user->id) selected @endif>{{$user->name}}</option>
                    @endforeach
                </select>
                <label for="tags">Tags</label>
                <select name="tags[]" id="tags" class="w-select" multiple="multiple">
                    @foreach($tags as $tag)
                        <option value="{{$tag->id}}">{{$tag->name}}</option>
                    @endforeach
                </select>
                <label for="notes">Notes</label>
                <textarea name="notes" id="notes" class="w-input"></textarea>
                <label for="attachments">Attachments</label>
                <div class="attachments">
                    Hello
                </div>
                <div class="file-upload" id="dropzone">
                    <span class="file-upload-caption">Add Attachment</span>
                    <div id="img-list"></div>
                </div>
                <input type="file" id="file-btn" name="files[]" multiple/>
                <input type="submit" class="submit-button w-button" value="Submit"/>
                <a href="{{url()->previous()}}" class="modal-cancel" style="margin-left: 10px;">Cancel</a>
            </form>
        </div>
    </div>
@endsection

@section('body_javascripts')
    <script src="/js/jquery.datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script type="text/javascript">
      var simplemde;
      $(document).ready(function () {

        // DateTimePicker
        $('#duedate').datetimepicker({
          format: 'd.m.Y',
          minDate: new Date(Date.now()).toLocaleString(),
          timepicker: false,
          dayOfWeekStart: 1
        });

        // Text Editor
        simplemde = new SimpleMDE({
          spellChecker: false,
          status: false,
          toolbar: [
            "bold",
            "heading",
            "ordered-list",
            "unordered-list",
            "table",
            "link",
            "preview"
          ],
          shortcuts: {
            "toggleUnorderedList": "Cmd-Alt-K", // alter the shortcut for toggleOrderedList
            "drawHorizontalRule": "Cmd-Alt-G"
          }
        });

        // Tags Editor
        $('#tags').select2({
          tags: true,
          placeholder: "Select tag or add new one..."
        });
      });
    </script>
    <script type="text/javascript">

        var uploadFiles = [];

        var MAX_FILE_SIZE = 1000;

      $(document).ready(function () {
        $('#task-confirm-form').submit(function (evt) {
          evt.preventDefault();
          var fd = new FormData($('#task-confirm-form')[0]);
          var formData = new FormData($("#task-confirm-form")[0]);
          var fileField = document.getElementById('file-btn').files;
          for(var i = 0; i < uploadFiles.length; i++) {
            formData.append('files[]', uploadFiles[i]);
          }

          $.ajax({
            url: '/api/tasks',
            data: formData,
            dataType: 'json',
            type: 'post',
            contentType: false,
            processData: false,
            success: function (data) {
              console.log("Success response: " + data.response);
              window.location.href = "/tasks";
            },
            error: function(data) {
              console.log("ERROR Response: " + data.response);
            }
          });
        });
      });

      function handleDragOver(evt) {
        evt.stopPropagation();
        evt.preventDefault();
        evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
        $('#dropzone').css('backgroundColor', 'red');
      }

      function handleDragOut(evt) {
        console.log("DRAGOUT: ");
        $('#dropzone').css('backgroundColor', 'transparent');
      }

      function handleFileDrop(evt) {
        evt.stopPropagation();
        evt.preventDefault();
        $('#dropzone').css('backgroundColor', 'transparent');
        var files = evt.dataTransfer.files; // FileList object.

        for (var i = 0, f; f = files[i]; i++) {
          uploadFiles.push(f);
          var filesize = Math.round(f.size / 1024);
          if(filesize > MAX_FILE_SIZE) {
            alert("Filesize of " + f.name + " is " + filesize + ". That is too big. Max 100 kB please");
            continue;
          }
          if (f.type.match('image.*')) {

            var reader = new FileReader();

            reader.onload = (function (theFile) {
              return function (evt) {
                console.log("IN ONLOAD return: ");
                imgContainer = $('<div class="file-box"><img class="file-thumb" src="' + evt.target.result + '"><span class="thumb-caption" style="">' + Math.round(theFile.size/1024) + '</span></div>');
                console.log("IMG CONTAINER: " + imgContainer);
                $('#img-list').append(imgContainer);
              }
            })(f);

            reader.readAsDataURL(f);
          } else {
            imgContainer = $('<div class="file-box" style="position: relative; text-align: center"><img class="file-thumb" style="width: 30%" src="/images/file_icon.svg"><span class="thumb-caption" style="">' + f.name + '</span></div>');
            $('#img-list').append(imgContainer);
          }

        }
      }

      function handleFileSelect(evt) {
        var files = evt.target.files;

        var imgContainer;
        $('#img-list').empty();
        uploadFiles.length = 0;
        for (var i = 0, f; f = files[i]; i++) {
          var filesize = Math.round(f.size / 1024);
          if(filesize > MAX_FILE_SIZE) {
            alert("Filesize of " + f.name + " is " + filesize + ". That is too big. Max 100 kB please");
            continue;
          }
          if (f.type.match('image.*')) {

            var reader = new FileReader();

            reader.onload = (function (theFile) {
              return function (evt) {
                console.log("IN ONLOAD return: ");
                imgContainer = $('<div class="file-box"><img class="file-thumb" src="' + evt.target.result + '"><span class="thumb-caption" style="">' + theFile.name + '</span></div>');
                console.log("IMG CONTAINER: " + imgContainer);
                $('#img-list').append(imgContainer);
              }
            })(f);

            reader.readAsDataURL(f);
          } else {
            imgContainer = $('<div class="file-box" style="position: relative; text-align: center"><img class="file-thumb" style="width: 30%" src="/images/file_icon.svg"><span class="thumb-caption" style="">' + f.name + '</span></div>');
            $('#img-list').append(imgContainer);
          }

        }
      }

      var dropZone = document.getElementById('dropzone');
      dropZone.addEventListener('dragover', handleDragOver, false);
      dropZone.addEventListener('dragleave', handleDragOut, false);
      dropZone.addEventListener('drop', handleFileDrop, false);
      document.getElementById('file-btn').addEventListener('change', handleFileSelect, false);

      $('body').on('click', '#dropzone', function (evt) {
        $('#file-btn').trigger('click');
        evt.preventDefault();
      });

    </script>

@endsection