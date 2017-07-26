@extends('layout')

@section('content')
    <div class="container">
        @include('partials.errors')
        <div class="w-form">
            <form action="/coaches" method="POST">
                {{csrf_field()}}
                <label for="firstname">First Name:</label>
                <input class="w-input" id="firstname" maxlength="256" name="firstname" placeholder="Enter your first name" type="text">
                <label for="lastname">Last Name:</label>
                <input class="w-input" id="lastname" maxlength="256" name="lastname" placeholder="Enter your last name" type="text">
                <label for="email">Email Address:</label>
                <input class="w-input" id="email" maxlength="256" name="email" placeholder="Enter your email address" type="email">
                <label for="password">Password:</label>
                <input class="w-input" id="password" maxlength="256" name="password" placeholder="Enter your password" type="password">
                <input class="submit-button w-button" type="submit" value="Submit">
            </form>
        </div>
    </div>
@endsection