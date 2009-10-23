<?php

// TODO: validation
function UploadMusic() {

	$rootPath = WP_CONTENT_DIR.'/plugins/'.'wwt-creator';
	$musicDir = $rootPath . '/tours/';
	
	$path = $musicDir . $_FILES['audio-file']['name'];

	// terrible validation, but whatever
  if ( $_FILES['audio-file']['type'] == "audio/mpeg" )
		move_uploaded_file($_FILES['audio-file']['tmp_name'], $path);	
	
	// if (!file_exists( $musicDir . $_FILES["audio-file"]["name"])) {
	// 	move_uploaded_file($_FILES["audio-file"]["tmp_name"], $musicDir . $_FILES["audio-file"]["name"]);
	// }
	// else { 
	// 	return "";
	// }
	
	$webPath = WP_CONTENT_URL.'/plugins/wwt-creator/tours/' . str_replace(" ", "%20", $_FILES['audio-file']['name'] );
	
	return $webPath;
}

?>