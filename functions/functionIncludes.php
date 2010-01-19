<?php

add_action('admin_menu', 'WWTMenu');
function WWTMenu() {
	//add_submenu_page('options-general.php', 'WorldWide Telescope', 'WWT Tour Creator', 1, 'WWT Tour Creator', 'wwt_meta');
	add_submenu_page('post-new.php', "Posts", "WWT Tour Creator", 1, "WWT Tour Creator", "wwt_meta"); 	 
	add_meta_box('wwt-archive', 'WorldWide Telescope Tour Archive', 'TourArchive', 'post');
}  

add_action('wp_ajax_linkTour', 'link_Tour');
function link_Tour()
{
	global $post;
	
	$id = $_POST['c'];
	$tourfile = TourFromId( $id );
		
	$tour_link = WP_CONTENT_URL.'/plugins/wwt-creator/tours/' . str_replace(" ", "%20", $tourfile );
	$view_link = "<a href='http://www.worldwidetelescope.org/webclient/default.aspx?tour=$tour_link'>Link to Tour</a>";
	
	echo $view_link;
  exit;
}

add_action('wp_ajax_embedTour', 'embed_Tour');
function embed_Tour()
{
	global $post;
	
	$id = $_POST['c'];
	$tourfile = TourFromId( $id );
	
	$tour_link = WP_CONTENT_URL.'/plugins/wwt-creator/tours/' . str_replace(" ", "%20", $tourfile );
	$embed = "<script type='text/javascript'>var wwtView;function loadTour(a){switch(a){case 1:wwtView.LoadTour('.$tour_link.');document.getElementById('playing').value='Playing Tour';break}document.getElementById('tour1').disabled=true;document.getElementById('restart').disabled=false;document.getElementById('stop').disabled=false}function stopTour(){wwtView.StopTour();document.getElementById('tour1').disabled=false;document.getElementById('restart').disabled=true;document.getElementById('stop').disabled=true;document.getElementById('playing').value='No tour currently playing'}function restartTour(){wwtView.PlayTour()}function wwtReady(){wwtView=document.getElementById('WWTView').content.WWT}</script>
						<table border='1' bgcolor='lightgrey'><tbody><tr><td><div id='WorldWideTelescopeControlHost'><object id='WWTView' classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' width='480' height='342' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0'><param name='source' value='http://www.worldwidetelescope.org/webclient/WWTSL.xap' /><param name='background' value='black' /><param name='minRuntimeVersion' value='2.0.31005.0' /><param name='autoUpgrade' value='true' /><param name='initParams' value='NoUI=false,wtml=,webkey=AX2011Gqqu' /><param name='enableHtmlAccess' value='true' /><embed id='WWTView' type='application/x-shockwave-flash' width='480' height='342' enablehtmlaccess='true' initparams='NoUI=false,wtml=,webkey=AX2011Gqqu' autoupgrade='true' minruntimeversion='2.0.31005.0' background='black' source='http://www.worldwidetelescope.org/webclient/WWTSL.xap'></embed></object></div></td></tr><tr><td><input id='tour1' onclick='loadTour(1);' type='button' value='Load Tour' /> <input id='playing' type='text' value='No tour currently playing' /></td></tr></tbody></table>";

	echo $embed;
	exit;
}


add_action('admin_head', 'tour_link_head');
function tour_link_head() { 
?>
	<style type="text/css" media="screen">
	<!--
	.fake_css_class {
		
	}
	-->
	</style>
	<script type="text/javascript">
	//<![CDATA[
	function HardLinkTour(id) {
	    jQuery.post("<?php echo get_option('siteurl'); ?>/wp-admin/admin-ajax.php",
	        {action:"linkTour", "c":id, "cookie": encodeURIComponent(document.cookie)},
	        function(str)   {
							jQuery('#content').append(str)
	        });
	}

	function EmbedCodeTour(id) {
	    jQuery.post("<?php echo get_option('siteurl'); ?>/wp-admin/admin-ajax.php",
	        {action:"embedTour", "c":id, "cookie": encodeURIComponent(document.cookie)},
	        function(str)   {
						jQuery('#content').append(str)
	        });
	}

	//]]>
	</script>

<?php
} // function

