@extends('layout')

@section('content')
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Coach</th>
                    <th>Members</th>
                </tr>
            </thead>
            <tbody>
            @foreach($teams as $team)
                <tr>
                    <td><a href="/teams/{{$team->id}}/edit">{{$team->name}}</a></td>
                    <td>@unless(empty($team->user)){{$team->user->name}}@endunless</td>
                    <td style="text-align: center">@unless(empty($team->members)){{$team->members->count()}}@endunless</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection