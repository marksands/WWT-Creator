<?php

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

function WWTMenu() { 
	add_menu_page('WorldWide Telescope', 'WorldWide Telescope', 'administrator', "WorldWide-Telescope-Menu");
	add_submenu_page('post-new.php', "Posts", "Tour Creator", 1, "WWT Tour Creator", "wwt_meta"); 
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
	
	<strong>Select Tour From Archive:</strong>
		<div class="inside">
			<div class="left">
				<table>
					<tr>
						<th>Name</th>
						<th>Embed</th>
						<th>Hard Link</th>
						<th>Delete</th>
					</tr>

					<?php // generate the files here ?>
						<tr>
							<td>---</td>
						</tr>
						
				</table>

				<!-- <select name="tour" id="tour"> -->
				<?php
					// for ($i = 0; $i < $rows; $i++) {
					//   //$data = mysqli_fetch_object($result);
					//   //echo '<option name="' . $data->title .'" style="width:20%;"> ' . $data->title .' </option>';
					// }
				?>
				<!-- </select> -->
			</div>
			
			<div class="submit">
				<input type="submit" name="submit" value="Embed Tour" \>
			</div>
			
		</div>
	</div>
	<?php
	
	// add ability to embed the silverlight code ? :)
	
	$embed = <<<'EOF'
		<script type="text/javascript">var wwtView;function loadTour(a){switch(a){case 1:wwtView.LoadTour("http://www.verysuperfluo.us/galaxyzoo/wp-content/plugins/wwt-creator/tours/tour-My%20journey%20through%20the%20cosmos.wtt");document.getElementById("playing").value="Playing Tour";break}document.getElementById("tour1").disabled=true;document.getElementById("restart").disabled=false;document.getElementById("stop").disabled=false}function stopTour(){wwtView.StopTour();document.getElementById("tour1").disabled=false;document.getElementById("restart").disabled=true;document.getElementById("stop").disabled=true;document.getElementById("playing").value="No tour currently playing"}function restartTour(){wwtView.PlayTour()}function wwtReady(){wwtView=document.getElementById("WWTView").content.WWT}</script>
		<table border="1" bgcolor="lightgrey"><tbody><tr><td><div id="WorldWideTelescopeControlHost"><object id="WWTView" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="480" height="342" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0"><param name="source" value="http://www.worldwidetelescope.org/webclient/WWTSL.xap" /><param name="background" value="black" /><param name="minRuntimeVersion" value="2.0.31005.0" /><param name="autoUpgrade" value="true" /><param name="initParams" value="NoUI=false,wtml=,webkey=AX2011Gqqu" /><param name="enableHtmlAccess" value="true" /><embed id="WWTView" type="application/x-shockwave-flash" width="480" height="342" enablehtmlaccess="true" initparams="NoUI=false,wtml=,webkey=AX2011Gqqu" autoupgrade="true" minruntimeversion="2.0.31005.0" background="black" source="http://www.worldwidetelescope.org/webclient/WWTSL.xap"></embed></object></div></td></tr><tr><td><input id="tour1" onclick="loadTour(1);" type="button" value="Load Tour" /> <input id="playing" type="text" value="No tour currently playing" /></td></tr></tbody></table>
	EHT;

	// nifty links
	// Authoring, tour sound files: http://worldwidetelescope.org/authoring/Authoring.aspx?Page=TourResources
	// WWT Complete: http://worldwidetelescope.org/COMPLETE/WWTCoverageTool.htm
		
	//mysqli_close($db); 
}

// This was hard to come by, correct me if I'm wrong please! :)
function addHeaderCode() {
	echo '<link type="text/css" rel="stylesheet" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/wwt-creator/css/main.css" />' . "\n";
}

function addInitCode() {
	/* none */
}



// Make magic happen
function AddTourToDB( $tourname ) {
	
	$tour_link = WP_CONTENT_URL.'/plugins/wwt-creator/tours/' . str_replace(" ", "%20", $tourname );
	$view_link = "http://www.worldwidetelescope.org/webclient/default.aspx?tour=" . $tour_link
	
	/* sample view link */
	// http://www.worldwidetelescope.org/webclient/default.aspx?tour=http://www.verysuperfluo.us/galaxyzoo/wp-content/plugins/wwt-creator/tours/tour-My%20journey%20through%20the%20cosmos.wtt
	
	// $wpdb->write( $view_link )

}

function GET($name, $default=null)
{
	if ( isset($_GET[$name]) )
		return $_GET[$name];
	return $default;
}

?>
