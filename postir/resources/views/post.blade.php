@extends('designs/postir')

@section('content')
	<h1>{{$post->username}}'s Post</h1>
	{{-- Verbose Post display --}}
	<div class="post fullpage">
		{{-- The Post icon supports two types: a single grapheme emoji, or a base64 encoded image url. --}}
		@if (substr($post->icon, 0, 21) !== 'data:image/png;base64')
			<div class="post-icon">{{$post->icon}}</div> {{-- emoji --}}
		@else
			<img class="post-icon" src="{{$post->icon}}"> {{-- base64 data url --}}
		@endif
		{{-- Post count --}}
		<div class="post-comment-count">{{count($comments)}}</div>
		{{-- Post edit (js hooked) --}}
		<div id="post-edit"></div>
		<script>
			(()=>{
				document.getElementById('post-edit').addEventListener('click', ()=>{
					document.getElementById('post-body-edit').style.display = 'block';
					document.getElementById('post-body').style.display = 'none';
				});
			})();
		</script>

		{{-- Post delete --}}
		<div class="post-remove" onclick="document.getElementById('post-remove').submit()"></div>
		<form id="post-remove" method="post" action="{{REL_DIR}}/posts/delete" style="display: none">
			{{csrf_field()}}
			<input name="id" type="hidden" value="{{$post->id}}">
		</form>

		{{-- Post body --}}
		<div id="post-body">
			<div class="post-username">{{$post->username}}</div>
			<h3 class="post-title">{{$post->title}}</h3>
			<p class="post-content">{{$post->content}}</p>
		</div>
		{{-- Post body edit --}}
		<form id="post-body-edit" method="post" action="{{REL_DIR}}/posts/edit" style="display: none">
			{{csrf_field()}}
			<input name="id" type="hidden" value="{{$post->id}}">
			<div class="form-group">
				<input name="username" type="text" class="form-control" placeholder="{{$post->username}}" value="{{$post->username}}" required>
			</div>
			<div class="form-group">
				<input name="title" type="text" class="form-control" placeholder="{{$post->title}}" value="{{$post->title}}" required>
			</div>
			<div class="form-group">
				<textarea name="content" class="form-control" required>{{$post->content}}</textarea>
			</div>
			<button type="submit" class="btn btn-primary" style="display: block; margin: auto;">Update</button>
		</form>

		{{-- Comment feed --}}
		<div class="comments">
			@foreach ($comments as $comment)
				{{-- Comment --}}
				<div class="comment">
					{{-- Comment delete (js hooked) --}}
					<div class="comment-remove" data-comment-id="{{$comment->id}}"></div>
					{{-- Comment body --}}
					<div class="comment-username">{{$comment->username}}</div>
					<p class="comment-content">{{$comment->content}}</p>
				</div>
			@endforeach

			{{-- Comment delete handler --}}
			{{-- We could include an instance of this form for every comment, but hooking them leads to a cleaner dom --}}
			<form method="post" action="{{REL_DIR}}/comments/delete" style="display: none">
				{{csrf_field()}}
				<input id="remove-comment-id" name="id" type="hidden">
			</form>
			<script>
				(()=>{
					const commentRemovers = document.querySelectorAll('.comment-remove'),
					      input = document.getElementById('remove-comment-id');
					for (const commentRemover of commentRemovers) {
						commentRemover.addEventListener('click', ()=>{
							input.value = commentRemover.dataset.commentId;
							input.form.submit();
						});
					}
				})();
			</script>
		</div>
		{{-- Comment create --}}
		<form id="comment-create" method="post" action="{{REL_DIR}}/comments/create">
			{{csrf_field()}}
			<input name="post_id" type="hidden" value="{{$post->id}}">
			<input id="new-comment-username" name="username" type="text" class="form-control" id="new-comment-username" placeholder="Username" title="Any combination of 3 to 24 letters, numbers, dashes and underscores." required minlength="3" maxlength="24" pattern="[a-zA-Z0-9_-]*">
			<textarea id="new-comment-content" name="content" class="form-control" id="new-comment-content" placeholder="What are your thoughts?" required></textarea>
			<button type="submit" class="btn btn-primary">Comment</button>

			{{-- Focus handler --}}
			<script>
				(()=>{
					const form = document.getElementById('comment-create');
					const inputUsername = document.getElementById('new-comment-username');
					const inputContent = document.getElementById('new-comment-content');
					
					form.addEventListener('focus', (evt)=>{
						if (evt.target && form.contains(evt.target))
						{
							form.classList.add('focused');
						}
					}, true);
					form.addEventListener('blur', (evt)=>{
						if (evt.target && form.contains(evt.target) && (!evt.relatedTarget || !form.contains(evt.relatedTarget)))
						{
							if (!inputUsername.value && !inputContent.value)
							{
								form.classList.remove('focused');
							}
						}
					}, true);
				})();
			</script>
		</form>
	</div>
@endsection