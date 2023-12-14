<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Mail\MailSender;
use App\Jobs\VeryLongJob;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function retrieve($article_id) {
        if (isset($_GET['notify'])) {
            auth()->user()->notifications->where('id', $_GET['notify'])->first()->markAsRead();
        }

        $comments =  DB::table('comments')->where('article_id', $article_id)->orderBy('created_at', 'desc')->get();
        Cache::rememberForever('CommentsOfArticle'.$article_id , function() use($comments) {
            return $comments;
        });

        return response()->json([
            'article_id' => $article_id,
            'comments' => $comments
        ]);
    }

    public function create(Request $request) {
        if(!Gate::allows('create comments')) {
            abort(403);
        }

        $request->validate([
            'body' => 'required'
        ]);

        $comment = new Comment();
        $comment->body = $request->body;
        $comment->article_id = $request->article_id;
        $comment->user_id = auth()->user()->id;
        $comment->created_at = date("Y-m-d H:i:s");
        $comment->updated_at = date("Y-m-d H:i:s");

        $isSaved = false;
        try {
            $isSaved = $comment->save();
            VeryLongJob::dispatch($comment->body);
        } catch(Exception $error) {
            report($error);
        }

        return response($isSaved);
    }

    public function update(Request $request) {
        $comment = DB::table('comments')->where('id', $request->id)->first();
        if(Gate::denies('edit comments') && Gate::denies("comment's author", $comment)) {
            abort(403);
        }

        $request->validate([
            'body' => 'required',
        ]);

        $isUpdated = DB::table('comments')->where('id', $request->id)->update([
            "body" => $request->body,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return response($isUpdated);
    }

    public function delete(Request $request) {
        $comment = DB::table('comments')->where('id', $request->id)->first();
        if(Gate::denies('delete comments') && Gate::denies("comment's author", $comment)) {
            abort(403);
        }

        $isDeleted = DB::table('comments')->where('id', $request->id)->delete([
            'id' => $request->id,
        ]);

        return response($isDeleted);
    }
}
