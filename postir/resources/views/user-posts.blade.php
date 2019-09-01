@extends('designs/postir')

@section('content')
	<h1>{{$username}}'s Posts</h1>
	@include('components/post-feed')
@endsection