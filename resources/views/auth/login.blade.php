@extends('layout_blank')

@section('content')
    <div class="container">
        <div class="w-form">
            <form data-name="Login Form" id="login-form" name="login-form" action="{{ route('login') }}" method="POST">
                {{ csrf_field() }}
                <h3>Login</h3>
                @include('partials.errors')
                <label for="email-3">Email Address:</label>
                <input class="w-input" data-name="email" id="email-3" maxlength="256" name="email"
                       placeholder="Enter your email address" required="required" type="email">
                <label for="password-2">Password:</label>
                <input class="w-input" data-name="password" id="password-2" maxlength="256" name="password"
                       placeholder="Enter your password" required="required" type="password">
                <input class="submit-button w-button" type="submit" value="Submit">
            </form>
            <!--
            <div style="margin-top: 10px;">
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    Passwort vergessen?
                </a>
            </div>
            -->
        </div>
    </div>
@endsection