<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function index($id) {
        return view('main.comments')->with('comments', DB::table('comments')->where('article_id', $id)->get());
    }
}
