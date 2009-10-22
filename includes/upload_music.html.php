
<script type="text/javascript">

</script>

<p>Upload a music file to be played throughout the tour. (optional)</p>

<p><strong>Add Music:</strong></p>

<!-- What's this here for..?  <form action=" echo $_SERVER['PHP_SELF']; " method="post"> -->
<div class="wwtmu">

	<label for="async-upload">Music</label>
	
	<input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
	<input type="file" name="audio-file" id="audio-file" />

	<a href="#" class="wwt-upload-music" onClick="">
		<span class="wwt-music">Upload</span>
	</a>

</div>

<div id="showra">
</div>