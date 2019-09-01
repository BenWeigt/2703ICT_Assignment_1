<?php
	// Const for simplifying link creation. Update if project is installed or moved.
	define('REL_DIR', '/2703ICT_Assignment_1/postir/public');
	// Const list of emoji's that is used in the animated logo construction and as a source for post icons.
	define('EMOJ_LIST', ['💩','🍆','🤏','🐱‍👤','🙏','😂','🔥','🤘','😈','👌','😎','👍','❤️','🎶','💩']);

	/* ******************* GET Handlers ********************* */
	/**
	 * Home/Landing
	 * Displays a feed of all posts, tagged with their comment count. Also contains a form for
	 * creating new posts.
	 */
	Route::get('/', function(){
		$posts = DB::select(
			"SELECT Posts.*, COUNT(Comments.id) AS comment_count
			 FROM Posts
			 LEFT JOIN Comments ON Comments.post_id = Posts.id
			 GROUP BY Posts.id
			 ORDER BY Posts.id DESC"
		);	
		return view('home', ['posts' => $posts]);
	});
	
	/**
	 * Recent Posts
	 * Displays a feed (see Home/Landing), filtered to those created in the last 7 days.
	 */
	Route::get('/recent', function(){
		// Our timestamps are stored as unicode integer timestamps. To compare, we use sqlite's
		// date functions to generate a unicode timestamp -7 days from now.
		$posts = DB::select(
			"SELECT Posts.*, COUNT(Comments.id) AS comment_count
			 FROM Posts
			 LEFT JOIN Comments ON Comments.post_id = Posts.id
			 WHERE Posts.timestamp > strftime('%s', 'now', '-7 days')
			 GROUP BY Posts.id
			 ORDER BY Posts.id DESC"
		);
		return view('recent', ['posts' => $posts]);
	});

	/**
	 * Post
	 * Displays a post in its entirety, including comments.
	 * Exposes the delete and edit tools.
	 */
	Route::get('/posts/{postId}', function($postId){
		// Light sanity checking
		$postId = intval($postId);
		if (!is_int($postId) || $postId < 0)
		{
			return redirect('/');
		}
		// Sanitisation via PDO within laravel abstraction
		$posts = DB::select('SELECT * FROM Posts WHERE id = ?', [$postId]);
		if (!isset($posts[0]))
		{
			return redirect('/');
		}
		// Sanitisation via PDO within laravel abstraction
		$comments = DB::select('SELECT * FROM Comments WHERE post_id = ?', [$postId]);
		return view('post', ['post' => $posts[0], 'comments' => $comments]);
	});

	/**
	 * Users
	 * Displays a grid of all users who are current owners of at least 1 post.
	 * Also displays their number of posts.
	 * Clicking these users goes to their User page.
	 */
	Route::get('/users', function(){
		$users = DB::select(
			"SELECT Posts.username, COUNT(Posts.id) AS post_count
			 FROM Posts
			 GROUP BY Posts.username
			 ORDER BY Posts.id DESC"
		);
		return view('users', ['users' => $users]);
	});
	
	/**
	 * User Posts
	 * Displays a post feed containing all the posts for the given user.
	 */
	Route::get('/users/{username}/posts', function($username){
		// Light sanity check (empty or not between 3-24 chars of a-z A-Z 0-9 _-)
		if (empty($username) || !preg_match('/^[a-zA-Z0-9_-]{3,24}$/', $username))
		{
			return redirect('/');
		}
		// Sanitisation via PDO within laravel abstraction
		$posts = DB::select(
			"SELECT Posts.*, COUNT(Comments.id) AS comment_count
			 FROM Posts
			 LEFT JOIN Comments ON Comments.post_id = Posts.id
			 WHERE Posts.username = ?
			 GROUP BY Posts.id
			 ORDER BY Posts.id DESC", [$username]
		);
		// The user was not guaranteed to have any posts, which is fine
		return view('user-posts', ['posts' => $posts, 'username' => $username]);
	});

	/**
	 * Documentation
	 */
	Route::get('/about', function(){
		return view('about');
	});


	/* ******************* POST Handlers ********************* */
	/**
	 * Posts creation handler
	 * Takes a username, title, content and creates a post.
	 * Randomly generates it's own icon (and is configured to properly manage a base64 data url 
	 * encoded asset) and records the creation time.
	 */
	Route::post('/posts/create', function(){
		$username = request('username');
		$title = request('title');
		$content = request('content');

		$icon = EMOJ_LIST[rand(0, count(EMOJ_LIST)-1)]; //request('icon');

		// Light sanity checking (empty, title len, regex on username)
		if (empty($username) || empty($title) || empty($content) 
			 || strlen($title) > 80 || !preg_match('/^[a-zA-Z0-9_-]{3,24}$/', $username))
		{
			return redirect('/');
		}

		// Sanitisation via PDO within laravel abstraction
		// Note: it is sometimes best to url/html escape before storing to avoid injections later,
		// however laravel supplies two insertion notations, {{$string}} and {{{$string}}} which 
		// alow us to easily manage encoding without introducing further complexities (such as 
		// avoiding recursive encodes).
		DB::table('Posts')->insert([
			'timestamp' => time(),
			'username' => $username,
			'title' => $title,
			'icon' => $icon,
			'content' => $content
		]);
		
		return redirect('/');
	});

	/**
	 * Posts editing handler
	 * Takes an existing post by id, and updates its values with a supplied username, title and
	 * content.
	 */
	Route::post('/posts/edit', function(){
		$id = request('id');
		$id = intval($id);
		// Light sanity check
		if (!is_int($id) || $id < 0)
		{
			return redirect('/');
		}

		$username = request('username');
		$title = request('title');
		$content = request('content');
		// Light sanity checking (empty, title len, regex on username)
		if (empty($username) || empty($title) || empty($content) 
		   || strlen($title) > 80 || !preg_match('/^[a-zA-Z0-9_-]{3,24}$/', $username))
		{
			return redirect('/');
		}

		// Sanitisation via PDO within laravel abstraction
		// Previous notes about content encoding apply here.
		DB::table('Posts')->where('id', $id)->update([
			'username' => $username,
			'title' => $title,
			'content' => $content
		]);

		// If the post doesn't exist, the hander at /posts/{id} will redirect again to home
		return redirect('/posts/'.$id);
	});

	/**
	 * Posts delete handler
	 * Deletes a post and all linked comments.
	 */
	Route::post('/posts/delete', function(){
		$id = request('id');
		$id = intval($id);
		// Light sanity check
		if (!is_int($id) || $id < 0)
		{
			return redirect('/');
		}

		// Sanitisation via PDO within laravel abstraction
		DB::delete('DELETE FROM Posts WHERE id = ?', [$id]);
		DB::delete('DELETE FROM Comments WHERE post_id = ?', [$id]);
		
		// A further improvement might be to check Request::server('HTTP_REFERER') and redirect
		// back to a more natural return point where possible.
		return redirect('/');
	});

	/**
	 * Comments creation handler
	 * Takes a post id, username, content and creates a comment. 
	 */
	Route::post('/comments/create', function(){
		$postId = request('post_id');
		$postId = intval($postId);
		// Light sanity check
		if (!is_int($postId) || $postId < 0)
		{
			return redirect('/');
		}

		$username = request('username');
		$content = request('content');
		// Light sanity checking (empty, regex on username)
		if (empty($username) || empty($content) || !preg_match('/^[a-zA-Z0-9_-]{3,24}$/', $username))
		{
			return redirect('/');
		}

		// Sanitisation via PDO within laravel abstraction
		// Previous notes about content encoding apply here.
		DB::table('Comments')->insert([
			'timestamp' => time(),
			'post_id' => $postId,
			'username' => $username,
			'content' => $content
		]);

		// In the case of failure, /posts/{id} will redirect home
		return redirect('/posts/'.$postId);
	});

	/**
	 * Comments delete handler
	 * Deletes a comment by id.
	 */
	Route::post('/comments/delete', function(){
		$id = request('id');
		$id = intval($id);
		// Light sanity check
		if (!is_int($id) || $id < 0)
		{
			return redirect('/');
		}

		// Look the post id up so we can return cleanly
		$postId = DB::select('SELECT post_id FROM Comments WHERE id = ?', [$id]);
		if (!isset($postId[0]))
		{
			return redirect('/');
		}
		$postId = $postId[0]->post_id;
		
		// Sanitisation via PDO within laravel abstraction
		DB::delete('DELETE FROM Comments WHERE id = ?', [$id]);
		// A further improvement might be to check Request::server('HTTP_REFERER') and redirect
		// back to a more natural return point where possible.
		return redirect('/posts/'.$postId);
	});