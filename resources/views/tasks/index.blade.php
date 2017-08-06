@extends('layout')

@section('styles')

@endsection

@section('content')
    <div class="container">
        <div class="card">
            <h3>Tasks</h3>
            @include('partials.tags')
            <table>
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Coach</th>
                    <th>Meeting</th>
                    <th>Due Date</th>
                    <th>Done</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td><a href="/tasks/{{$task->id}}/edit">{{$task->title}}</a></td>
                        <td>{{$task->user->name}}</td>
                        <td>@unless(is_null($task->meeting_id))<a href="/meetings/{{$task->meeting_id}}/edit">{{$task->meeting->member->firstname}}</a>@endunless</td>
                        <td>@unless(is_null($task->duedate)){{$task->duedate->format('d.m.Y')}}@endunless</td>
                        <td><input type="checkbox" @if($task->done)checked @endif/></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <h3 style="margin-top: 30px;">Completed Tasks</h3>
            <table>
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Coach</th>
                    <th>Member</th>
                    <th>Due Date</th>
                    <th>Done</th>
                </tr>
                </thead>
                <tbody>
                @foreach($completedTasks as $task)
                    <tr>
                        <td><a href="/tasks/{{$task->id}}/edit">{{$task->title}}</a></td>
                        <td>{{$task->user->name}}</td>
                        <td>@unless(is_null($task->meeting_id))<a href="/meetings/{{$task->meeting_id}}/edit">{{$task->meeting->member->firstname}}</a>@endunless</td>
                        <td>@unless(is_null($task->duedate)){{$task->duedate->format('d.m.Y')}}@endunless</td>
                        <td><input type="checkbox" @if($task->done)checked @endif/></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('body_javascripts')

@endsection