<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/welcome.css')}}">
    <title>Document</title>
</head>
<body>
    <header>
        <a class="home" href="/">Главная</a>
        <nav class="nav-top">
            <a href="/contacts">Контакты</a>
            <a href="/about">О нас</a>
            @guest
                <a href="/authenticate">Войти</a>
                <a href="/register">Зарегистрироваться</a>
            @endguest
            @auth
                <a href="/logout">Выйти</a>
                Добро пожаловать, {{auth()->user()->name}}
            @endauth
        </nav>
        <div clas="inline">

        </div>
    </header>
    @yield('content')
    <footer>
        <p>Луговских Данил Викторович 221-323</p>
    </footer>
</body>
</html>
