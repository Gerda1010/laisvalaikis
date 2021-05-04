
<!DOCTYPE html>

<html>

<head>
    <title>Laisvalaikio IS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo asset('custom.css')?>" type="text/css">

</head>
<body>

    @if (count($errors) > 0)
        <div class="fixed-top messages" style="border-bottom: white">
        <div class="alert alert-danger">
            <p>Trūksta privalomos informacijos:</p>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
        @elseif ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div></div>
        @endif


<nav class="navbar navbar-inverse">

    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Logo</a>
        </div>

        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">



                <li class="active"><a href="{{route('dashboard')}}">Pagrindinis</a></li>
                <li><a href="{{action('tournamentsController@index')}}">Turnyrai</a></li>
                <li><a href="{{action('scheduleController@index')}}">Tvarkaraštis</a></li>
                <li><a href="{{action('teamsController@index')}}">Komandos</a></li>
                <li><a href="{{action('profileController@index')}}">Profilis</a></li>

                @if(Auth::user()->is_admin){

                <li><a href="{{action('adminUsersController@index')}}">Naudotojai</a></li>
                <li><a href="{{action('adminObjectsController@index')}}">Objektai</a></li>
                @endif


            </ul>
            <ul class="nav navbar-nav navbar-right">
            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @endif

                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest

            </ul>
        </div>
    </div>
</nav>
<main class="py-4">
    @yield('content')
</main>


<footer class="container-fluid text-center">
    <p class="span12" style="float: none; margin: 0 auto;">Footer Text</p>
</footer>

</body>
</html>

