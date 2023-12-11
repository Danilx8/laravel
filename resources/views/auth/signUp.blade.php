@extends('layout')
@section('content')
<div class="container">
    <h2>Sign up</h2>
    <form action='/register' method="POST">
        @csrf
        <div>
            <label for="email">Email</label>
            <input type="email" placeholder="Enter your email" name="email" required>
            <label for="name">Name</label>
            <input type="name" placeholder="Enter your name" name="name" required>
            <label for="password">Password</label>
            <input type="password" placeholder="Enter your password" name="password" required>
        </div>

        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>
@endsection
