<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Registration - Rainbow Prague Spring</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css">

    <style>

        html {
            position: relative;
            min-height: 100%;
        }

        body {
			font-family: 'Lato', serif;
            margin-bottom: 100px;
			background-color: #F2F2F2;
        }

        body > div.container {
            padding-top: 30px;
        }

        footer.footer {
            z-index: -1;
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 125px;
			background-color: #1A1A1A;
        }

		footer.footer .live-it-up {
			height: 65px;
			background-image: url('/img/live-it-up.png');
			background-repeat: no-repeat;
			background-position: 60% 10px;
			background-color: #F2F2F2;
		}
		footer.footer .icons {
			background-image: url('/img/color-link-bottom.png');
			background-repeat: repeat-x;
			background-position: center top;
			background-color: #1A1A1A;
		}

        .fa-btn {
            margin-right: 6px;
        }

        .navbar-default {
            background-color: transparent;
            border: none;
        }

        .panel-default > .panel-heading {
            background-image: url('/img/bottom.png');
            background-repeat: no-repeat;
            background-position: -1186px bottom;
            color: white;
            font-weight: bold;
        }

        .panel {
            background-color: rgba(255, 255, 255, 0.85);
        }

        #admin-content {
            background-color: rgba(255, 255, 255, 0.85);
        }

		#top-color-link {
			height: 21px;
			background-image: url('/img/color-link-top.png');
			background-position: center;
		}

		.footer .icons a.alcedo {
			background-image: url(/img/icon/alcedo.png);
			background-size: 40px auto;
		}
		.footer .icons a.aquamen {
			background-image: url(/img/icon/aquamen.png);
			background-size: 40px auto;
		}
		.footer .icons a.fb {
			background-image: url(/img/icon/fb.png);
			background-size: 40px auto;
		}
		.footer .icons a:hover {
			opacity: 1;
		}
		.footer .icons a {
			display: inline-block;
			width: 47px;
			height: 47px;
			background-color: transparent;
			background-repeat: no-repeat;
			background-size: auto;
			background-position: center center;
			position: relative;
			top: 9px;
			margin: 0 3px;
			opacity: .6;
			transition: all .25s linear;
		}

		.navbar-brand img {
			width: 75px;
			position: relative;
			top: -41px;
		}
		@media (min-width: 768px) {
			.navbar-brand img {
				width: inherit;
				position: relative;
				top: -60px;
			}
		}
		.from-note {
			color: #7f7f7f;
		}

    </style>
</head>
<body id="app-layout">
	<div class="container-fluid" id="top-color-link"></div>

    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{--Prague Rainbow Spring--}}
					<img src="img/logo.png">
                </a>
            </div>

            <div class="collapse navbar-collapse col-md-offset-3" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/personal') }}">Registration</a></li>
                    @if (!Auth::guest() && Auth::user()->isAdmin())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Admin <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/admin/registrations">Registrations</a></li>
                                <li><a>Badminton</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a>Payments</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')


    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    {{--<script src="{{ elixir('js/app.js') }}"></script>--}}
    <script src="{{ url('js/app.js') }}"></script>

    <footer class="footer">
		<div class="container-fluid live-it-up">
		</div>
		<div class="container-fluid icons text-right">
			<div class="container">
				<a href="http://www.alcedopraha.cz/" target="_blank" class="alcedo" title="Alcedo Praha"></a>
				<a href="http://aquamen.cz" target="_blank" class="aquamen" title="Aquamen"></a>
				<a href="https://www.facebook.com/Prague-Rainbow-Spring-404635169567940/" target="_blank" class="fb" title="Facebook"></a>
			</div>
		</div>
    </footer>

</body>
</html>
