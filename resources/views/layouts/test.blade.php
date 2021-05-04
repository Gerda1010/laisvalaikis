
<!DOCTYPE html>

<html>

<head>
    <title>Laisvalaikio IS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <script src="{{ asset('js/custom.js') }}" defer></script>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo asset('css/custom.css')?>" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

@if (count($errors) > 0)
    <div class="fixed-top messages" style="border-bottom: white">
        <div class="alert alert-danger">
            <p>Kažkas ne taip:</p>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
        @elseif ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div></div>
@endif

<wrapper class="d-flex flex-column">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{route('dashboard')}}">Pagrindinis<span class="sr-only">(current)</span></a>
            </li>


        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">

                <li class="nav-item">
                    <a class="nav-link" href="{{action('tournamentsController@index')}}">Turnyrai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{action('scheduleController@index')}}">Tvarkaraštis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{action('teamsController@index')}}">Komandos</a>
                </li>
                <li class="nav-item">

                    <a class="nav-link" href="{{action('profileController@index',Auth::user()->name)}}">Profilis</a>
                </li>
                @if(Auth::user()->is_admin)
                <li class="nav-item">
                    <a class="nav-link"  href="{{action('adminUsersController@index')}}">Naudotojai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"  href="{{action('adminObjectsController@index')}}">Objektai</a>
                </li>

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
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="horiz-align: right" v-pre>
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

            </ul>  </div> </div> </div>
   </nav>
<main >
    @yield('content')
</main>


{{--<footer>--}}
{{--    <div  class="tabcenter">--}}

{{--        <p>FOOTER</p>--}}

{{--    </div></footer>--}}

</wrapper>

</body>
</html>

