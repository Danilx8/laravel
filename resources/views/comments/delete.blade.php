@extends('layout')
@section('content')
<form action={{"/articles/comments/delete/" . $comment->id}} method="post">
    @csrf
    @method('DELETE')
    <div class="container">
        <input type="text" name="id" value={{$comment->id}} hidden>
        <input type="text" name="article_id" value={{$comment->article_id}} hidden>
        <label for="body">Comment text</label>
        <textarea name="body" placeholder="Enter your comment's text" cols="30" rows="5" disabled>{{$comment->body}}</textarea>
    </div>

    <div>
        <button type="submit">Submit</button>
    </div>
</form>
@endsection
