{{-- Post create --}}
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