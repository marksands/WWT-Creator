<?php

// TODO: validation!!!1!!!cos(0)!!
function UploadMusic() {

	$rootPath = WP_CONTENT_DIR.'/plugins/'.'wwt-creator';
	$musicDir = $rootPath . '/tours/';
	
	$path = $musicDir . $_FILES['audio-file']['name'];

	// terrible validation #sadface
  if ( $_FILES['audio-file']['type'] == "audio/mpeg" )
		move_uploaded_file($_FILES['audio-file']['tmp_name'], $path);	
	
	if ( $_FILES['audio-file']['name'] != NULL )
		$webPath = WP_CONTENT_URL.'/plugins/wwt-creator/tours/' . str_replace(" ", "%20", $_FILES['audio-file']['name'] );
	else
		$webPath = "";
	
	return $webPath;
}

?>