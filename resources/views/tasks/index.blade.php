@extends('layout')

@section('styles')
    <link href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <h3 style="float: left">Tasks</h3>
            <div class="dropdown w-dropdown" data-delay="0" data-hover="1" style="float: right; margin-top: -10px;">
                <div class="dropdown-toggle w-dropdown-toggle">
                    <div>{{isset($currentFilter) ? $currentFilter : 'No Filter'}}</div>
                    <div class="w-icon-dropdown-toggle"></div>
                </div>
                <nav class="w-dropdown-list">
                    <a class="w-dropdown-link" href="/tasks">No Filter</a>
                    <div class="dropdown-section-header">COACHES</div>
                    @foreach($coaches as $coach)
                        <a class="w-dropdown-link" href="/tasks?coach={{$coach->id}}">{{$coach->name}}</a>
                    @endforeach
                    <div class="dropdown-section-header">TAGS</div>
                    @foreach($tags as $tag)
                        <a class="w-dropdown-link" href="/tasks/tags/{{$tag}}">{{$tag}}</a>
                    @endforeach
                </nav>
            </div>
            <table style="clear: both">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Coach</th>
                    <th>Meeting</th>
                    <th>Due Date</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td><a href="/tasks/{{$task->id}}/edit">{{$task->title}}</a></td>
                        <td>{{$task->user->name}}</td>
                        <td>@unless(is_null($task->meeting))<a href="/meetings/{{$task->meeting_id}}/edit">{{$task->meeting->member->firstname}}</a>@endunless</td>
                        <td>@unless(is_null($task->duedate)){{$task->duedate->format('d.m.Y')}}@endunless</td>
                        <td><a href="/tasks/{{$task->id}}/check"><i class="fa fa-square-o" style="color: #777;"></i></a></td>
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
                    <th>Meeting</th>
                    <th>Due Date</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($completedTasks as $task)
                    <tr>
                        <td><a href="/tasks/{{$task->id}}/edit">{{$task->title}}</a></td>
                        <td>{{$task->user->name}}</td>
                        <td>@unless(is_null($task->meeting_id))<a href="/meetings/{{$task->meeting_id}}/edit">{{$task->meeting->member->firstname}}</a>@endunless</td>
                        <td>@unless(is_null($task->duedate)){{$task->duedate->format('d.m.Y')}}@endunless</td>
                        <td><a href="/tasks/{{$task->id}}/uncheck"><i class="fa fa-check-square-o" style="color: #777;"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('body_javascripts')

@endsection