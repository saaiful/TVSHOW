<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TVS Downloader</title>
	<link rel="icon" type="image/png" href="{{ url('images/favicon.png') }}" />
	<link href="{{ url('css/slick.css') }}" rel="stylesheet">
	<link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ url('css/venobox.css') }}" rel="stylesheet">
	<link href="{{ url('css/style.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<!--[if IE 9]>
		<link href="css/ie9.css" rel="stylesheet">
	<![endif]-->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	</head>
	<body>

		<div class="wrapper">

			<div class="navbar" role="navigation">
				<div class="heading" style="height: 50px;"></div>
				<div class="container">
					<div class="navbar-header">
						<a href="{{ url('/') }}" class="logo" title="TV Show Downloader">
							<img src="{{ url('images/logo.svg') }}" alt="TV Show Downloader" style="height: 50px;">
						</a>
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar top-bar"></span>
							<span class="icon-bar middle-bar"></span>
							<span class="icon-bar bottom-bar"></span>
						</button>
					</div>
					<div class="navbar-collapse collapse">
						<ul id="menu-primary" class="nav navbar-nav">
							<li>
								<a href="{{ url('/') }}">Home</a>
							</li>
							<li>
								<a href="{{ url('/whats-new') }}">What's New</a>
							</li>
							<li class="dropdown">
								<a href="javascript:{};">Shows</a>
								<ul class="dropdown-menu">
									<li><a href="{{ url('show/create') }}">Add New Show</a></li>
									<li><a href="{{ url('show') }}">All Shows</a></li>
									<li><a href="{{ url('show/auto-download') }}">Auto Download</a></li>
									<li><a href="{{ url('show/update-all') }}">Update All</a></li>
								</ul>
							</li>
							@if(env('DOWNLOAD'))
							<li>
								<a href="{{ url('/downloading') }}">Downloading</a>
							</li>
							@endif
						</ul>
					</div>
				</div>
			</div>

			@yield('hero')

			@yield('content')

			<footer>
				<div class="container">
					<div class="row">
					<div class="copyright">
						<p>{{ date('Y') }} &copy; TVS Downloader / <a href="https://saiful.im/">Saiful Islam</a></p>
					</div>
				</div>
			</footer>
		</div>
		<script src="{{ url('js/jquery-2.2.4.min.js') }}"></script>
		<script src="{{ url('js/jquery-ui.min.js') }}"></script>
		<script src="{{ url('js/bootstrap.min.js') }}"></script>
		<script src="{{ url('js/headhesive.min.js') }}"></script>
		<script src="{{ url('js/matchHeight.min.js') }}"></script>
		<script src="{{ url('js/modernizr.custom.js') }}"></script>
		<script src="{{ url('js/slick.min.js') }}"></script>
		<script src="{{ url('js/venobox.min.js') }}"></script>
		<script src="https://use.fontawesome.com/4dfd2d448a.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.33.1/dist/sweetalert2.all.min.js"></script>
		<script src="{{ url('js/custom.js') }}"></script>
		@stack('script')
	</body>
</html>