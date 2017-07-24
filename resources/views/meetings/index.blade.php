@extends('layout')

@section('content')
    <div class="container">
        <table>
            <thead>
            <tr>
                <th>Member</th>
                <th>Date</th>
                <th>Info</th>
            </tr>
            </thead>
            <tbody>
            @foreach($meetings as $meeting)
                <tr>
                    <td><a href="/meetings/{{$meeting->id}}/edit">{{$meeting->member->name}}</a></td>
                    <td>{{$meeting->date}}</td>
                    <td></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection