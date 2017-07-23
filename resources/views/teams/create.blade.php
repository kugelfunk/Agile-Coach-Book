@extends('layout')

@section('content')
    <div class="container">
        <div class="w-form">
            <form action="/teams" method="POST">
                {{csrf_field()}}
                <label for="name">Name:</label>
                <input class="w-input" id="name" maxlength="256" name="name"
                       placeholder="Enter the team name" type="text">
                <label for="user_id">Team Coach</label>
                <select class="w-select" name="user_id" id="user_id">
                    <option value="">No coach yet</option>
                    @foreach($coaches as $coach)
                        <option value="{{$coach->id}}">{{$coach->name}}</option>
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
                </select>
                <input class="submit-button w-button" type="submit" value="Submit">
            </form>
            @include('partials.errors')
        </div>
    </div>
@endsection