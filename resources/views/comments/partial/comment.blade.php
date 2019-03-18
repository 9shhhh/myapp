@php
    // 현재 로그인 한 사용자가 이 댓글에 이미 투표 했는지 구분하는 플래그 변수.
    $voted = null;
    // 사용자 로그인 확인.
    if($currentUser){
        // 로그인 확인 시 상세보기 페이지 접근 허용.
        $voted = $comment->votes->contains('user_id',$currentUser->id) ? 'disabled="disabled"' : null;
    }
@endphp

<div class="media item__comment {{$isReply ? 'sub' : 'top'}}"
     data-id="{{$comment->id}}" id="comment_{{$comment->id}}">
    {{--@include('users.partial.avatar', ['user'=> $comment->user, 'size' => 32])--}}

    <div class="media-body">
        <h5 class="media-heading">
            <a href="{{$comment->user->email}}">
                {{$comment->user->name}}
            </a>
            <small>
                {{$comment->created_at->diffForHumans()}}
            </small>
        </h5>

        <div class="content__comment">
            {!! markdown($comment->content) !!}
        </div>

        <div class="action__comment">
            @if($currentUser)
                <button class="btn__vote__comment" data-vote="up" title="좋아요" {{$voted}}>
                    <i class="fa fa-chevron-up"></i>
                    <span>{{$comment->up_count}}</span>
                </button>
             <span> | </span>
                <button class="btn__vote__comment" data-vote="down" title="싫어요" {{$voted}}>
                    <i class="fa fa-chevron-down"></i>
                    <span>{{$comment->down_count}}</span>
                </button>
                *
            @endif
        </div>

        <div class="action__comment">
            @can('update',$comment)
                <button class="btn__delete_comment">댓글 삭제</button>
                <button class="btn__delete_comment">댓글 수정</button>
            @endcan

            @if($currentUser)
                <button class="btn__reply__comment">답글 쓰기</button>
            @endif
        </div>

        @if($currentUser)
            @include('comments.partial.create',['parentId'=>$comment->id])
        @endif

        @can('update',$comment)
            @include('comments.partial.edit')
        @endcan

        {{--@forelse($comment->replies as $reply)--}}
            {{--@include('comments.replies.comment',['comment'=>$reply,'isReply'=>true,])--}}
        {{--@empty--}}
        {{--@endforelse--}}
    </div>
</div>