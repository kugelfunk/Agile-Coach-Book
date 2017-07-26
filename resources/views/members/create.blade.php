@extends('layout')

@section('content')
    <div class="container">
        <div class="w-form">
            @include('partials.errors')
            <form action="/members" method="POST">
                {{csrf_field()}}
                <label for="name">First Name:</label>
                <input class="w-input" id="name" maxlength="256" name="firstname"
                       placeholder="Enter the first name" type="text">
                <label for="name">Last Name:</label>
                <input class="w-input" id="name" maxlength="256" name="lastname"
                       placeholder="Enter the last name" type="text">
                <label for="email">Email Address:</label>
                <input class="w-input" id="email" maxlength="256" name="email" placeholder="Enter the email address"
                       type="email">
                <label for="user_id">Team</label>
                <select class="w-select" name="team_id" id="team_id">
                    <option value="">No team</option>
                    @foreach($teams as $team)
                        <option value="{{$team->id}}" data-interval="{{$team->meeting_interval}}">{{$team->name}}</option>
                    @endforeach
                </select>
                <label for="meeting_interval">Default Meeting Interval:</label>
                <select class="w-select" name="meeting_interval" id="meeting_interval">
                    <option value="">Select...</option>
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