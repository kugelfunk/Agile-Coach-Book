@extends('layout')

@section('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
            <form action="/api/tasks/{{$task->id}}" id="task-confirm-form" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                {{method_field('patch')}}
                <h3>Edit Task</h3>
                <label for="title">Title:</label>
                <input class="w-input" id="title" maxlength="256" name="title" placeholder="Enter the title"
                       value="{{$task->title}}">
                <label for="duedate">Due Date:</label>
                <input class="w-input" id="duedate" maxlength="40" name="duedate" placeholder="Enter the date"
                       value="@unless(is_null($task->duedate)){{$task->duedate->format('d.m.Y')}}@endunless">
                <label for="user_id">Coach</label>
                <select class="w-select" name="user_id" id="user_id">
                    @foreach($users as $user)
                        <option value="{{$user->id}}"
                                @if($task->user_id == $user->id) selected @endif>{{$user->name}}</option>
                    @endforeach
                </select>
                <label for="tags">Tags</label>
                <select name="tags[]" id="tags" class="w-select" multiple="multiple">
                    @foreach($tags as $tag)
                        <option value="{{$tag->id}}" @if(in_array($tag->name, $task->tags->pluck('name')->all()))selected @endif>{{$tag->name}}</option>
                    @endforeach
                </select>
                <label for="notes">Notes</label>
                <textarea name="notes" id="notes" class="w-input">{{$task->notes}}</textarea>
                <label for="attachments">Attachments</label>
                <div class="attachments" @if($task->attachments->count() > 0) style="display:block;" @endif>
                    @foreach($task->attachments as $attachment)
                        <a href="{{'/attachments/'.$attachment->handle . '.' . $attachment->extension}}" target="_blank">
                            <div class="file-box" style="position: relative; text-align: center">
                                <div class="delete-btn" data-attachment_id="{{$attachment->id}}">X</div>
                                <img class="file-thumb" src="{{$attachment->filetype == 'image' ? '/attachments/'.$attachment->handle . '_thumbnail.' . $attachment->extension : '/images/file_icon.png'}}">
                                <span class="thumb-caption" style="">{{$attachment->handle . '.' . $attachment->extension}}</span>
                            </div>
                        </a>

                    @endforeach
                </div>
                <div class="file-upload" id="dropzone">
                    <span class="file-upload-caption">Add Attachment</span>
                    <div id="img-list"></div>
                </div>
                <input type="file" id="file-btn" name="files[]" multiple/>
                <div class="w-checkbox" style="margin: 10px 0 0 0;">
                    <input class="w-checkbox-input" id="done" name="done" type="checkbox"
                           @if($task->done)checked @endif>
                    <label class="w-form-label" for="done">Task is completed</label>
                </div>
                <input type="submit" class="submit-button w-button" value="Submit"/>
                <a href="{{url()->previous()}}" class="modal-cancel" style="margin-left: 10px;">Cancel</a>
            </form>
        </div>
    </div>
@endsection

@section('body_javascripts')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="/js/jquery.datetimepicker.min.js"></script>
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
          element: document.getElementById("notes"),
          spellChecker: false,
          status: false,
          toolbar: [
            "bold",
            "heading",
            "ordered-list",
            "unordered-list",
            "table",
            "link",
            "strikethrough",
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
      
      var removedAttachments = [];

      var MAX_FILE_SIZE = 1000;

      $(document).ready(function () {
        $('.delete-btn').click(function(evt) {
          evt.preventDefault();
          evt.stopImmediatePropagation();
          removedAttachments.push($(this).data('attachment_id'));
          $(this).parent().hide('fast', function() {
            $(this).parent().remove()
          });
        });
        
        $('#task-confirm-form').submit(function (evt) {
          evt.preventDefault();
          var formData = new FormData($("#task-confirm-form")[0]);
          formData.append('_method', 'PATCH');
          formData.append('removedAttachments', JSON.stringify(removedAttachments));
          for(var i = 0; i < uploadFiles.length; i++) {
            formData.append('files[]', uploadFiles[i]);
          }

//          $.ajaxSetup({
//            headers: {
//              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//            }
//          });

          $.ajax({
            url: '/api/tasks/{{$task->id}}',
            data: formData,
            dataType: 'json',
            type: 'post',
            contentType: false,
            processData: false,
            success: function (data) {
              console.log("Success response: " + data.response);
              window.location.href = "/tasks";
            },
            error: function(xhr, status, error) {
              console.log("ERROR Response: " + xhr.response);
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
            alert("Filesize of " + f.name + " is " + filesize + ". That is too big. Max 1 MB please");
            continue;
          }
          if (f.type.match('image.*')) {

            var reader = new FileReader();

            reader.onload = (function (theFile) {
              return function (evt) {
                imgContainer = $('<div class="file-box"><img class="file-thumb" src="' + evt.target.result + '"><span class="thumb-caption" style="">' + Math.round(theFile.size/1024) + '</span></div>');
                $('#img-list').append(imgContainer);
              }
            })(f);

            reader.readAsDataURL(f);
          } else {
            imgContainer = $('<div class="file-box" style="position: relative; text-align: center"><img class="file-thumb" src="/images/file_icon.png"><span class="thumb-caption" style="">' + f.name + '</span></div>');
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
            alert("Filesize of " + f.name + " is " + filesize + ". That is too big. Max 1 MB please");
            continue;
          }
          if (f.type.match('image.*')) {

            var reader = new FileReader();

            reader.onload = (function (theFile) {
              return function (evt) {
                imgContainer = $('<div class="file-box"><img class="file-thumb" src="' + evt.target.result + '"><span class="thumb-caption" style="">' + theFile.name + '</span></div>');
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