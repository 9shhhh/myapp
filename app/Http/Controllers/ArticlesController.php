<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ArticlesRequest;
use Illuminate\Support\Facades\DB;

class ArticlesController extends Controller implements Cacheable
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth',['except'=>['index','show']]);
    }

    public function cacheTags()
    {
        return 'articles';
    }

    public function index($slug = null,Request $request) {
        $cachekey = cache_key('articles.index');

                $query = $slug ? \App\Tag::whereSlug($slug)->firstOrFail()->articles() : new \App\Article;
        $query = $query->orderBy(
          $request->input('sort','created_at'),
          $request->input('order','desc')
        );
        if($keyword = request()->input('q')){
            $raw = 'MATCH(title,content) AGAINST(? IN BOOLEAN MODE)';
            $query = $query->whereRaw($raw,[$keyword]);
        }
//        $articles = $query->latest()->paginate(3);
        // 캐싱
        $articles = $this->cache($cachekey, 5, $query, 'paginate', 3);

        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        $article = new \App\Article;
        return view('articles.create', compact('article'));
    }

    public function store(ArticlesRequest $request)
    {
        // 이메일 전송 여부 확인
        $payload = array_merge($request->all(),[
           'notification'=>$request->has('notification'),
        ]);

        $article = $request->user()->articles()->create($payload);

        if (! $article) {
            flash()->error('작성하신 글을 저장하지 못했습니다.');
            return back()->withInput();
        }
        // 태그 싱크
        $article->tags()->sync($request->input('tags'));

        event(new \App\Events\ArticlesEvent($article));
        event(new \App\Events\ModelChanged(['articles']));
        flash()->success('작성하신 글이 저장되었습니다.');
        return redirect(route('articles.index'));
    }

    public function show(\App\Article $article)
    {
        $article->view_count += 1;
        $article->save();
        $comments = $article->comments()->with('replies')->withTrashed()->
        whereNull('parent_id')->latest()->get();
        return view('articles.show',compact('article','comments'));
    }

    public function edit(\App\Article $article)
    {
        $this->authorize('update',$article);
        return view('articles.edit',compact('article'));
    }

    public function update(Request $request, \App\Article $article)
    {
        $this->authorize('update', $article);
        $article->update($request->all());
        $article->tags()->sync($request->input('tags'));

        return redirect(route('articles.show', $article->id));
    }

    public function destroy(Request $request, \App\Article $article)
    {
        $this->authorize('delete',$article);
        $article->delete();
        return response()->json([],204);
    }
}
