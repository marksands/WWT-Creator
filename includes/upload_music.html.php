
<script type="text/javascript">

</script>

<p>Upload a music file to be played throughout the tour. (optional)</p>

<p><strong>Add Music:</strong></p>

<div class="wwtmu">

	<label for="async-upload">Music</label>
				
		<!-- <input type="hidden" name="MAX_FILE_SIZE" value="4194304" /> -->
		<div id="divinputfile">
			<input type="text" name="fakeupload" id="fakeupload" readonly />			
		</div>
		
		<input type="file" name="audio-file" id="audio-file" class="uploadfile" onchange="this.form.fakeupload.value = this.value;"/>
		
		<a href="#" class="wwt-upload-music" onClick="">
			<span class="wwt-music">Browse</span>
		</a>

</div>

<div id="showra">
</div>