@extends('layout')
@section('content')
<form action={{"/articles/comments/create/"}} method="post">
    @csrf
    <div class="container">
        <input type="number", name="article_id", value={{$article_id}} hidden>
        <label for="body">Comment text</label>
        <textarea name="body" placeholder="Enter your comment's text" cols="30" rows="5"></textarea>
    </div>

    <div>
        <button type="submit">Submit</button>
    </div>
</form>
@endsection
