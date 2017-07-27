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
            <form action="/teams" method="POST">
                {{csrf_field()}}
                <label for="name">Name:</label>
                <input class="w-input" id="name" maxlength="256" name="name"
                       placeholder="Enter the team name" type="text">
                <label for="user_id">Team Coach</label>
                <select class="w-select" name="user_id" id="user_id">
                    <option value="">No coach yet</option>
                    @foreach($coaches as $coach)
                        <option value="{{$coach->id}}">{{$coach->name}} {{$coach->lastname}}</option>
                    @endforeach
                </select>
                <label for="meeting_interval">Default Meeting Interval:</label>
                <select class="w-select" name="meeting_interval" id="meeting_interval">
                    <option value="7">1 week</option>
                    <option value="14">2 weeks</option>
                    <option value="21">3 weeks</option>
                    <option value="30" selected>1 month</option>
                    <option value="42">6 weeks</option>
                    <option value="60">2 months</option>
                    <option value="90">3 months</option>
                    <option value="180">6 months</option>
                    <option value="0">Never</option>
                </select>
                <label for="notes">Notes</label>
                <textarea name="notes" id="notes" rows="5" class="w-input"></textarea>
                <input class="submit-button w-button" type="submit" value="Submit">
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