// Called via  add_action('admin_menu', 'WWTMenu'); > WWTMenu();
function TourArchive() { 
	
	echo '
		<div id="postcustomstuff">
		<div id="ajax-respone"></div>
		
		<p><strong>Select from tour archive:</strong></p> 

		<!--  Inner List -->
		<table id="list-table" style="display: none;"> 
			<thead> 
			<tr> 
				<th class="left">Tour Name</th> 
				<th>Clik to Embed</th> 
				<th>Clidk to Link</th>
				<th>Delete Tour</th>
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
				<th class="left">Tour Name</th> 
				<th>Click to Embed</th> 
				<th>Click to Link</th> 
				<!-- <th>Delete Tour</th> -->
			</tr> 
		</thead> 

		<tbody> 
				
		';
														
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
								<input type='submit' id='embedTour' onClick='EmbedCodeTour($i); return false;' name='embed_tour' value='Embed' />
							</td>
							<td>
								<input type='submit' id='hardLinkTour' onClick='HardLinkTour($i); return false;' name='hardlink_tour' class='add:the-list:newmeta' value='Hard Link' />
							</td>
							<!--
							<td>
								<input type='submit' id='deleteTour' name='delete_tour' class='add:the-list:newmeta delTour' value='Delete'' />
							</td>
							-->
						</tr>";
						$i++;
				}
				
		echo '
			
			</tbody>
		</table>
		</div>
	
	';

	// nifty links
	// Authoring, tour sound files: http://worldwidetelescope.org/authoring/Authoring.aspx?Page=TourResources
	// WWT Complete: http://worldwidetelescope.org/COMPLETE/WWTCoverageTool.htm
}

add_action('admin_head','addHeaderCode');
function addHeaderCode() {
	echo '<link type="text/css" rel="stylesheet" href="' . WP_PLUGIN_URL . '/wwt-creator/css/main.css" />' . "\n";
	echo '<script type="text/javascript" src="../wp-content/plugins/wwt-creator/js/tourarchive.js" ></script>';
}

// Make magic happen
function EmbedCode( $tourfile ) {
	$tour_link = WP_CONTENT_URL.'/plugins/wwt-creator/tours/' . str_replace(" ", "%20", $tourfile );
	$embed = "<script type='text/javascript'>var wwtView;function loadTour(a){switch(a){case 1:wwtView.LoadTour('.$tour_link.');document.getElementById('playing').value='Playing Tour';break}document.getElementById('tour1').disabled=true;document.getElementById('restart').disabled=false;document.getElementById('stop').disabled=false}function stopTour(){wwtView.StopTour();document.getElementById('tour1').disabled=false;document.getElementById('restart').disabled=true;document.getElementById('stop').disabled=true;document.getElementById('playing').value='No tour currently playing'}function restartTour(){wwtView.PlayTour()}function wwtReady(){wwtView=document.getElementById('WWTView').content.WWT}</script>
						<table border='1' bgcolor='lightgrey'><tbody><tr><td><div id='WorldWideTelescopeControlHost'><object id='WWTView' classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' width='480' height='342' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0'><param name='source' value='http://www.worldwidetelescope.org/webclient/WWTSL.xap' /><param name='background' value='black' /><param name='minRuntimeVersion' value='2.0.31005.0' /><param name='autoUpgrade' value='true' /><param name='initParams' value='NoUI=false,wtml=,webkey=AX2011Gqqu' /><param name='enableHtmlAccess' value='true' /><embed id='WWTView' type='application/x-shockwave-flash' width='480' height='342' enablehtmlaccess='true' initparams='NoUI=false,wtml=,webkey=AX2011Gqqu' autoupgrade='true' minruntimeversion='2.0.31005.0' background='black' source='http://www.worldwidetelescope.org/webclient/WWTSL.xap'></embed></object></div></td></tr><tr><td><input id='tour1' onclick='loadTour(1);' type='button' value='Load Tour' /> <input id='playing' type='text' value='No tour currently playing' /></td></tr></tbody></table>";
	return $embed;
}

// Make more magic happen
function HardLink( $tourfile ) {
	$tour_link = WP_CONTENT_URL.'/plugins/wwt-creator/tours/' . str_replace(" ", "%20", $tourfile );
	$view_link = "http://www.worldwidetelescope.org/webclient/default.aspx?tour=" . $tour_link;
	
	return $view_link;
}

function TourFromId( $id ) {	
	$name = array();
	$name = ReadTourFiles();
	
	$retval = 'tour-' . $name[ $id ] . '.wwt';

	return $retval;
}

function ReadTourFiles() {
		$tourDir = WP_PLUGIN_DIR.'/wwt-creator/tours/';		
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
