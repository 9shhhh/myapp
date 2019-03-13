<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ArticlesRequest;
use Illuminate\Support\Facades\DB;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }

    public function index()
    {
        //
//        return __METHOD__.'은(는)Article 컬렉션을 조회합니다.';
          $articles = \App\Article::latest()->paginate(3);
//          dd(view('articles.index',compact('articles'))->render());
//        $articles->load('user');

        return view('articles.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $article = new \App\Article;
        return view('articles.create',compact('article'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticlesRequest $request)
    {
//        $article = \App\User::find(1)->articles()->create($request->all());
        $article = $request->user()->articles()->create($request->all());

        if (! $article) {
            flash()->error('작성하신 글을 저장하지 못했습니다.');
            return back()->withInput();
        }
        event(new \App\Events\ArticlesEvent($article));
        flash()->success('작성하신 글이 저장되었습니다.');
        return redirect(route('articles.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Article $article)
    {
//       echo $foo;
//       return __METHOD__ . '은(는)다음 기본 키를 가진 Article 모델을 조회 합니다.:'.$id;
//        $article = \App\Article::findOrFail($id);
//        dd($article);
//        return $article->toArray();

//        debug($article->toArray());
        return view('articles.show',compact('article'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(\App\Article $article)
    {
        $this->authorize('update',$article);
        return view('articles.edit',compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, \App\Article $article)
    {
        $this->authorize('update', $article);
        $article->update($request->all());

        return redirect(route('articles.show', $article->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, \App\Article $article)
    {
        $this->authorize('delete',$article);
        $article->delete();
        return response()->json([],204);
    }
}
