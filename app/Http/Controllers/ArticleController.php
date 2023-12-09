<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index() {
        return view('main.welcome')->with('articles', DB::table('articles')->orderBy('data_create', 'desc')->simplePaginate(5));
    }

    // public function gallery($url) {
    //     return view('main.gallery')->with('picture', "/" . $url);
    // }

    public function createPage() {
        return view('main.createArticle');
    }

    public function create(Request $request) {
        $request->validate([
            'name' => 'required|min:3|max:10',
            'short_text' => 'required|min:5|max:150'
        ]);

        DB::table('articles')->insert([
            'name' => $request->name,
            'short_text' => $request->short_text,
        ]);

        return redirect('/');
    }

    public function updatePage($id) {
        return view('main.updateArticle')->with('article', DB::table('articles')->where('id', $id)->first());
    }

    public function update(Request $request) {
        $request->validate([
            'name' => 'required|min:3|max:10',
            'short_text' => 'required|min:5|max:150'
        ]);

        DB::table('articles')->where('id', $request->id)->update(['name' => $request->name, 'short_text' => $request->short_text]);

        return redirect('/');
    }

    public function delete($id) {
        DB::table('articles')->delete([
            'id' => $id
        ]);

        return redirect('/');
    }
}