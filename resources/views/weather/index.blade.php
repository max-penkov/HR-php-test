@extends('layouts.app')

@section('content')
	<div class="links">
		{{ $weather->city }} - {{ $weather->state }} - {{ $weather->country }}
		<br>
		{{ $weather->latitude }},{{ $weather->longitude }}
		<br>
		@if (count($weather->forecast))
			<table class="table">
				<thead>
				<tr>
					<th scope="col"></th>
					<th scope="col">Погода</th>
					<th scope="col">Час</th>
					<th scope="col">Температура</th>
				</tr>
				</thead>
				<tbody>
				@foreach (array_slice($weather->forecast,0,24) as $f)
					<tr>
						<th scope="row">
							<img width=24 src="{{ $f->iconLink }}">
						</th>
						<td>{{ $f->description }}</td>
						<td>{{ Carbon\Carbon::createFromFormat("HmdY", $f->localTime) }}</td>
						<td> {{ $f->temperature }}&deg;</td>
					</tr>

				@endforeach
				</tbody>
			</table>
		@else
			<li>Извините, пока нет данных!</li>
		@endif

	</div>
@endsection