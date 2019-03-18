<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

/***********************************************************

 * @params Requests, Articles

 * @description 댓글 컨트롤러

 * @method

 * @return redirect

 ***********************************************************/

class CommentsController extends Controller
{
    // 컨트롤러 생성자 함수
    public function __construct()
    {
        // 사용자 인증
        $this->middleware('auth');
    }
    // 댓글 저장
    public function store(CommentRequest $request, \App\Article $article)
    {
        $comment = $article->comments()->create(array_merge(
           $request->all(),['user_id'=>$request->user()->id]
        ));

        flash()->success('작성하신 댓글을 저장했습니다.');
        return redirect(route('articles.show',$article->id).'#comment_'.$comment->id);
    }
    // 댓글 수정
    public function update(CommentRequest $request, \App\Comment $comment)
    {
        $comment->update($request->all());

        return redirect(route('articles.show',$comment->commentable()->id).'#comment_'.$comment->id);
    }

    // 댓글 삭제
    public function destory(\App\Comment $comment)
    {
        $comment->delete();

        return response()->json([],204);
    }

    public function vote(Request $request, \App\Comment $comment)
    {
        // 유효성 체크
        $this->validate($request,[
           'vote'=>'required|in:up,down',
        ]);
        // 같은 글에 두번 투표 하지 못하게 방지.
        if($comment->votes()->whereUserId($request->user()->id)->exists()){
            return response()->json(['error'=>'already_voted'],409);
        }
        // 투표한 값이 up 인지 아닌지 체크
        $up = $request->input('vote') == 'up' ? true : false;
        // 투표 데이터 DB에 반영하기
        $comment->votes()->create([
            'user_id' => $request->user()->id,
            'up' => $up,
            'down' => ! $up,
            'voted_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
    }
}
