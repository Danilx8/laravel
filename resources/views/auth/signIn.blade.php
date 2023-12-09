@extends('layout')
@section('content')
<form action="/registration" method="post">
    @csrf
    <div>
        <label for="username">Name</label>
        <input type="text" placeholder="Enter your name" name="username" required>

        <label for="email">Email</label>
        <input type="email" placeholder="Enter your email" name="email" id="" required>

        <label for="password">Password</label>
        <input type="password" placeholder="Enter your password" name="password" id="" required>
    </div>

    <div>
        <button type="submit">Submit</button>
    </div>
</form>
@endsection
