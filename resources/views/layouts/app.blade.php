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

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css">
	<link rel="stylesheet" href="{{ url('css/all.css') }}?hash={{ time() }}">
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
				@if (!preg_match('~^\/admin\/.*~', $_SERVER['REQUEST_URI']))
					<a class="navbar-brand" href="{{ url('/') }}">
						<img src="/img/logo.png" title="Prague Rainbow Spring">
					</a>
				@endif
            </div>

            <div class="collapse navbar-collapse col-md-offset-3" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/') }}">Registration</a></li>
					<li><a href="http://www.praguerainbow.eu/">Back to Prague Rainbow Spring</a></li>
                    @if (!Auth::guest() && Auth::user()->isAdmin())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Admin <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/admin/registration/overview">Registrations</a></li>
								<li><a href="/admin/users">Users</a></li>
								<li><a href="/admin/payment/list">Payments</a></li>
								<li><a href="/admin/exports">Exports</a></li>
								<li><a href="/admin/incomes">Incomes</a></li>
								{{--<li><a href="/admin/mails">Mails</a></li>--}}
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
    <script src="{{ url('js/app.js') }}?hash={{ time() }}"></script>

    <footer class="footer">
		<div class="container-fluid live-it-up"></div>
		<div class="container-fluid bottom-link">
			<div class="container">
				<div class="row">
					<div class="col-md-6 contact">
						<p>Do you have problems with registration form? Contact us <a href="mailto: form@praguerainbow.eu">form@praguerainbow.eu</a></p>
					</div>
					<div class="col-md-6 icons text-right">
						<a href="http://www.alcedopraha.cz/" target="_blank" class="alcedo" title="Alcedo Praha"></a>
						<a href="http://aquamen.cz" target="_blank" class="aquamen" title="Aquamen"></a>
						<a href="https://www.facebook.com/Prague-Rainbow-Spring-404635169567940/" target="_blank" class="fb" title="Facebook"></a>
					</div>
				</div>
			</div>
		</div>
    </footer>

</body>
</html>
