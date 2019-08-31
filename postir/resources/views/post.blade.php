@extends('designs/postir')

@section('content')
	<div class="post">
		@if (substr($post->icon, 0, 21) !== 'data:image/png;base64')
			<div class="post-icon">{{$post->icon}}</div>
		@else
			<img class="post-icon" src="{{$post->icon}}">
		@endif
		<div class="post-comment-count">{{count($comments)}}</div>
		<div class="post-username">{{$post->username}}</div>
		<h3 class="post-title">{{$post->title}}</h3>
		<p class="post-content">{{$post->content}}</p>

		<div class="comments">
			@foreach ($comments as $comment)
				<div class="comment">
					<div class="post-username">{{$comment->username}}</div>
					<p class="post-content">{{$comment->content}}</p>
				</div>
			@endforeach
		</div>
	</div>

	<form method="post" action="{{REL_DIR}}/comments/create" style="max-width: 750px; margin: auto;">
		{{csrf_field()}}
		<input name="post_id" type="hidden" value="{{$post->id}}">
		<div class="form-group">
			<label for="new-post-username">Username</label>
			<input name="username" type="text" class="form-control" id="new-post-username" required>
		</div>
		<div class="form-group">
			<label for="new-post-content">What are your thoughts?</label>
			<textarea name="content" class="form-control" id="new-post-content" required></textarea>
		</div>
		<button type="submit" class="btn btn-primary" style="display: block; margin: auto;">Comment</button>
	</form>
@endsection