@if ($tags->count())
    <ul class="tags_article">
        @foreach ($tags as $tag)
            <li><a href="{{route('tags.articles.index',$tag->slug)}}">
                    {{$tag->name}}
                </a></li>
         @endforeach
    </ul>
@endif