{{-- Post Feed --}}
<div class="posts">
	@foreach ($posts as $post)
		<div class="post" data-post-id="{{$post->id}}">
		@if (substr($post->icon, 0, 21) !== 'data:image/png;base64')
			<div class="post-icon">{{$post->icon}}</div>
		@else
			<img class="post-icon" src="{{$post->icon}}">
		@endif
		<div class="post-comment-count">{{$post->comment_count}}</div>
		<div class="post-username">By <a href="{{REL_DIR}}/users/{{$post->username}}/posts">{{$post->username}}</a><small> &#x40;{{date('d/m/y H:i', $post->timestamp)}}</small></div>
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