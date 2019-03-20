<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\ArticlesController as ParentController;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticlesController extends ParentController
{
    // 부모 컨트롤러에서 auth 미들웨어를 쓰고있어서, 무효화 시키기 위해 빈 생성자 선언.
    public function __construct()
    {
        // 부모 컨트롤러 생성사 사용
        parent::__construct();
        // 부모컨트롤러의 auth 미들웨어 무효화
        $this->middleware = [];
        // 새로 만든 http 무상태 기본인증 미들웨어 적용
        $this->middleware('auth.basic.once',['except'=>['index','show','tags']]);
    }

    protected function respondCreated(\App\Article $article)
    {
        return response()->json(
          ['success'=>'created'],
          201,
          ['Location'=>'생성한_리소스_상세보기_API_엔드포인트'],
          JSON_PRETTY_PRINT
        );
    }

    protected function respondCollection(LengthAwarePaginator $articles)
    {
        return $articles->toJson(JSON_PRETTY_PRINT);
    }

    public function tags()
    {
        return \App\Tag::all();
    }
}
