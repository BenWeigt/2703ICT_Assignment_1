@extends('designs/postir')

@section('content')
	<h1>Documentation</h1>

	<h2>ER Diagram</h2>
	Via embed:
	<iframe width="560" height="315" src='https://dbdiagram.io/embed/5d6c1ef1ced98361d6de1942'></iframe>

	<h2>Notes about Postir</h2>
	<p>
		Every element of the rubric should find its satisfaction in the implementation.
		There is some concern that the db structure felt too easy, but it does appear to fulfil every requirement.
		Sanitisation was kept light and only slightly exceeds the bounds of the course material (regex).
	</p>
	<p>
		There is one WIP feature to be found in icons; time permitting, there was intention to add a 
		simple &#x3C;input type=&#x201D;file&#x201D;&#x2026; to the post creation form that would 
		accept an image, load it into a &#x3C;canvas&#x3E;, downscale it to a standard small dimension, 
		then finally base64 encode to become part of the post. This did not end up being completed in 
		time, though posts displays are still set up to handle the resulting data url’s. In lieu, post 
		creation instead choses a grapheme at random to satisfy the rubric requirement.
	</p>
@endsection