
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo WP_CONTENT_URL . '/plugins/wwt-creator/js/jquery/jquery.colorbox.js' ?>"></script>
		<script type="text/javascript">

			$(document).ready(function(){
				$("a[rel='modal']").colorbox({transition:"fade", initialWidth:"263", initialHeight:"109", overlayClose:"false"});
			});
		/*	
			jQuery(document).ready(function($) {
				$("a[rel='facebox']").facebox();
			});
		*/		
	
		</script>	
		
		
		
	<div class="wwtst">
	
		<input type="hidden" id="wwt-generate-tour" />
		
		<a href="<?php echo WP_CONTENT_URL . '/plugins/wwt-creator/includes/processing.inc.php' ?>" rel="modal" class="wwt-save-button" onClick="submitTourForm(); return false;">
			<span class="wwt-save">Save</span>
		</a>
		
	</div>