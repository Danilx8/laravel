@extends('layout')
@section('content')
<div class="container">
    <h2>Comments.</h2>
        <a href="/">Назад</a>
        @auth
            <a href={{"/articles/comments/create/" . $article_id}}>Оставить комментарий</a>
        @endauth
    @foreach ($comments as $comment)
        <div>
            <p>{{$comment->body}}</p>
            <small>{{$comment->created_at}}</small>
        @can('edit comments')
            <a id="edit" href={{"/articles/comments/edit/" . $comment->id}}>Edit</a>
        @elseif (auth()->check() && $comment->user_id == auth()->user()->id)
            <a id="edit" href={{"/articles/comments/edit/" . $comment->id}}>Edit</a>
        @endcan
        @can('delete comments')
            <a id="delete" href={{"/articles/comments/delete/" . $comment->id}}>Delete</a>
        @elseif (auth()->check() && $comment->user_id == auth()->user()->id)
            <a id="delete" href={{"/articles/comments/delete/" . $comment->id}}>Delete</a>
        @endcan
    </div>
    @endforeach
</div>
@endsection
