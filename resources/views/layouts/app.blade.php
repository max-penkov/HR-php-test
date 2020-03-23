<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Заказы') }}</title>

	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div>
	<nav class="navbar navbar-default navbar-static-top">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="{{ url('/') }}">ТЗ</a>
			</div>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="nav navbar-nav">
					<li><a href="{{ route('order.newest') }}">Заказы <span
								class="sr-only">(current)</span></a></li>
					<li><a href="{{ route('order.products') }}">Продукты</a></li>
{{--					<li><a class="nav-link" href="{{ route('weather') }}">Погода</a></li>--}}
				</ul>
			</div>
		</div>
	</nav>

	<main id="app" class="app-content py-3">
		<div class="container">
			@yield('content')
			<flash message="{{ session('flash') }}"></flash>
		</div>
	</main>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
