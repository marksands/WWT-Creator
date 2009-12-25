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

function wwt_admin_actions() {  
	add_submenu_page('post-new.php', "Posts", "WWT Tour Creator", 1, "WWT Tour Creator", "wwt_meta"); 
}  

function wwt_tour_archive_post() {
	add_meta_box('wwt-archive','WorldWide Telescope Tour Archive','wwt_meta2','post');
}

function wwt_meta2() {
	
	// $db = mysqli_connect( 'localhost', 'root', 'raidmax' );
	// mysqli_select_db($db, 'test');

	// $sql = "SELECT * FROM tour";
	// $result = mysqli_query($db, $sql);
	// $rows = mysqli_num_rows($result);
	
	?>
	
	<!-- somehow get this to copy this code into the clipboard maybe? [copy embedded code] *click* then paste? -->
	<script type="text/javascript">
	function CopyToClipboard() {
	   CopiedTxt = $embed;
	   CopiedTxt.execCommand("Copy");
	}
	</script>
	
	<strong>Select Tour From Archive:</strong>
		<div class="inside">
			<div class="left">	
				
				<h1>Name</h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<h1>Delete?</h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<h1>Copy Embed</h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<h1>Copy Direct Link</h1>
				
				<span>M83 and friends</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span>[ ]</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span>copy</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span>copy</span>

				<span>Nebuls and friends</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span>[ ]</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span>copy</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span>copy</span>
									
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


/* CREATING THE NEW DATABASE TABLE */

$jal_db_version = "1.0";

function jal_install () {
  global $wpdb;
  global $jal_db_version;

  $table_name = $wpdb->prefix . "wwttours";
  if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
		$sql = "CREATE TABLE " . $table_name . " (
		  tourname text NOT NULL,
		  filename text NOT NULL,
		  UNIQUE KEY id (id)
		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

		$welcome_name = "Mr. Wordpress";
		$welcome_text = "Congratulations, you just completed the installation!";

		$insert = "INSERT INTO " . $table_name .
							" (tourname, filename) " .
							"VALUES ('" . $wpdb->escape($welcome_name) . "','" . $wpdb->escape($welcome_text) . "')";

		$results = $wpdb->query( $insert );
		
		// version control
		add_option("jal_db_version", $jal_db_version);
	}
	
	
	// UPGRADE DATABASE
	$installed_ver = get_option( "jal_db_version" );


  if( $installed_ver != $jal_db_version ) {
		$sql = "CREATE TABLE " . $table_name . " (
		  tourname text NOT NULL,
		  filename text NOT NULL,
		  UNIQUE KEY id (id)
		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

		update_option( "jal_db_version", $jal_db_version );
	}
	
}

// Make magic happen
AddTourToDB( $tourname ) {
	
	$tour_link = WP_CONTENT_URL.'/plugins/wwt-creator/tours/' . str_replace(" ", "%20", $tourname );
	$view_link = "http://www.worldwidetelescope.org/webclient/default.aspx?tour=" . $tour_link
	
	/* sample view link */
	// http://www.worldwidetelescope.org/webclient/default.aspx?tour=http://www.verysuperfluo.us/galaxyzoo/wp-content/plugins/wwt-creator/tours/tour-My%20journey%20through%20the%20cosmos.wtt
	
	// $wpdb->write( $view_link )
	
	
}



?>