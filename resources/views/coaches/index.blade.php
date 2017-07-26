@extends('layout')

@section('content')
    <div class="container">
        <div class="card">
            <h3>All Coaches</h3>
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Teams</th>
                </tr>
                </thead>
                <tbody>
                @foreach($coaches as $coach)
                    <tr>
                        <td>
                            <a href="/coaches/{{$coach->id}}/edit">{{$coach->name}}</a>
                        </td>
                        <td>
                            @foreach($coach->teams as $team)
                                <a href="/teams/{{$team->id}}/edit">{{$team->name}}</a>@if($loop->index < ($coach->teams->count() - 1)), @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

