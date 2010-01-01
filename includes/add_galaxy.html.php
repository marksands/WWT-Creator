<?php
	include_once( 'messier_catalog.inc.php' );	
?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="http://jquery-ui.googlecode.com/svn/tags/latest/ui/effects.core.js" ></script>
<script type="text/javascript" src="http://jquery-ui.googlecode.com/svn/tags/latest/ui/effects.highlight.js" ></script>
<script type="text/javascript" src="../wp-content/plugins/wwt-creator/js/jquery/jquery.colorbox.js"></script>
<script type="text/javascript" src="../wp-content/plugins/wwt-creator/js/messier_catalog.min.js"></script>
<script type="text/javascript" src="../wp-content/plugins/wwt-creator/js/ag-methods.js" ></script>


<p>Enter each galaxy's Right Ascension and Declination values in decimal format. You can add more than one galaxy by clicking the Add Galaxy button.</p>	
	
<p><strong>Add Galaxy:</strong></p>

<div class="wwtag">

	<label for="ra" class="lb-left">Right Ascension</label>
	<label for="dec" class="lb-right">Declination</label>

	<input type="hidden" id="is_tour" name="is_tour" value="" />
	<input type="hidden" id="galaxy-id" value="1">
	<div id="add-galaxy-div">
	</div>
	
	<div class="wwtag-radec">
		<input type="text" id="ra" name="ra" value="" />
		<input type="text" id="dec" name="dec" value="" />
		
		<select name="messier" id="messier" onChange="addPresetGalaxy(); return false;">
			<option value="0"> Optionally select from a list of preset objects </option>
		<?php
			$count = 1;
			foreach ( $messier_catalog as $k => $v )
			{
				if ( $v['name'] != '' )
					echo '<option value=\''.$count.'\'>'.$v['name'].'</option>';
				else
					echo '<option value=\''.$count.'\'>'.$k.'</option>';	
				
				$count++;
			}
		?>
		</select>
	
		<a href="#" class="wwt-add-button">
			<span class="wwt-add">Add Object</span>
		</a>
	</div>
	
</div>

<?php

?>