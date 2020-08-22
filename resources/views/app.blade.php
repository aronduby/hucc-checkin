<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>HUCC Checkin</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <link rel="stylesheet" href="/css/app.css" />

</head>
<body>
    <nav class="px-1">
        <div class="nav-wrapper">
            @auth
                <span>Hi, {{Auth::user()->name}}</span>
            @endauth
            <ul class="right">
                @yield('nav')
            </ul>
        </div>
    </nav>


    <article class="container">
        @yield('content')
    </article>

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <script src="/js/app.js"></script>
</body>
</html>
