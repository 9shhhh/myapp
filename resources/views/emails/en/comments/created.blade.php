<h1>
    {{ $comment->commentable->title }}
    <small>
        by {{ $comment->user->name }}
    </small>
</h1>
<p>
    {!! markdown($comment->content) !!}
    <smail>{{$comment->created_at}}</smail>
</p>
<hr/>
<footer>본 메일은 {{config('app.url')}}에서 보냈습니다.</footer>