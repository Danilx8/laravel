@extends('layout')
@section('content')
<form action={{"/articles/comments/edit/" . $comment->id}} method="post">
    @csrf
    @method('PUT')
    <div class="container">
        <input type="text" name="id" value={{$comment->id}} hidden>
        <label for="body">Comment text</label>
        <textarea name="body" placeholder="Enter your comment's text" cols="30" rows="5">{{$comment->body}}</textarea>
        <button type="submit">Submit</button>
    </div>
</form>
@endsection
