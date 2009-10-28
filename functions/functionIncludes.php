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
	
	$db = mysqli_connect( 'localhost', 'root', 'raidmax' );
	mysqli_select_db($db, 'test');

	$sql = "SELECT * FROM tour";
	$result = mysqli_query($db, $sql);
	$rows = mysqli_num_rows($result);
	
	?>
		<strong>Select Tour From Archive:</strong>
		<div class="inside">
		<div class="left">
		
		<select name="tour" id="tour">
	<?php
		for ($i = 0; $i < $rows; $i++) {
		  $data = mysqli_fetch_object($result);
		  echo '<option name="' . $data->title .'" style="width:20%;"> ' . $data->title .' </option>';
		}
	?>
		</select>
		</div>
		
		<div class="submit">
			<input type="submit" name="submit" value="Embed Tour" \>
		</div>
		
		</div>
		</div>
	<?php
		
	mysqli_close($db);
}

function addHeaderCode() {
	echo '<link type="text/css" rel="stylesheet" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/wwt-creator/css/main.css" />' . "\n";
}

function addInitCode() {
	
}


?>