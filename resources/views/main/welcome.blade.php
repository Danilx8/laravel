@extends('layout')
@section('content')
<div class="container">
    <h1>Lorem ipsum dolor sit amet.</h1>
    @role('admin')
        <a href="/articles/create">Создать новую статью</a>
    @endrole
    @foreach ($articles as $article)
        <div>
            <h3>{{$article->name}}</h3>
            <p>{{$article->short_text}}</p>
            {{-- <a href={{"/gallery/" . $article['full_image']}}>
                <img src={{$article['preview_image']}} alt="">
            </a> --}}
            <small>{{$article->data_create}}</small>
            @role('admin')
                <a id="edit" href={{"/articles/edit/" . $article->id}}>Edit</a>
                <a id="delete" href={{"/articles/delete/" . $article->id}}>Delete</a>
            @endrole
            <a id="comments" href={{"/articles/comments/" . $article->id}}>Comments</a>
        </div>
    @endforeach
    {{$articles->links()}}
</div>
@endsection
