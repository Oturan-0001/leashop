<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @yield('meta_tags')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">


</head>
<body>
    
<nav>
    <div class="nav">
        
        <a class="leashop" href="/">Leashop</a>
        
        @guest
        <div class="connexion">
            <a class="btn btn-outline" href="{{ route('register') }}">Inscription</a>
            <a class="btn btn-dark" href="{{ route('login') }}">Connexion</a>
        </div>
        @endguest

        @auth
        <div class="connexion">
            <a class="btn btn-dark" href="{{ route('dashboard') }}">Mon Espace</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-danger" type="submit">Déconnexion</button>
            </form>
        </div>
        @endauth

    </div>
</nav>
    <br>
    <br>




    @yield('content')



</body>
</html>