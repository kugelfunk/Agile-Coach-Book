@extends('layout')

@section('content')

    <div class="container">
        <h3>Editiere {{$user->name}}</h3>
        <div class="w-form">
            <form data-name="Email Form" name="email-form" action="/coaches/{{$user->id}}" method="POST">
                {{csrf_field()}}
                {{method_field('patch')}}
                <label for="name">First Name:</label>
                <input class="w-input" id="name" maxlength="256" name="name"
                       placeholder="Enter your first name" type="text" value="{{$user->name}}">
                <label for="email">Email Address:</label>
                <input class="w-input" id="email" maxlength="256" name="email" placeholder="Enter your email address"
                       type="email" value="{{$user->email}}">
                <input class="submit-button w-button" type="submit" value="Submit">
            </form>
            @include('partials.errors')
        </div>
    </div>

@endsection