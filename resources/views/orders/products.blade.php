@extends('layouts.app')

@section('content')

	<products :vendors="{{$vendors}}"></products>
@endsection