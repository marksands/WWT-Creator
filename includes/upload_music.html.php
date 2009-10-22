<?php

/*

if (preg_match('/^image\/p?jpeg$/i', $_FILES['upload']['type']) or 
	preg_match('/^image\/gif$/i', $_FILES['upload']['type']) or 
	preg_match('/^image\/(x-)?png$/i', $_FILES['upload']['type']))
	{
		// handle file	
	} 
	else {
		$error = 'Please submit a JPEG, GIF, or PNG image file.';
		include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
		exit();	
	}
	
	*/
?>


<script type="text/javascript">

</script>

<p>Upload a music file to be played throughout the tour. (optional)</p>

<p><strong>Add Music:</strong></p>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<div class="wwtmu">

	<label for="async-upload">Music</label>
	
	<input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
	<input type="file" name="async-upload" id="async-upload" />

	<a href="#" class="wwt-upload-music" onClick="">
		<span class="wwt-music">Upload</span>
	</a>

</div>

<div id="showra">
</div>