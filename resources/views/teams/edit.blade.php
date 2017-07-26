@extends('layout')

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
                        <option value="{{$coach->id}}" @if($team->user_id == $coach->id)selected @endif>{{$coach->name}}</option>
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
                </select>
                <input class="submit-button w-button" type="submit" value="Submit">
            </form>
        </div>
    </div>
@endsection