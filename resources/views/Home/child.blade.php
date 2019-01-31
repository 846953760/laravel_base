@extends('Home.index')

@section('title','这是title')

@section('sidebar')
	@parent
	<p>laravel</p>
@endsection

@section('content')
	<p>这是content</p>
@endsection