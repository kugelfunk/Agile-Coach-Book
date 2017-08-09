@extends('layout')

@section('styles')
    <link rel="stylesheet" href="/css/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="/css/tagging.css">
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
                <div data-tags-input-name="tag" name="tags" id="tags" class="w-input">preexisting-tag, hurz, Drogen</div>
                <label for="notes">Notes</label>
                <textarea name="notes" id="notes" class="w-input"></textarea>
                <input type="submit" class="submit-button w-button" value="Submit"/>
                <a href="{{url()->previous()}}" class="modal-cancel" style="margin-left: 10px;">Cancel</a>
            </form>
        </div>
    </div>
@endsection

@section('body_javascripts')
    <script src="/js/jquery.datetimepicker.min.js"></script>
    <script type="text/javascript" src="/js/tagging.min.js"></script>
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
        var taggingOptions = {
          "edit-on-delete": false,
          "tags-limit": 4
        };
        $("#tags").tagging(taggingOptions);
      });
    </script>
@endsection