@extends('layouts.app')

@section('content')
	<ul class="nav nav-tabs mb-3">
		<li class="nav-item"><a href="{{ route('order.newest') }}">Новые</a></li>
		<li class="nav-item active"><a href="{{ route('order.completed') }}">Выполненые</a></li>
		<li class="nav-item"><a href="{{ route('order.current') }}">Текущие</a></li>
		<li class="nav-item"><a href="{{ route('order.overtaken') }}">Просроченные</a></li>
	</ul>
	<orders></orders>
@endsection