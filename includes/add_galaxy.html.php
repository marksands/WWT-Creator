<?php
	include_once( 'messier_catalog.inc.php' );	
?>

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
		
		<select name="messier" id="messier">
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