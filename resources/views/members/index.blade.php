
@extends('layout')

@section('content')
    <div class="container">
        <table>
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
@endsection