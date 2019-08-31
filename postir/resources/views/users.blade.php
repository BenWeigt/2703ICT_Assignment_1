@extends('designs/postir')

@section('content')
	<div class="users">
		@foreach ($users as $user)
			<div class="user">
				<div class="user-username">{{$user->username}}</div>
				<div class="user-post-count">{{$user->post_count}}</div>
			</div>
		@endforeach
	</div>
@endsection