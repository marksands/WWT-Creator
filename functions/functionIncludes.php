<?php

function WWTMenu() { 		 
	add_submenu_page('options-general.php', 'WorldWide Telescope', 'WWT Tour Creator', 1, 'WWT Tour Creator', 'wwt_meta');
	add_meta_box('wwt-archive', 'WorldWide Telescope Tour Archive', 'TourArchive', 'post');
}  

function TourArchive() {
	?>
	
	<!-- somehow get this to copy this code into the clipboard maybe? [copy embedded code] *click* then paste? -->
	<!-- <script type="text/javascript">
	function CopyToClipboard() {
	   CopiedTxt = $embed;
	   CopiedTxt.execCommand("Copy");
	}
	</script> -->
	
	<div id="wwt-tour-list" class="" > 

		<div class="handlediv" title="Click to toggle">
		<br />
		</div>
		<h3 class='hndle'><span>WorldWide Telescope Tour Archive</span></h3> 

			<div class="inside"> 
				<div id="postcustomstuff"> 
					<div id="ajax-response"></div> 

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
							<tr><td></td></tr> 
							</tbody> 
						</table>

						<p>
							<strong>Select from tour archive:</strong>
						</p> 

						<table id="newmeta"> 

						<thead> 
							<tr> 
								<th class="left">Name</th> 
								<th>Embed</th> 
								<th>Hard Link</th> 
								<th>Delete</th> 
							</tr> 
						</thead> 

						<tbody> 
													
							<?php
									
							  $results = ReadTourFiles();
								foreach ( $results as $res )
								{
									echo "<tr>
													<td id="newmetaleft" class="left">
														$res
													</td>
													<td>
														<a href='#'>Embed</a>
													</td>
													<td>
														<a href='#'>Hard Link</a>														
													</td>
													<td>
														<a href='#'>Delete</a>														
													</td>
												</tr>";
								}
								
							?>

							<tr>
								<td colspan="2" class="submit"> 
									<input type="submit" id="addmetasub" name="addmeta" class="add:the-list:newmeta" tabindex="9" value="Add Custom Field" /> 
									<input type="hidden" id="_ajax_nonce" name="_ajax_nonce" value="315c001a4b" />
								</td>
							</tr> 
						</tbody> 
					</table> 
	</div> 
	</div> 
	</div>

	<?php

	// nifty links
	// Authoring, tour sound files: http://worldwidetelescope.org/authoring/Authoring.aspx?Page=TourResources
	// WWT Complete: http://worldwidetelescope.org/COMPLETE/WWTCoverageTool.htm
}

// This was hard to come by, correct me if I'm wrong please! :)
function addHeaderCode() {
	echo '<link type="text/css" rel="stylesheet" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/wwt-creator/css/main.css" />' . "\n";
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

function writeToVariables( &$title, &$description, &$author, &$email, &$galaxies, &$tours ) {
	
	$title = $_REQUEST['title'];
	$description = $_REQUEST['description'];
	$author = $_REQUEST['author'];
	$email = $_REQUEST['email'];
	
	foreach ( $galaxies as $gal )
	{
		$tours[] = array(
			  'duration' => '00:00:10',     //$_REQUEST['Duration'];
			  'ra' => $gal['ra'],
			  'dec' => $gal['dec'],
			  'zoomlevel' => '0.1'          //$_REQUEST['ZoomLevel'];
			);
	}
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
