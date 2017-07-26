@extends('layout')

@section('content')
    <div class="w-container">
        <div class="w-row">
            <div class="w-col w-col-4">
                <div class="card">
                    <h3>Members without Meetings</h3>
                    <ul>
                        @foreach($membersWithoutMeeting as $member)
                            <li><a href="/meetings/create?member_id={{$member->id}}">{{$member->firstname}}</a></li>
                        @endforeach
                    </ul>
                    <hr style="margin: 20px 0;">
                    <h3>Members with Due Meetings</h3>
                    <ul>
                        @foreach($membersWithOverdueMeetings as $member)
                            <li><a href="/meetings/create?member_id={{$member->id}}">{{$member->firstname}}
                                    ({{$member->overdue}})</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="w-col w-col-4">
                <div class="card">
                    <h3>Upcoming Meetings</h3>
                    <ul>
                        @foreach($dates as $date)
                            <li>
                                <a href="/meetings/{{$date->id}}/edit">{{\Carbon\Carbon::parse($date->date)->format('d.m.Y H:i')}}
                                    mit {{$date->firstname}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="w-col w-col-4">
                <div class="card">
                    <h3>Tasks</h3>
                    <ul>

                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection