<?php

namespace App\Http\Controllers\API;

use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Notifications\ArticleNotifier;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Events\NewArticleEvent;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function retrieve() {
        $articles = DB::table('articles')->orderBy('data_create', 'desc')->simplePaginate(5);
        $currentPage = request('page') ? request('page'): 1;
        Cache::put('articles'.$currentPage, $articles, 3000);

        return response()->json([
            'articles' => $articles
        ]);
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
            NewArticleEvent::dispatch($article->name);
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

        return response($isSaved);
    }

    public function update(Request $request) {
        $this->authorize('update', Article::class);

        $request->validate([
            'name' => 'required|min:3|max:10',
            'short_text' => 'required|min:5|max:150'
        ]);

        $isUpdated = DB::table('articles')->where('id', $request->id)->update(['name' => $request->name, 'short_text' => $request->short_text]);
        Cache::flush();

        return response($isUpdated);
    }

    public function delete(Request $request) {
        $this->authorize('delete', Article::class);

        $isDeleted = DB::table('articles')->delete([
            'id' => $request->id
        ]);
        Cache::flush();

        return response($isDeleted);
    }
}
