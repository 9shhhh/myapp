<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ArticlesRequest;
use Illuminate\Support\Facades\DB;

class ArticlesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }

    public function index($slug = null) {
        $query = $slug ? \App\Tag::whereSlug($slug)->firstOrFail()->articles() : new \App\Article;
        $articles = $query->latest()->paginate(3);
        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        $article = new \App\Article;
        return view('articles.create', compact('article'));
    }

    public function store(ArticlesRequest $request)
    {
        $article = $request->user()->articles()->create($request->all());

        if (! $article) {
            flash()->error('작성하신 글을 저장하지 못했습니다.');
            return back()->withInput();
        }

        $article->tags()->sync($request->input('tags'));


//        if ($request->hasFile('files')) {
//            $files = $request->file('files');
//
//            foreach ($files as $file) {
//                $filename = str_random().filter_var($file->getClientOriginalName(),FILTER_SANITIZE_URL);
//
//                $article->attachments()->create([
//                    'filename' => $filename,
//                    'bytes' => $file->getSize(),
//                    'mime' => $file->getClientMimeType()
//                ]);
//
//                $file->move(attachments_path(), $filename);
//            }
//        }


        event(new \App\Events\ArticlesEvent($article));
        flash()->success('작성하신 글이 저장되었습니다.');
        return redirect(route('articles.index'));
    }

    public function show(\App\Article $article)
    {
        $comments = $article->comments()->with('replies')->whereNull('parent_id')->latest()->get();
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
