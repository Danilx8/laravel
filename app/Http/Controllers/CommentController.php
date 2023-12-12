<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailSender;
use App\Jobs\VeryLongJob;

class CommentController extends Controller
{
    public function index($article_id) {
        if (isset($_GET['notify']))
            auth()->user()->notifications->where('id', $_GET['notify'])->first()->markAsRead();

        return view('comments.current')
            ->with('comments', DB::table('comments')->where('article_id', $article_id)->orderBy('created_at', 'desc')->get())
            ->with('article_id', $article_id);
    }

    public function createIndex($article_id) {
        return view('comments.create')
                ->with('article_id', $article_id);
    }

    public function create(Request $request) {
        if(!Gate::allows('create comments')) {
            abort(403);
        }

        $request->validate([
            'body' => 'required'
        ]);

        DB::table('comments')->insert([
            'body' => $request->body,
            'article_id' => $request->article_id,
            'user_id' => auth()->user()->id,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        $comment = new Comment();
        $comment->body = $request->body;
        $comment->article_id = $request->article_id;
        $comment->user_id = auth()->user()->id;

        VeryLongJob::dispatch($comment->body);
        return redirect('/articles/comments/' . $request->article_id);
    }

    public function editIndex($id) {
        return view('comments.edit')->with('comment', DB::table('comments')->where('id', $id)->first());
    }

    public function edit(Request $request) {
        $comment = DB::table('comments')->where('id', $request->id)->first();
        if(Gate::denies('edit comments') && Gate::denies("comment's author", $comment)) {
            abort(403);
        }

        $request->validate([
            'body' => 'required',
        ]);

        DB::table('comments')->where('id', $request->id)->update([
            "body" => $request->body,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect('/articles/comments/' . $comment->article_id);
    }

    public function deleteIndex($id) {
        return view('comments.delete')->with('comment', DB::table('comments')->where('id', $id)->first());
    }

    public function delete(Request $request) {
        $comment = DB::table('comments')->where('id', $request->id)->first();
        if(Gate::denies('delete comments') && Gate::denies("comment's author", $comment)) {
            abort(403);
        }

        DB::table('comments')->where('id', $request->id)->delete([
            'id' => $request->id,
        ]);

        return redirect('/articles/comments/' . $request->article_id);
    }
}
