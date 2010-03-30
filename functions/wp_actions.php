<?php

add_action('admin_head','addHeaderCode');
function addHeaderCode() {
	echo '<link type="text/css" rel="stylesheet" href="' . WP_PLUGIN_URL . '/wwt-creator/css/main.css" />' . "\n";	

	echo '<script type="text/javascript" src="' . WP_PLUGIN_URL . '/wwt-creator/js/jquery-1.4.2.min.js"></script>';
	echo '<script type="text/javascript" src="' . WP_PLUGIN_URL . '/wwt-creator/js/jquery-ui-1.8.custom.min.js"></script>';
	echo '<script type="text/javascript" src="' . WP_PLUGIN_URL . '/wwt-creator/js/jquery.colorbox.js"></script>';
	
	echo '<script type="text/javascript" src="' . WP_PLUGIN_URL . '/wwt-creator/js/messier_catalog.min.js"></script>';
	echo '<script type="text/javascript" src="' . WP_PLUGIN_URL . '/wwt-creator/js/ag-methods.js" ></script>';	
}

add_action('admin_menu', 'WWTMenu');
function WWTMenu() {
	//	add_submenu_page('options-general.php', 'WorldWide Telescope', 'WWT Tour Creator', 1, 'WWT Tour Creator', 'wwt_meta');
	add_submenu_page('post-new.php', "Posts", "WWT Tour Creator", 1, "WWT Tour Creator", "wwt_meta"); 	 
	add_meta_box('wwt-archive', 'WorldWide Telescope Tour Archive', 'TourArchive', 'post');
}  

add_action('wp_ajax_permDeleteTour', 'perm_delete_tour');
function perm_delete_tour()
{
	global $post;

	$id = $_POST['c'][0];
	$name = $_POST['c'][1];
	$tourfile = TourFromName( $name );

	$file_to_delete = WP_CONTENT_DIR . '/plugins/wwt-creator/tours/' . $tourfile;
	
	if ( is_file($file_to_delete) ) {
		unlink($file_to_delete);
	}

	echo $id;
	exit;	
}

add_action('wp_ajax_linkTour', 'link_Tour');
function link_Tour()
{
	global $post;
	
	$id = $_POST['c'];
	$tourfile = TourFromName( $id );
		
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
	$tourfile = TourFromName( $id );
	
	$tour_link = WP_CONTENT_URL.'/plugins/wwt-creator/tours/' . str_replace(" ", "%20", $tourfile );
	$embed = "<script type='text/javascript'>var wwtView;function loadTour(a){switch(a){case 1:wwtView.LoadTour('$tour_link');document.getElementById('playing').value='Playing Tour';break}document.getElementById('tour1').disabled=true;document.getElementById('restart').disabled=false;document.getElementById('stop').disabled=false}function stopTour(){wwtView.StopTour();document.getElementById('tour1').disabled=false;document.getElementById('restart').disabled=true;document.getElementById('stop').disabled=true;document.getElementById('playing').value='No tour currently playing'}function restartTour(){wwtView.PlayTour()}function wwtReady(){wwtView=document.getElementById('WWTView').content.WWT}</script>
						<table border='1' bgcolor='lightgrey'><tbody><tr><td><div id='WorldWideTelescopeControlHost'><object id='WWTView' classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' width='480' height='342' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0'><param name='source' value='http://www.worldwidetelescope.org/webclient/WWTSL.xap' /><param name='background' value='black' /><param name='minRuntimeVersion' value='2.0.31005.0' /><param name='autoUpgrade' value='true' /><param name='initParams' value='NoUI=false,wtml=,webkey=AX2011Gqqu' /><param name='enableHtmlAccess' value='true' /><embed id='WWTView' type='application/x-shockwave-flash' width='480' height='342' enablehtmlaccess='true' initparams='NoUI=false,wtml=,webkey=AX2011Gqqu' autoupgrade='true' minruntimeversion='2.0.31005.0' background='black' source='http://www.worldwidetelescope.org/webclient/WWTSL.xap'></embed></object></div></td></tr><tr><td><input id='tour1' onclick='loadTour(1);' type='button' value='Load Tour' /> <input id='playing' type='text' value='No tour currently playing' /></td></tr></tbody></table>";

	echo $embed;
	exit;
}

add_action('wp_ajax_writeRaDec', 'write_ra_dec');
function write_ra_dec() {
	$ras  = explode( ",", $_POST['ra'] );
	$decs = explode( ",", $_POST['dec']);

	$galaxies = array();

	for( $i = 0; $i < sizeof($ras); ++$i ) {
		$galaxies[] = array( 'ra' => $ras[$i], 'dec' => $decs[$i] );
	}

	$xmltext = "<?xml version=\"1.0\"?>\n<Tour></Tour>";
	$xmlobj = simplexml_load_string($xmltext);

	$TourStopsTag = $xmlobj->addChild( "TourStops" );
	foreach( $galaxies as $gal ) {
		$TourStopTag = $TourStopsTag->addChild( "TourStop" );	
			$TourStopTag->addChild( "RA", $gal['ra'] );
			$TourStopTag->addChild( "Dec", $gal['dec'] );
	}

	$source = WP_PLUGIN_DIR . '/wwt-creator/tour2.xml';
	
	$dom = new DOMDocument('1.0');
	$dom->preserveWhiteSpace = false;
	$dom->formatOutput = true;
	$dom->loadXML($xmlobj->asXML());	
	$dom->save( $source );
}


