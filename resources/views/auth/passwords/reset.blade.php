@extends('layouts_blank.app')

@section('content')
<div class="container">
    <div class="w-form">
        <form data-name="Login Form" id="login-form" name="login-form" action="{{ route('password.request') }}" method="POST">
            {{ csrf_field() }}
            <h3>reset Password</h3>
            <input type="hidden" name="token" value="{{ $token }}">
            @include('partials.errors')
            <label for="email-3">Email Address:</label>
            <input class="w-input" data-name="email" id="email-3" maxlength="256" name="email"
                   placeholder="Enter your email address" required="required" type="email">
            <label for="password-2">Password:</label>
            <input class="w-input" data-name="password" id="password-2" maxlength="256" name="password"
                   placeholder="Enter your password" required="required" type="password">
            <input class="submit-button-2 w-button" data-wait="Please wait..." type="submit" value="Submit">
        </form>
        <div style="margin-top: 10px;">
            <a class="btn btn-link" href="{{ route('password.request') }}">
                Passwort vergessen?
            </a>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
