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

    public function index($slug = null) {
        $query = $slug ? \App\Tag::whereSlug($slug)->firstOrFail()->articles() : new \App\Article;
        $articles = $query->latest()->paginate(3);
        return view('articles.index', compact('articles'));
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
        $article = $request->user()->articles()->create($request->all());

        if (! $article) {
            flash()->error('작성하신 글을 저장하지 못했습니다.');
            return back()->withInput();
        }
        $article->tags()->sync($request->input('tags'));
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
        $article->update($request->all());
        $article->tags()->sync($request->input('tags'));
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
