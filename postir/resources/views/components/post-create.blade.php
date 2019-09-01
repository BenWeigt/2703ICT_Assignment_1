{{-- Post create --}}
<form method="post" id="post-create" action="{{REL_DIR}}/posts/create" class="post-create">
	{{csrf_field()}}
	<input name="username" type="text" class="form-control" id="new-post-username" placeholder="Username" title="Any combination of 3 to 24 letters, numbers, dashes and underscores." required minlength="3" maxlength="24" pattern="[a-zA-Z0-9_-]*">
	<input name="title" type="text" class="form-control" id="new-post-title" placeholder="Post title" required minlength="3" maxlength="80">
	<textarea name="content" class="form-control" placeholder="Your post..." id="new-post-content" required></textarea>
	<button type="submit" class="btn btn-primary">Create Post</button>

	<script>
		(()=>{
			const form = document.getElementById('post-create');
			const inputUsername = document.getElementById('new-post-username');
			const inputTitle = document.getElementById('new-post-title');
			const inputContent = document.getElementById('new-post-content');
			
			form.addEventListener('focus', (evt)=>{
				if (evt.target && form.contains(evt.target))
				{
					form.classList.add('focused');
				}
			}, true);
			form.addEventListener('blur', (evt)=>{
				if (evt.target && form.contains(evt.target) && (!evt.relatedTarget || !form.contains(evt.relatedTarget)))
				{
					if (!inputUsername.value && !inputTitle.value && !inputContent.value)
					{
						form.classList.remove('focused');
					}
				}
			}, true);
		})();
	</script>
</form>