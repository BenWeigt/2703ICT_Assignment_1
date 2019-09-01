@extends('designs/postir')

@section('content')
	<h1>Post Feed</h1>
	@include('components/post-create')
	@include('components/post-feed')
@endsection