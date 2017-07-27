@extends('layout')

@section('content')

    <div class="container">
        <h3>Editiere {{$user->name}}</h3>
        <div class="w-form">
            @include('partials.errors')
            <form data-name="Email Form" name="email-form" action="/coaches/{{$user->id}}" method="POST">
                {{csrf_field()}}
                {{method_field('patch')}}
                <label for="name">Name:</label>
                <input class="w-input" id="name" maxlength="256" name="name"
                       placeholder="Enter your full name" type="text" value="{{$user->name}}">
                <label for="lastname">Last Name:</label>
                <input class="w-input" id="lastname" maxlength="256" name="lastname" placeholder="Enter your last name" type="text" value="{{$user->lastname}}">
                <label for="email">Email Address:</label>
                <input class="w-input" id="email" maxlength="256" name="email" placeholder="Enter your email address"
                       type="email" value="{{$user->email}}">
                <label for="password">Password (only for changing it):</label>
                <input class="w-input" id="password" maxlength="256" name="password" placeholder="Enter new password if you want to change it"
                       type="password">
                <input class="submit-button w-button" type="submit" value="Submit">
            </form>
        </div>
    </div>

@endsection