@extends('layout')
@section('content')
<div class="container">
    <div class="alert-danger">
        @if ($errors->any())
        @foreach($errors->all() as $error)
        <ul>
            <li>{{$error}}</li>
        </ul>
        @endforeach
        @endif
    </div>

    <form action="/authenticate" method="post">
        @csrf
        <div>
            <label for="name">Name</label>
            <input type="text" placeholder="Enter your name" name="name" required>

            <label for="email">Email</label>
            <input type="email" placeholder="Enter your email" name="email" required>

            <label for="password">Password</label>
            <input type="password" placeholder="Enter your password" name="password" required>
        </div>

        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>
@endsection
