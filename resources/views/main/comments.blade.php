@extends('layout')
@section('content')
<div class="container">
    <h2>Comments.</h2>
    <a href="/">Назад</a>
    @foreach ($comments as $comment)
        <div>
            <p>{{$comment->body}}</p>
            <small>{{$comment->created_at}}</small>
        </div>
    @endforeach
</div>
@endsection
