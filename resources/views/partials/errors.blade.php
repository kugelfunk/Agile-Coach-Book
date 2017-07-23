@if (count($errors))
    {{--<div style="background-color: rgba(255, 50, 50, 0.3); padding: 5px; margin: 10px 0; border-radius: 5px; color: #aa0000">--}}
    <div class="w-form-fail">
        <h4>Oooops:</h4>
        <ol>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ol>
    </div>
@endif