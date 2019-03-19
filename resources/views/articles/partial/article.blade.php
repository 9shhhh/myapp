<div class="media">
    {{--@include('partial.avatar',['user' => $article->user])--}}
    <div class="media-body">
        <h4 class="media-heading">{{$article->title}}</h4>

        <p class="text-muted">
            <i class="fa fa-user"></i> {{$article->user->name}}
            <i class="fa fa-clock-o"></i> {{$article->created_at->diffForHumans()}}
            <small>
                • {{ $article->created_at->diffForHumans() }}
                • 조회수 {{ $article->view_count }}

                @if ($article->comment_count > 0)
                    • 댓글 {{ $article->comment_count }}개
                @endif
            </small>
        </p>
        @if($viewName === 'articles.index')
            @include('tags.partial.list',['tags'=>$article->tags])
        @endif
        @if ($viewName === 'articles.show')
            @include('attachments.partial.list', ['attachments' => $article->attachments])
        @endif
    </div>
</div>

<a href="{{route('articles.show',$article->id)}}">
    {{$article->title}}
</a>

