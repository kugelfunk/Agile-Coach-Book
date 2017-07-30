@extends('layout')

@section('styles')
    <link href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="w-container">
        <div class="w-row">
            <div class="w-col w-col-4">
                <div class="card">
                    <h3><a href="/members">Members without Meetings</a></h3>
                    <ul>
                        @foreach($membersWithoutMeeting as $member)
                            <li><a href="/meetings/create?member_id={{$member->id}}">{{$member->firstname}}</a></li>
                        @endforeach
                    </ul>
                    <h3 style="margin-top: 30px;">Members with Due Meetings</h3>
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
                    <h3><a href="/meetings">Upcoming Meetings</a></h3>
                    <ul>
                        @foreach($dates as $date)
                            <li>
                                <a href="/meetings/{{$date->id}}/edit">{{\Carbon\Carbon::parse($date->date)->format('d.m.Y H:i')}}
                                    mit {{$date->firstname}}</a> <span style="float: right"><a
                                            href="/ical/{{$date->id}}"><i class="fa fa-calendar"
                                                                          style="color: #777;"></i></a></span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="w-col w-col-4">
                <div class="card">
                    <h3><a href="/tasks">Tasks</a></h3>
                    <ul>
                        @foreach($tasks as $task)
                            <li><a href="/tasks/{{$task->id}}/edit">{{$task->title}} <span style="float: right; color: #5d6c7b">@unless(is_null($task->duedate)){{$task->duedate->format('d.m.Y')}}@endunless</span></a></li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection