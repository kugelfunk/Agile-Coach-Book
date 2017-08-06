<ul>
    @foreach($tags as $tag)
        <li><a href="/tasks/tags/{{$tag}}">{{$tag}}</a></li>
    @endforeach
</ul>