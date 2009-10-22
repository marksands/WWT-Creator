<?php
	//$colorbox   = WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)).'/js/jquery/jquery.colorbox.js';
	//$processing = WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)).'/includes/processing.inc.php';
	$colorbox = WP_CONTENT_URL.'/plugins/wwt-creator/js/jquery/jquery.colorbox.js';
?>


	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $colorbox ?>"></script>
	<script type="text/javascript">

		$(document).ready(function(){
			$("a[rel='modal']").colorbox({transition:"fade", initialWidth:"263", initialHeight:"109", overlayClose:"false"});
		});	

	</script>	
		
		
	<div class="wwtst">
		
		<input type="hidden" id="wwt-generate-tour" />
		
		<a href="<?php echo $processing ?>" rel="modal" class="wwt-save-button" onClick="submitTourForm(); return false;">
			<span class="wwt-save">Save</span>
		</a>
		
	</div>