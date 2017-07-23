@extends('layout')

@section('content')
    <div class="container">
        <ul>
            @foreach($coaches as $coach)
                <li><a href="/coaches/{{$coach->id}}/edit">{{$coach->name}}</a></li>
            @endforeach
        </ul>
    </div>
@endsection

