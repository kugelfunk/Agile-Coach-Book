@extends('layout')

@section('content')
    <div class="container">
        <div class="card">
            <h3 style="float: left;">All Members @if(isset($currentTeam)){{$currentTeam->name}}@endif</h3>
            <div class="dropdown w-dropdown" data-delay="0" data-hover="1" style="float: right; margin-top: -10px;">
                <div class="dropdown-toggle w-dropdown-toggle">
                    <div>Team Filter</div>
                    <div class="w-icon-dropdown-toggle"></div>
                </div>
                <nav class="w-dropdown-list">
                    <a class="w-dropdown-link" href="/members">All teams</a>
                    @foreach($teams as $team)
                        <a class="w-dropdown-link" href="/members?team_id={{$team->id}}">{{$team->name}}</a>
                    @endforeach
                </nav>
            </div>
            <table style="clear: both;">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Team</th>
                    <th style="text-align: center">Meetings</th>
                </tr>
                </thead>
                <tbody>
                @foreach($members as $member)
                    <tr>
                        <td><a href="/members/{{$member->id}}/edit" title="{{$member->firstname}} {{$member->lastname}}">{{$member->firstname}} {{$member->lastname[0]}}.</a></td>
                        <td>@unless(empty($member->team))<a href="/teams/{{$member->team_id}}/edit">{{$member->team->name}}</a>@endunless</td>
                        <td style="text-align: center">@unless(empty($member->meetings))<a href="/members/{{$member->id}}/edit">{{$member->meetings->count()}}</a>@endunless</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection