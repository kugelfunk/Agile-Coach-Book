@extends('layout')

@section('content')
    <div class="container">
        <div class="w-form">
            <form action="/meetings" method="POST">
                {{csrf_field()}}
                <label for="date">Date and Time:</label>
                <input class="w-input" id="date" maxlength="256" name="date"
                       placeholder="Enter the date" type="text">
                <label for="member">Member:</label>
                <select name="member_id" id="member_id" class="w-select">
                    <option value="">Select...</option>
                    @foreach($members as $member)
                        <option value="{{$member->id}}" @if(request('member_id') == $member->id) selected @endif>{{$member->firstname}}</option>
                    @endforeach
                </select>
                <label for="user_id">Coach:</label>
                <select name="user_id" id="user_id" class="w-select">
                    <option value="">Select...</option>
                    @foreach($users as $user)
                        <option value="{{$user->id}}" @if(request('user_id') == $user->id) selected @endif>{{$user->name}}</option>
                    @endforeach
                </select>
                <label for="email">Notes</label>
                <textarea name="notes" id="notes" cols="30" rows="10" class="w-input"></textarea>
                <input class="submit-button w-button" type="submit" value="Submit">
            </form>
            @include('partials.errors')
        </div>
    </div>
@endsection

@section('body_javascripts')
    <script type="text/javascript">
      $(function () {
      });
    </script>
@endsection