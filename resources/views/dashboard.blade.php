@extends('layout')

@section('content')
    <style type="text/css">
        .card {
            /*background-color: white;*/
            padding: 20px;
        }
        h3 {
            margin-top: 5px;
        }
    </style>
    <div style="width: 100%; margin-left: -15px; margin-right: -15px;">
        <div style="width: 32%; display: block; float: left; padding: 0 10px; margin: 10px 0;">
            <div class="card">
                <h3>Members without Meetings</h3>
                <ul>
                    @foreach($membersWithoutMeeting as $member)
                        <li>{{$member->firstname}}</li>
                    @endforeach
                </ul>

                <h3>Members with Overdue Meetings</h3>
                <ul>
                    @foreach($membersWithOverdueMeetings as $member)
                        <li>{{$member->firstname}} ({{$member->overdue}})</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div style="width: 32%; height: 200px; display: block; float: left; padding: 0 10px; margin: 10px 0;">
            <div class="card">
                <h3>Upcoming Dates</h3>
                <ul>
                    @foreach($dates as $date)
                        <li>{{$date->date}} mit {{$date->firstname}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div style="width: 32%; display: block; float: left; padding: 0 10px; margin: 10px 0;">
            <div class="card">
                <h3>Tasks</h3>
                <ul>

                </ul>
            </div>
        </div>
    </div>
@endsection