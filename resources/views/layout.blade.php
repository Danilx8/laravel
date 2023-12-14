<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/welcome.css')}}">
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
                <div class="greet">
                    Добро пожаловать, {{auth()->user()->name}}
                </div>
                <a href="/logout">Выйти</a>
                <li>
                    <a href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                        New articles: {{auth()->user()->unreadNotifications->count()}}
                    </a>
                    <div class="dropdown-menu">
                        @foreach (auth()->user()->unreadNotifications as $notification)
                            <a class="dropdown-item" href="/articles/comments/{{$notification->data['article']['id']}}?notify={{$notification->id}}">
                                {{$notification->data['article']['name']}}
                            </a>
                        @endforeach
                    </div>
                </li>
            @endauth
        </nav>
        <div clas="inline">

        </div>
    </header>
    <div id="app">
        <App/>
    </div>
    @yield('content')
    <footer>
        <p>Луговских Данил Викторович 221-323</p>
    </footer>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
