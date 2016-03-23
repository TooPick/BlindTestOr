<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="../../assets/ico/favicon.png">

        <title>BlindTestOr - @yield('title')</title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="{{ URL::asset('css/theme.css') }}">

        <!-- Custom styles for this template -->
        <link rel="stylesheet" href="{{ URL::asset('css/justified-nav.css') }}">

        <!-- Custom styles for this template -->
        <link rel="stylesheet" href="{{ URL::asset('css/signin.css') }}">

        <script src="http://code.jquery.com/jquery.js"></script>

        @yield('stylesheets')

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="../../assets/js/html5shiv.js"></script>
        <script src="../../assets/js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
  
        <div class="container"> 

            <nav class="navbar navbar-default" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav nav-justified">
                        <li><a href="{{ URL::route('home') }}">Accueil</a></li>
                        @if (Auth::guest())
                            <li><a href="{{ url('/register') }}">Inscription</a></li>
                        @endif
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Jeu  <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ URL::route('categories', 'solo') }}">Solo</a></li>
                                <li><a href="{{ URL::route('categories', 'multi') }}">Multijoueur</a></li>
                            </ul>
                        </li>
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Connexion</a></li>
                        @else
                            <li><a href="{{URL::route('profil')}}">Mon compte</a></li>
                            <li><a href="{{ url('/logout') }}">Déconnexion</a></li>

                        @endif
                    </ul>
                </div>
            </nav>

            @yield('content')

            <!-- Site footer -->
            <div class="footer">
                <p>&copy; BlindTestOr 2016</p>
                @if(!Auth::guest())
                    @if (Auth::user()->admin == 1)
                        <p><a href="{{ URL::route('admin_home') }}">Administration</a></p>
                    @endif
                @endif
            </div>

        </div> <!-- /container -->


        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>

        @yield('javascripts')
        
    </body>
</html>