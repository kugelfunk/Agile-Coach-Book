@extends('layout')

@section('content')
    <div class="container">
        <div class="card">
            <h3 style="float: left;">All Members</h3>
            <div class="dropdown w-dropdown" data-delay="0" data-hover="1" style="float: right;">
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
                    <th>Meetings</th>
                </tr>
                </thead>
                <tbody>
                @foreach($members as $member)
                    <tr>
                        <td><a href="/members/{{$member->id}}/edit">{{$member->firstname}}</a></td>
                        <td>@unless(empty($member->team)){{$member->team->name}}@endunless</td>
                        <td style="text-align: center">@unless(empty($member->meetings)){{$member->meetings->count()}}@endunless</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection