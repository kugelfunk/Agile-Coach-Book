<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
<h3>Tasks</h3>
<ul style="list-style-type: none; padding-left: 0">
    @if(count($tasks) > 0)
        @foreach($tasks as $task)
            <li><a href="https://acb.martinlehmann.com/tasks/{{$task->id}}/edit"
                   title="{{$task->title}}" style="text-decoration: none">{{$task->title}} <span
                            style="float: right;">@unless(is_null($task->duedate)){{\Carbon\Carbon::parse($task->duedate)->format('l, d.m.y')}}@endunless</span></a>
            </li>
        @endforeach
    @else
        You have no open tasks.
    @endif
</ul>
<h3 style="padding-top: 15px;">Meetings</h3>
<ul style="list-style-type: none; padding-left: 0">
    @if(count($meetings) > 0)
        @foreach($meetings as $meeting)
            <li>
                <a href="https://acb.martinlehmann.com/meetings/{{$meeting->id}}/edit" style="text-decoration: none">
                    {{$meeting->firstname}} {{$meeting->lastname}}<span
                            style="float: right;">{{\Carbon\Carbon::parse($meeting->date)->format('l, d.m.Y H:i')}}</span></a>
            </li>
        @endforeach
    @else
        You have no 1 on 1 meetings this week.
    @endif
</ul>
<br>
<span style="color: #555555">Have a good week, my friend.</span>
</body>
</html>