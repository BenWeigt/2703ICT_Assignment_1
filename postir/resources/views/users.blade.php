@extends('designs/postir')

@section('content')
	<div class="users">
		@foreach ($users as $user)
			<div class="user" data-user-id="{{$user->id}}">
				<div class="user-username">{{$user->username}}</div>
				<div class="user-post-count">{{$user->post_count}}</div>
			</div>
		@endforeach
	</div>
	<script>
		let users = document.querySelectorAll('.post');
		for (const user of users) {
			user.addEventListener('click', ()=>{
				location.href = '{{REL_DIR}}/users/'+user.dataset.userId;
			});
		}
	</script>
@endsection