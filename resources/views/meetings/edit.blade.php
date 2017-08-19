@extends('layout')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/css/jquery.datetimepicker.min.css">
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
            <form action="/meetings/{{$meeting->id}}" method="POST">
                {{csrf_field()}}
                {{method_field('patch')}}
                <label for="date">Date and Time:</label>
                <input class="w-input" id="date" maxlength="256" name="date"
                       placeholder="Enter the date" type="text" style="color: black;">
                <label for="member">Member:</label>
                <select name="member_id" id="member_id" class="w-select">
                    <option value="">Select...</option>
                    @foreach($members as $member)
                        <option value="{{$member->id}}" @if($meeting->member_id == $member->id) selected @endif>{{$member->firstname}}</option>
                    @endforeach
                </select>
                <label for="user_id">Coach:</label>
                <select name="user_id" id="user_id" class="w-select">
                    <option value="">Select...</option>
                    @foreach($users as $user)
                        <option value="{{$user->id}}" @if($meeting->user_id == $user->id) selected @endif>{{$user->name}} {{$user->lastname}}</option>
                    @endforeach
                </select>
                <label for="notes">Notes</label>
                <textarea name="notes" id="notes" class="w-input">{{$meeting->notes}}</textarea>
                <input class="submit-button w-button" type="submit" value="Submit">
            </form>
        </div>
    </div>
    @include('partials.meeting_confirm_modal')
@endsection

@section('body_javascripts')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>

    <script src="/js/jquery.datetimepicker.min.js"></script>
    <script type="text/javascript">
      var simplemde;
      $(document).ready(function () {
        // DateTimePicker
        $('#date').datetimepicker({
          value: "{{$meeting->date->format('d.m.Y H:i')}}",
          format: 'd.m.Y H:i',
          minDate: new Date(Date.now()).toLocaleString(),
          step: 15,
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
            "preview",
                  @if(isset($meeting->id))
            {
              name: 'hurz',
              action: function hurz(editor) {
                openTaskModal(editor.codemirror.getSelection());
              },
              className: "fa fa-check-square-o"
            }
              @endif
          ]
        });
      });
    </script>
@endsection