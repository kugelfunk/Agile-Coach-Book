@extends('layout')

@section('content')
    <div class="container">
        <div class="card">
            <h3>Upcoming Meetings</h3>
            <table>
                <thead>
                <tr>
                    <th>Member</th>
                    <th>Coach</th>
                    <th>Date</th>
                    <th>Export</th>
                </tr>
                </thead>
                <tbody>
                @foreach($meetings as $meeting)
                    <tr onclick="location.href='/meetings/{{$meeting->id}}/edit'" style="cursor: pointer">
                        <td><a href="/members/{{$meeting->member_id}}/edit">{{$meeting->member->firstname}}</a></td>
                        <td>{{$meeting->user->name}}</td>
                        <td>{{$meeting->date->format('d.m.Y, H:i')}}</td>
                        <td><a href="/ical/{{$meeting->id}}">iCal</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <h3 style="margin-top: 30px;">Previous Meetings</h3>
            <table>
                <thead>
                <tr>
                    <th>Member</th>
                    <th>Coach</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($oldMeetings as $meeting)
                    <tr onclick="location.href='/meetings/{{$meeting->id}}/edit'" style="cursor: pointer">
                        <td><a href="/members/{{$meeting->member_id}}/edit">{{$meeting->member->firstname}}</a></td>
                        <td>{{$meeting->user->name}}</td>
                        <td>{{$meeting->date->format('d.m.Y, H:i')}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection