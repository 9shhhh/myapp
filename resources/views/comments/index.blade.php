<div class="page-header">
    <h4>댓글</h4>
</div>

<div class="form__new__comment">
    @if($currentUser)
        @include('comments.partial.create')
    @else
        @include('comments.partial.login')
    @endif
</div>

<div class="list__comment">
    @forelse($comments as $comment)
        @include('comments.partial.comment',[
        'parentId'=>$comment->id,
        'isReply'=>false,
        'hasChild'=>$comment->replies->count(),
        'isTrashed'=>$comment->trashed(),
        ])
    @empty
    @endforelse
</div>

@section('script')
    @parent
    <script>
        $('.btn__delete_comment').on('click',function(e){
           var commentId = $(this).closest('.item__comment').data('id');
                articleId = $('article').data('id');

            if(confirm('댓글을 삭제합니다')){
                $.ajax({
                   type:'POST',
                   url:"/comments" + commentId,
                   data:{
                       _method:'DELETE'
                   }
                }).then(function () {
                    $('#comment_'+commentId).fadeOut(1000, function () {
                        $(this).remove();
                    });
                });
            }
        });

        $('.btn__vote__comment').on('click',function(e){
             var self = $(this),
                 commentId = self.closest('.item__comment').data('id');
             $.ajax({
                type:'POST',
                url:'/comments/' + commentId + '/votes',
                data:{
                    vote:self.data('vote')
                },
             }).then(function (data) {
                 self.find('span').html(data.value).fadeIn();
                 self.attr('disabled','disabled');
                 self.siblings().attr('disabled','disabled');
             });
        });
    </script>
@endsection