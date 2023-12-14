<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Notifications\ArticleNotifier;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Events\NewArticleEvent;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    public function index() {
        $articles = DB::table('articles')->orderBy('data_create', 'desc')->simplePaginate(5);
        $currentPage = request('page') ? request('page'): 1;
        Cache::put('articles'.$currentPage, $articles, 3000);

        return view('main.welcome')->with('articles', $articles);
    }

    // public function gallery($url) {
    //     return view('main.gallery')->with('picture', "/" . $url);
    // }

    public function createPage() {
        return view('main.createArticle');
    }

    public function create(Request $request) {
        $this->authorize('create', Article::class);

        $request->validate([
            'name' => 'required|min:3|max:150',
            'short_text' => 'required|min:5|max:150'
        ]);

        DB::table('articles')->insert([
            'name' => $request->name,
            'short_text' => $request->short_text,
        ]);

        $article = new Article;
        $article->name = $request->name;
        $article->short_text = $request->short_text;
        $article->created_at = date("Y-m-d H:i:s");
        $article->updated_at = date("Y-m-d H:i:s");
        $article->data_create = date("Y-m-d H:i:s");
        $isSaved =  $article->save();

        if($isSaved) {
            NewArticleEvent::dispatch($request->name);
            $keys = DB::table('cache')->where('key', 'regexp', 'laravel_cache_articles:*[0-9]')->get();
            foreach ($keys as $key){
               Cache::forget($key->key);
            }
        }

        $users = User::all();
        foreach($users as $user){
            if ($user->id != auth()->user()->id) {
                Notification::send($user, new ArticleNotifier($article));
            }
        }

        return redirect('/');
    }

    public function updatePage($id) {
        return view('main.updateArticle')->with('article', DB::table('articles')->where('id', $id)->first());
    }

    public function update(Request $request) {
        $this->authorize('update', Article::class);

        $request->validate([
            'name' => 'required|min:3|max:10',
            'short_text' => 'required|min:5|max:150'
        ]);

        DB::table('articles')->where('id', $request->id)->update(['name' => $request->name, 'short_text' => $request->short_text]);
        Cache::flush();
        return redirect('/');
    }

    public function deletePage($id) {
        return view('main.deleteArticle')->with('article', DB::table('articles')->where('id', $id)->first());
    }

    public function delete(Request $request) {
        $this->authorize('delete', Article::class);

        DB::table('articles')->delete([
            'id' => $request->id
        ]);
        Cache::flush();
        return redirect('/');
    }
}
