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

        #file-btn {
            display: none;
        }

        .CodeMirror-wrap {
            margin-bottom: 10px;
        }

        .attachments {
            width: 100%;
            min-height: 38px;
            background-color: white;
            display: none;
            margin-bottom: 10px;
        }

        .file-upload {
            min-height: 38px;
            width: 100%;
            margin: 0 auto 10px auto;
            box-sizing: border-box;
            border: dashed thick #ddd;
            border-radius: 14px;
            text-align: center;
            padding: 5px;
            cursor: pointer;
        }

        .file-upload .file-upload-caption {
            color: #ddd;
            text-shadow: none;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="w-form">
            @include('partials.errors')
            <form action="/tasks" id="task-confirm-form" method="post">
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
                </div>
                <input type="file" id="file-btn"/>
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

      $(document).ready(function () {
        $('#task-confirm-form').submit(function (evt) {
          evt.preventDefault();
          console.log("form abgesendet: ");
          return;
          $.ajax({
            url: '/api/tasks/create',
            data: new FormData($("#news-form")[0]),
            dataType: 'json',
            type: 'post',
            contentType: false,
            processData: false,
            success: function (data) {
              console.log("Success response: " + data.response);
              window.location.href = "/news";
            },
          });
        });
      });

      function handleDragOver(evt) {
        evt.stopPropagation();
        evt.preventDefault();
        evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
        $('#clickzone').css('backgroundColor', 'red');
//        console.log("DROPOVER: ");
      }

      function handleDragOut(evt) {
        console.log("DRAGOUT: ");
        $('#clickzone').css('backgroundColor', 'transparent');
      }

      function handleFileDrop(evt) {
        evt.stopPropagation();
        evt.preventDefault();
        $('#clickzone').css('backgroundColor', 'transparent');
        var files = evt.dataTransfer.files; // FileList object.

        // files is a FileList of File objects. List some properties.
        var output = [];
        for (var i = 0, f; f = files[i]; i++) {
          output.push('<li><strong>', escape(f.name), '</strong> (', f.type || 'n/a', ') - ',
            f.size, ' bytes, last modified: ',
            f.lastModifiedDate ? f.lastModifiedDate.toLocaleDateString() : 'n/a',
            '</li>');
        }
        console.log("File: " + output.join(''));
        document.getElementById('img-list').innerHTML = '<ul>' + output.join('') + '</ul>';
      }

      function handleFileSelect(evt) {
        var files = evt.target.files; // FileList object

        // files is a FileList of File objects. List some properties.
        var output = [];
        for (var i = 0, f; f = files[i]; i++) {
          if (!f.type.match('image.*')) {
            console.log("KEIN IMAGE: ");
            continue;
          }

          console.log("IST IMAGE: ");
          var reader = new FileReader();

          reader.onload = function (evt) {
            console.log("IN ONLIOAD return: ");
            var imgContainer = $('<span><img class="thumb" src="' + evt.target.result + '"></span>');
            console.log("IMG CONTAINER: " + imgContainer);
            $('#img-list').append(imgContainer);
          };

          reader.readAsDataURL(f);
//
//          output.push('<li><strong>', escape(f.name), '</strong> (', f.type || 'n/a', ') - ',
//            f.size, ' bytes, last modified: ',
//            f.lastModifiedDate ? f.lastModifiedDate.toLocaleDateString() : 'n/a',
//            '</li>');
        }
        console.log("File: " + output.join(''));
      }

      var dropZone = document.getElementById('dropzone');
      //      dropZone.addEventListener('dragover', handleDragOver, false);
      dropZone.addEventListener('dragleave', handleDragOut, false);
      dropZone.addEventListener('drop', handleFileDrop, false);
      document.getElementById('file-btn').addEventListener('change', handleFileSelect, false);

      $('body').on('click', '#dropzone', function (evt) {
        $('#file-btn').trigger('click');
        evt.preventDefault();
      });

    </script>
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
@endsection