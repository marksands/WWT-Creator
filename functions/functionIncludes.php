<?php

function WWTMenu() {
	add_submenu_page('post-new.php', "Posts", "WWT Tour Creator", 1, "WWT Tour Creator", "wwt_meta"); 	 
	//add_submenu_page('options-general.php', 'WorldWide Telescope', 'WWT Tour Creator', 1, 'WWT Tour Creator', 'wwt_meta');
	//add_meta_box('wwt-archive', 'WorldWide Telescope Tour Archive', 'TourArchive', 'post');
}  

function TourArchive() { ?>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>	
	<script type="text/javascript">
	// jQuery(function() {
	// 	
	// 	jQuery(".delTour").click(function(e) {
	// 
	// 			jQuery.ajax({
	// 				type: "POST",
	// 				url: "../wp-content/plugins/wwt-creator/functions/deleteCallback.php",
	// 				data: "tour=" + jQuery(this).parseInt.id // look this up
	// 			});	
	// 		
	// 	  document.forms[0].submit();
	// 		return false;
	// 	});
	// });
	</script>
		
		
	<div id="postcustomstuff">
		<div id="ajax-respone"></div>
		
		<p><strong>Select from tour archive:</strong></p> 

		<!--  Inner List -->
		<table id="list-table" style="display: none;"> 
			<thead> 
			<tr> 
				<th class="left">Name</th> 
				<th>Embed</th> 
				<th>Hard Link</th>
				<th>Delete</th>
			</tr> 
			</thead> 
			<tbody id="the-list" class="list:meta"> 
				<tr>
					<td>
					</td>
				</tr> 
			</tbody> 
		</table>

		<!--  Outer Header thingy-->
		<table id="newmeta"> 

		<thead> 
			<tr> 
				<th class="left">Name</th> 
				<th>Embed</th> 
				<th>Hard Link</th> 
				<!-- <th>Delete</th> -->
			</tr> 
		</thead> 

		<tbody> 
									
			<?php
					
			  $results = ReadTourFiles();

				$i = 0;
				foreach ( $results as $res )
				{
					echo
						"<tr>
							<td id='' class='left'>
								<strong>$res</strong>
							</td>
							<td>
								<input type='submit' id='embedTour$i' name='embed_tour' class='add:the-list:newmeta' value='Embed' />
							</td>
							<td>
								<input type='submit' id='hardLinkTour$i' name='hardlink_tour' class='add:the-list:newmeta' value='Hard Link' />
							</td>
							<!--
							<td>
								<input type='submit' id='deleteTour$i' name='delete_tour' class='add:the-list:newmeta delTour' value='Delete'' />
							</td>
							-->
						</tr>";
						$i++;
				}
				
			?>
			
		</tbody>
	</table>
	</div>

	<?php

	// nifty links
	// Authoring, tour sound files: http://worldwidetelescope.org/authoring/Authoring.aspx?Page=TourResources
	// WWT Complete: http://worldwidetelescope.org/COMPLETE/WWTCoverageTool.htm
}

// This was hard to come by, correct me if I'm wrong please! :)
function addHeaderCode() {
	echo '<link type="text/css" rel="stylesheet" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/wwt-creator/css/main.css" />' . "\n";
	echo '<script type="text/javascript" src="../wp-content/plugins/wwt-creator/js/tourarchive.js" ></script>';
}

function addInitCode() {
	/* none for now */
}



// Make magic happen
function EmbedCode( $tourfile ) {
	$tour_link = WP_CONTENT_URL.'/plugins/wwt-creator/tours/' . str_replace(" ", "%20", $tourfile );
	$embed = 
		'<script type="text/javascript">var wwtView;function loadTour(a){switch(a){case 1:wwtView.LoadTour("'.$tour_link.'");document.getElementById("playing").value="Playing Tour";break}document.getElementById("tour1").disabled=true;document.getElementById("restart").disabled=false;document.getElementById("stop").disabled=false}function stopTour(){wwtView.StopTour();document.getElementById("tour1").disabled=false;document.getElementById("restart").disabled=true;document.getElementById("stop").disabled=true;document.getElementById("playing").value="No tour currently playing"}function restartTour(){wwtView.PlayTour()}function wwtReady(){wwtView=document.getElementById("WWTView").content.WWT}</script>
	 	<table border="1" bgcolor="lightgrey"><tbody><tr><td><div id="WorldWideTelescopeControlHost"><object id="WWTView" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="480" height="342" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0"><param name="source" value="http://www.worldwidetelescope.org/webclient/WWTSL.xap" /><param name="background" value="black" /><param name="minRuntimeVersion" value="2.0.31005.0" /><param name="autoUpgrade" value="true" /><param name="initParams" value="NoUI=false,wtml=,webkey=AX2011Gqqu" /><param name="enableHtmlAccess" value="true" /><embed id="WWTView" type="application/x-shockwave-flash" width="480" height="342" enablehtmlaccess="true" initparams="NoUI=false,wtml=,webkey=AX2011Gqqu" autoupgrade="true" minruntimeversion="2.0.31005.0" background="black" source="http://www.worldwidetelescope.org/webclient/WWTSL.xap"></embed></object></div></td></tr><tr><td><input id="tour1" onclick="loadTour(1);" type="button" value="Load Tour" /> <input id="playing" type="text" value="No tour currently playing" /></td></tr></tbody></table>';

	return $embed;
}

// Make more magic happen
function HardLink( $tourfile ) {
	$tour_link = WP_CONTENT_URL.'/plugins/wwt-creator/tours/' . str_replace(" ", "%20", $tourfile );
	$view_link = "http://www.worldwidetelescope.org/webclient/default.aspx?tour=" . $tour_link;
	
	return $view_link;	
}

function ReadTourFiles() {
		$path = WP_CONTENT_DIR.'/plugins/'.'wwt-creator/';
		$tourDir = $path . 'tours/';
		
    $results = array();

		if ($handle = opendir($tourDir)) {
		    while ($file = readdir($handle)) {
		        if ($file != '.' && $file != '..') {
		            $results[] = StripTitle( $file );
		        }
		    }
		    closedir($handle);
		}
		
    return $results;
}

function StripTitle( $tourfile ) {
	$title = str_replace("tour-", "", $tourfile );
	$title = str_replace(".wtt", "", $title );	
	
	return $title;		
}


?>
