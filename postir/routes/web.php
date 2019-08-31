<?php
	define('REL_DIR', '/2703ICT_Assignment_1/postir/public');
	/**
	 * Rubric: UI Design 
	 * Layout (navigation, etc), ease of use, aesthetics.
	 * 
	 * Rubric: Template Inheritance
	 * Master layout + child layouts. Correct placement of code within master and child. 
	 * No PHP in templates. Templates should perform minimal logic, logic should be in Routes.php.
	 * 
	 * Rubric: Code structure and layout
	 * Correct indenting/spacing, readable.
	 * 
	 * Rubric: Code commenting and naming
	 * Every function commented Use appropriate names for files, functions, and variables.
	 */



	/**
	 * Rubric: Security HTML sanitisation 
	 * Implement proper security measure. E.g. performs HTML, SQL sanitization, and prevents CSRF 
	 * attack etc.
	 */

	/**
	 * Home/Landing
	 * Displays a feed of all posts, tagged with their comment count. Also contains a form for
	 * creating new posts.
	 * 
	 * Rubric: List (Posts)
	 * The home page must display all posts. Only posts should be displayed, not comments.
	 * 
	 * Rubric: Display number of comments
	 * Next to each post there should a number indicating how many comments are there for this post.   
	 */
	Route::get('/', function(){
		$posts = DB::select(
			"SELECT Posts.*,
			 COUNT(Comments.id) AS comments_count
			 FROM Posts
			 INNER JOIN Comments on Comments.post_id = Posts.id
			 GROUP BY Posts.id
			 ORDER BY Posts.id"
		);	
		return view('post-feed', ['posts' => $posts]);
	});

	/**
	 * Rubric: Most recent posts
	 * There is a most recent page, which shows only the posts that have been made in the last 7 
	 * days.
	 */
	Route::get('/recent', function(){
		
	});

	/**
	 * 
	 * Rubric: Details (comments page)
	 * From the home page, click on a post will bring up the comments page. The comments page for 
	 * a post should contain that post and all comments for that post.
	 */
	Route::get('/posts/{postId}', function($postId){
		return view('post-feed' /*, ['post' => $post]*/);
	});


	/**
	 * Rubric: Display unique users/posts by a user
	 * There is a page that lists all unique users that have made a post (i.e. a user is only 
	 * displayed once no matter how many posts this user has made). Clicking on the user should 
	 * display all posts made by that user.
	 */
	Route::get('/users', function(){

	});

	Route::get('/users/{userId}', function($userId){

	});

	/**
	 * Rubric: Documentation
	 * Description of tasks completed, not completed, approaches used, anything extra.
	 * This documentation should be provided as a page (or pages) in the website and linked to 
	 * from the navigation menu.
	 * 
	 * Rubric: Entity Relationship Diagram
	 * Table names, keys, columns, relationships, cardinality. Linked to from the website.
	 */
	Route::get('/about', function(){

	});

	/**
	 * Rubric: Create Post
	 * The home page must display a form for the user to create a new post. Each post should 
	 * contain a title, a message, a date, an icon, and a user’s name (the user is not required 
	 * to login, they can simply enter their name in the post form). All posts can have the same 
	 * icon. When creating a new post, user must enter the title, message, and user’s name. Date 
	 * can either be entered or generated by the system. After a new post is successfully created,
	 * it should redirect back to the home page.
	 */
	Route::post('/posts/create', function(){
		$username = request('username');
		$title = request('title');
		$icon = request('icon');
		$content = request('content');
		// Some really stupidly naive sanity checking. Won't block any real attempts to bypass.
		if (is_string($username) && is_string($title) && strlen($username) <= 80)
		{
			$postId = DB::table('Posts')->insert([
				'timestamp' => time(),
				'username' => $username,
				'title' => $title,
				// 'icon' => $icon,
				'content' => $content
			]);
		}
		return redirect('/');
	});

	/**
	 * Rubric: Edit Post
	 * Users can edit posts. After a post is edited, the comments page for that post is displayed.
	 */
	Route::post('/posts/edit', function(){

	});

	/**
	 * Rubric: Deletes post
	 * Users can delete posts. When user deletes a post, the comments for that post should also 
	 * be deleted. 
	 */
	Route::post('/posts/delete', function(){

	});

	/**
	 * Rubric: Add comment
	 * Users can add comments to a post. A comment must have a message and a user, but no title. 
	 */
	Route::post('/comments/create', function(){

	});

	/**
	 * Rubric: Delete comment
	 * Users can delete comments.
	 */
	Route::post('/comments/delete', function(){

	});