@extends('layout')
@section('content')
<form action={{"/articles/edit/" . $article->id}} method="post">
    @csrf
    @method('PUT')
    <div>
        <input type="text" name="id" value={{$article->id}} hidden>

        <label for="name">Name</label>
        <input type="text" placeholder="Enter your article's name" name="name" value={{$article->name}} required>

        <label for="short_text">Short text</label>
        <textarea name="short_text" placeholder="Enter your article's text" cols="30" rows="10">{{$article->short_text}}</textarea>
    </div>

    <div>
        <button type="submit">Submit</button>
    </div>
</form>
@endsection
