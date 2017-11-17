@extends('layout')

@section('styles')
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
            <form action="/teams/{{$team->id}}" method="POST">
                {{csrf_field()}}
                {{method_field('patch')}}
                <label for="name">Name:</label>
                <input class="w-input" id="name" maxlength="256" name="name"
                       placeholder="Enter the team name" type="text" value="{{$team->name}}">
                <label for="user_id">Team Coach</label>
                <select class="w-select" name="user_id" id="user_id">
                    <option value="">No coach</option>
                    @foreach($coaches as $coach)
                        <option value="{{$coach->id}}"
                                @if($team->user_id == $coach->id)selected @endif>{{$coach->name}} {{$coach->lastname}}</option>
                    @endforeach
                </select>
                <label for="meeting_interval">Default Meeting Interval:</label>
                <select class="w-select" name="meeting_interval" id="meeting_interval">
                    <option value="7" @if($team->meeting_interval == 7) selected @endif>1 week</option>
                    <option value="14" @if($team->meeting_interval == 14) selected @endif>2 weeks</option>
                    <option value="21" @if($team->meeting_interval == 21) selected @endif>3 weeks</option>
                    <option value="30" @if($team->meeting_interval == 30) selected @endif>1 month</option>
                    <option value="42" @if($team->meeting_interval == 42) selected @endif>6 weeks</option>
                    <option value="60" @if($team->meeting_interval == 60) selected @endif>2 months</option>
                    <option value="90" @if($team->meeting_interval == 90) selected @endif>3 months</option>
                    <option value="180" @if($team->meeting_interval == 180) selected @endif>6 months</option>
                    <option value="0" @if($team->meeting_interval == 0) selected @endif>Never</option>
                </select>
                <div class="w-checkbox">
                    <input class="w-checkbox-input" id="reset_intervals" name="reset_intervals" type="checkbox">
                    <label class="w-form-label" for="reset_intervals">Reset individual meeting intervals</label>
                </div>
                <label for="notes">Notes</label>
                <textarea name="notes" id="notes" rows="5" class="w-input">{{$team->notes}}</textarea>
                <input class="submit-button w-button" type="submit" value="Submit">
                <a href="{{url()->previous()}}" class="modal-cancel" style="margin-left: 10px;">Cancel</a>
                <a href="/members?team_id={{$team->id}}" class="modal-cancel" style="margin-left: 10px;">Show Team Members</a>
            </form>
        </div>
    </div>
@endsection

@section('body_javascripts')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>

    <script src="/js/jquery.datetimepicker.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function () {
        // Text Editor
        var simplemde = new SimpleMDE({
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
          ]
        });
      });
    </script>
@endsection