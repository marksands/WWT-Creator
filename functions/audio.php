<?php

$musicDir = WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)).'/tours/';

// TODO: validation
function UploadMusic() {

  //	if (($_FILES["audio-file"]["type"] == "audio/mp3") || ($_FILES["audio-file"]["type"] == "audio/wav") || ($_FILES["audio-file"]["type"] == "audio/aiff"))
	
	echo "\nThis is the audio file format: " . $_FILES["audio-file"]["name"] . "\n";
	move_uploaded_file($_FILES["audio-file"]["tmp_name"], $musicDir . $_FILES["audio-file"]["name"]);
	
	if (!file_exists( $musicDir . $_FILES["audio-file"]["name"])) {
		move_uploaded_file($_FILES["audio-file"]["tmp_name"], $musicDir . $_FILES["audio-file"]["name"]);
	}
	else { 
		return "";
	}

	$path = $musicDir . $_FILES["audio-file"]["name"];
	return $path;
}

?>