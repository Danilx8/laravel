@extends('layout')
@section('content')
<form action="/articles/create" method="post">
    @csrf
    <div>
        <label for="name">Name</label>
        <input type="text" placeholder="Enter your article's name" name="name" required>

        <label for="short_text">Short text</label>
        <textarea name="short_text" placeholder="Enter your article's text" cols="30" rows="10"></textarea>
    </div>

    <div>
        <button type="submit">Submit</button>
    </div>
</form>
@endsection
