<a href="/tasks">All</a>,
@foreach($tags as $tag)
    <a href="/tasks/tags/{{$tag}}">{{$tag}}</a>@unless($loop->last), @endunless
@endforeach
