@extends('designs/postir')

@section('content')
	<h1>Recent Posts (last 7 days)</h1>
	@include('components/post-create')
	@include('components/post-feed')
@endsection