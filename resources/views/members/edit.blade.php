@extends('layout')

@section('content')
    <div class="container">
        <div class="w-form">
            @include('partials.errors')
            <form action="/members/{{$member->id}}" method="POST">
                {{method_field('patch')}}
                {{csrf_field()}}
                <label for="name">First Name:</label>
                <input class="w-input" id="name" maxlength="256" name="firstname"
                       placeholder="Enter the first name" type="text" value="{{$member->firstname}}">
                <label for="name">Last Name:</label>
                <input class="w-input" id="name" maxlength="256" name="lastname"
                       placeholder="Enter the last name" type="text" value="{{$member->lastname}}">
                <label for="email">Email Address:</label>
                <input class="w-input" id="email" maxlength="256" name="email" placeholder="Enter the email address"
                       type="email" value="{{$member->email}}">
                <label for="user_id">Team</label>
                <select class="w-select" name="team_id" id="team_id">
                    <option value="">No team</option>
                    @foreach($teams as $team)
                        <option value="{{$team->id}}" data-interval="{{$team->meeting_interval}}" @if($member->team_id == $team->id) selected @endif>{{$team->name}}</option>
                    @endforeach
                </select>
                <label for="meeting_interval">Default Meeting Interval:</label>
                <select class="w-select" name="meeting_interval" id="meeting_interval">
                    <option value="">Select...</option>
                    <option value="7" @if($member->meeting_interval == 7) selected @endif>1 week</option>
                    <option value="14" @if($member->meeting_interval == 14) selected @endif>2 weeks</option>
                    <option value="21" @if($member->meeting_interval == 21) selected @endif>3 weeks</option>
                    <option value="30" @if($member->meeting_interval == 30) selected @endif>1 month</option>
                    <option value="42" @if($member->meeting_interval == 42) selected @endif>6 weeks</option>
                    <option value="60" @if($member->meeting_interval == 60) selected @endif>2 months</option>
                    <option value="90" @if($member->meeting_interval == 90) selected @endif>3 months</option>
                    <option value="180" @if($member->meeting_interval == 180) selected @endif>6 months</option>
                </select>
                <input class="submit-button w-button" type="submit" value="Submit">
            </form>
        </div>
    </div>
@endsection

@section('body_javascripts')
    <script type="text/javascript">
      $(function () {
        $('#team_id').change(function(){
          var interval = $(this).find(':selected').data('interval');
          $('#meeting_interval').val(interval);
        });
      });
    </script>
@endsection