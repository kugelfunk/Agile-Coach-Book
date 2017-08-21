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

        .select2-container {
            margin-bottom: 10px;
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

        #img-list {
            width: 100%;
        }

        .file-box {
            margin-top: 5px;
            width: 110px;
            padding: 5px;
            text-align: center;
            display: inline-block;

        }

        .file-thumb {
            width: 100%;
        }

        .thumb-caption {
            width: 100%;
            display: block;
            margin-top: 2px;
            font-size: 10px;
            line-height: 13px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            float: left;
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

        var uploadFiles = [];

      $(document).ready(function () {
        $('#task-confirm-form').submit(function (evt) {
          evt.preventDefault();
          var fd = new FormData($('#task-confirm-form')[0]);
//          for (var pair of fd.entries()) {
//            console.log(pair[0]+ ', ' + pair[1]);
//          }
          var formData = new FormData($("#task-confirm-form")[0]);
          var fileField = document.getElementById('file-btn').files;
          console.log("Anzahl Files: : " + (fileField.length + uploadFiles.length));
          var numFiles = fileField.length;
          /*
          for(var i = 0; i < numFiles; i++) {
            console.log("appending file : " + (i + 1));
            formData.append('attachments[]', fileField[i]);
          }
            */
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
//              window.location.href = "/news";
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
//        console.log("DROPOVER: ");
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
          if(filesize > 100) {
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
//
//          output.push('<li><strong>', escape(f.name), '</strong> (', f.type || 'n/a', ') - ',
//            f.size, ' bytes, last modified: ',
//            f.lastModifiedDate ? f.lastModifiedDate.toLocaleDateString() : 'n/a',
//            '</li>');
          } else {
            imgContainer = $('<div class="file-box" style="position: relative; text-align: center"><img class="file-thumb" style="width: 30%" src="/images/file_icon.svg"><span class="thumb-caption" style="">' + f.name + '</span></div>');
//            $('<span class="thumb-caption" style="position: absolute; top: 20px;">' + "myfile.pdf" + '</span>');
            $('#img-list').append(imgContainer);
          }

        }
        // files is a FileList of File objects. List some properties.
        /*
        var output = [];
        for (var i = 0, f; f = files[i]; i++) {
          output.push('<li><strong>', escape(f.name), '</strong> (', f.type || 'n/a', ') - ',
            f.size, ' bytes, last modified: ',
            f.lastModifiedDate ? f.lastModifiedDate.toLocaleDateString() : 'n/a',
            '</li>');
        }
        */
//        console.log("File: " + output.join(''));
//        document.getElementById('img-list').innerHTML = '<ul>' + output.join('') + '</ul>';
      }

      function handleFileSelect(evt) {
        var files = evt.target.files;

        var imgContainer;
        $('#img-list').empty();
        uploadFiles.length = 0;
        for (var i = 0, f; f = files[i]; i++) {
          var filesize = Math.round(f.size / 1024);
          if(filesize > 100) {
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
//
//          output.push('<li><strong>', escape(f.name), '</strong> (', f.type || 'n/a', ') - ',
//            f.size, ' bytes, last modified: ',
//            f.lastModifiedDate ? f.lastModifiedDate.toLocaleDateString() : 'n/a',
//            '</li>');
          } else {
            imgContainer = $('<div class="file-box" style="position: relative; text-align: center"><img class="file-thumb" style="width: 30%" src="/images/file_icon.svg"><span class="thumb-caption" style="">' + f.name + '</span></div>');
//            $('<span class="thumb-caption" style="position: absolute; top: 20px;">' + "myfile.pdf" + '</span>');
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