<?php

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
   
	echo '<link type="text/css" rel="stylesheet" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/wwt-creator/css/main_beta.css" />' . "\n";

//	$effectscore = WP_CONTENT_URL.'/plugins/wwt-creator/js/jquery/effects.core.js';
//	$effectshighlight = WP_CONTENT_URL.'/plugins/wwt-creator/js/jquery/effects.highlight.js';

//	wp_enqueue_script( "myJquery", $effectscore );
//	wp_enqueue_script( "myJquery", $effecthighlight );
	
//	echo '<script type="text/javascript" src="'.$effectscore.'" ></script>';
//	echo '<script type="text/javascript" src="'.$effectshighlight.'" ></script>';

//	echo '<script type="text/javascript" src="http://jquery-ui.googlecode.com/svn/tags/latest/ui/effects.core.js" ></script>';
//	echo '<script type="text/javascript" src="http://jquery-ui.googlecode.com/svn/tags/latest/ui/effects.highlight.js" ></script>';
}

function addInitCode() {
	
//	$effectscore = WP_CONTENT_DIR.'/plugins/wwt-creator/js/jquery/effects.core.js';
//	$effectshighlight = WP_CONTENT_DIR.'/plugins/wwt-creator/js/jquery/effects.highlight.js';

//	wp_enqueue_script( "myJquery", $effectscore );
//	wp_enqueue_script( "myJquery", $effecthighlight );
	
//	echo '<script type="text/javascript" src="'.$effectscore.'" ></script>';
//	echo '<script type="text/javascript" src="'.$effectshighlight.'" ></script>';

//	echo '<script type="text/javascript" src="http://ui.jquery.com/latest/ui/effects.hightlight.js" ></script>';
//	echo '<script type="text/javascript" src="http://ui.jquery.com/latest/ui/effects.core.js" ></script>';

}


?>