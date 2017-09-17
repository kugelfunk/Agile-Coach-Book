@extends('layout')

@section('content')
    <div class="container">
        <div class="card">
            <h3>All Teams</h3>
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Coach</th>
                    <th style="text-align: center">Members</th>
                </tr>
                </thead>
                <tbody>
                @foreach($teams as $team)
                    <tr>
                        <td><a href="/teams/{{$team->id}}/edit">{{$team->name}}</a></td>
                        <td>@unless(empty($team->user)){{$team->user->name}}@endunless</td>
                        <td style="text-align: center">@unless(empty($team->members))<a href="/members?team_id={{$team->id}}">{{$team->members->count()}}</a>@endunless</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection