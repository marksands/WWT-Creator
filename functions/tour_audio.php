<?php

// TODO: validation!!!1!!!cos(0)!!
function UploadMusic() {

	$path = WP_PLUGIN_DIR . '/wwt-creator/tours/' . $_FILES['audio-file']['name'];

	 if ( $_FILES['audio-file']['type'] == "audio/mpeg" )
		move_uploaded_file($_FILES['audio-file']['tmp_name'], $path);	

	if ( $_FILES['audio-file']['name'] != NULL )
		$webPath = WP_PLUGIN_URL.'/wwt-creator/tours/' . str_replace(" ", "%20", $_FILES['audio-file']['name'] );
	else
		$webPath = "";

	return $webPath;
}

?>