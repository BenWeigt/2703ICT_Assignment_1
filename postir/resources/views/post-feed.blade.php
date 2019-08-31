@extends('designs/postir')

@section('content')
	<form method="post" action="{{REL_DIR}}/posts/create" style="max-width: 750px; margin: auto;">
		{{csrf_field()}}
		<div class="form-group">
			<label for="new-post-username">Username</label>
			<input name="username" type="text" class="form-control" id="new-post-username" required>
		</div>
		<div class="form-group">
			<label for="new-post-title">Title</label>
			<input name="title" type="text" class="form-control" id="new-post-title" required>
		</div>
		<div class="form-group">
			<label for="new-post-content">Content</label>
			<textarea name="content" class="form-control" id="new-post-content" required></textarea>
		</div>
		<button type="submit" class="btn btn-primary" style="display: block; margin: auto;">Create Post</button>
	</form>

	<div class="posts">
		@foreach ($posts as $post)
			<div class="post" data-post-id="{{$post->id}}">
				@if (substr($post->icon, 0, 21) !== 'data:image/png;base64')
					<div class="post-icon">{{$post->icon}}</div>
				@else
					<img class="post-icon" src="{{$post->icon}}">
				@endif
				<div class="post-comment-count">{{$post->comment_count}}</div>
				<div class="post-username">{{$post->username}}</div>
				<h3 class="post-title">{{$post->title}}</h3>
				<p class="post-content">{{$post->content}}</p>
			</div>
		@endforeach
	</div>
	<script>
		let posts = document.querySelectorAll('.post');
		for (const post of posts) {
			post.addEventListener('click', ()=>{
				location.href = '{{REL_DIR}}/posts/'+post.dataset.postId;
			});
		}
	</script>
@endsection