add_action('admin_head', 'wtt_javascript_head');
function wtt_javascript_head() { 
?>
	<script type="text/javascript">
	//<![CDATA[
	function HardLinkTour(name) {
	    jQuery.post("<?php echo get_option('siteurl'); ?>/wp-admin/admin-ajax.php",
	        {action:"linkTour", "c":name, "cookie": encodeURIComponent(document.cookie)},
	        function(str) {
						if ( jQuery('#edButtonPreview').hasClass('active') ) {
							var ibod = jQuery('#content_ifr').contents().find('body');
							jQuery(ibod).html( jQuery(ibod).html() + str );
						} else {
							jQuery('#content').val( jQuery('#content').val() + str );
						}
	        });
	}
 
 
	function EmbedCodeTour(name) {
	    jQuery.post("<?php echo get_option('siteurl'); ?>/wp-admin/admin-ajax.php",
	        {action:"embedTour", "c":name, "cookie": encodeURIComponent(document.cookie)},
	        function(str) {
						if ( jQuery('#edButtonPreview').hasClass('active') ) {
							var ibod = jQuery('#content_ifr').contents().find('body');
							jQuery(ibod).html( jQuery(ibod).html() + str );
						} else {
							jQuery('#content').val( jQuery('#content').val() + str );
						}
	        });
	}
	
	function PermDeleteTour(id, name) {
			if ( confirm("Are you sure you want to delete the tour?") ) {
		    jQuery.post("<?php echo get_option('siteurl'); ?>/wp-admin/admin-ajax.php",
		        {action:"permDeleteTour", "c[]":[id, name], "cookie": encodeURIComponent(document.cookie)},
		        function(str) {
							jQuery('#tour_file_id_'+str).remove();
		        });
			}
	}
	
	
	jQuery(function() {
		jQuery("#wwt-save-button").click(function(e) {

			var raVals  = new Array();
			var decVals = new Array();

			jQuery("input[id^='ra']").each(function() {
				raVals.push( jQuery(this).val() );
			}); raVals.pop();
			jQuery("input[id^='dec']").each(function() {
				decVals.push( jQuery(this).val() );
			}); decVals.pop();
											
			jQuery.post("<?php echo get_option('siteurl'); ?>/wp-admin/admin-ajax.php",
	        {action:"writeRaDec",
						"ra":raVals.join(','),
						"dec":decVals.join(','),
						"cookie":encodeURIComponent(document.cookie)},
	        function(str) {
						jQuery('#tour-form').submit();
	        });
		});
	});
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
		<!--
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
		-->

		<!--  Outer Header thingy-->
		<!-- <table id="newmeta"> -->
		<table>

		<!--
		<thead> 
			<tr> 
				<th class="left">Tour Name</th> 
				<th>Click to Embed</th> 
				<th>Click to Link</th> 
				<th>Delete Tour</th>
			</tr> 
		</thead>
		-->

		<!-- <tbody>  -->
		';
			  $results = ReadTourFiles();

				$i = 0;
				foreach ( $results as $res )
				{
					$nm = shorten($res);
					echo
					"
						<div class='tour_block' id='tour_file_id_$i'>
							<h2>$nm</h2>
							<a href='#' onClick='PermDeleteTour($i, \"".$res."\"); return false;' ><span class='deltourimg' ></span></a>
							<br style='clear:both;' />
							<a href='#' onClick='EmbedCodeTour(\"$res\"); return false;'><span class='tourstylebtn' >Embed</span></a>
							<a href='#' onClick='HardLinkTour(\"$res\"); return false;'><span class='tourstylebtn' >Link</span></a>
						</div>
					";
					$i++;
				}
				
		echo '
			
			<!-- </tbody> -->
		</table>
		</div>
	
	';

	// nifty links for the developer: 
	// 	- Authoring, tour sound files: http://worldwidetelescope.org/authoring/Authoring.aspx?Page=TourResources
	// 	- WWT Complete: http://worldwidetelescope.org/COMPLETE/WWTCoverageTool.htm
}

/*
 * Returns the tour url from
 * the specified name
 *
 */
function TourFromName( $name ) {
	$retval = 'tour-' . $name . '.wtt';

	return $retval;
}

/*
 * Returns the tour url from 
 * the specified id, where the
 * id is the position in the
 * array of glob'd tour files
 * 
 * - NOTE - this function
 * has been deprecated and
 * is no longer in use
 *
 */
function TourFromId( $id ) {	
	$name = array();
	$name = ReadTourFiles();
	
	$retval = 'tour-' . $name[ $id ] . '.wtt';

	return $retval;
}

/*
 * Returns an array of
 * all the tour files
 * in the tours directory
 *
 */
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

/*
 * Strips the url of the 
 * tour- and the .wtt to 
 * return just the title
 *
 */
function StripTitle( $tourfile ) {
	$wtitle = str_replace("tour-", "", $tourfile );
	$wtitle = str_replace(".wtt", "", $wtitle );
	
	return $wtitle;		
}

/*
 * Shortens text to 32 characters
 *
 */
function shorten( $text ) {
			$chars = 32; 
			if(strlen($text) <= $chars)
				return $text;
			
			$text = $text . " "; 
			$text = substr($text,0,$chars); 
			$text = substr($text,0,strrpos($text,' ')); 
			$text = $text . "..."; 

			return $text;
}


?>
