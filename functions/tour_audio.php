<?php

	// define a constant for the maximum upload size, 500MB, fairly large
define ('MAX_FILE_SIZE', 524288000);

function UploadMusic() {

		// set handlers
	$OK = false;
	$path = WP_PLUGIN_DIR . '/wwt-creator/tours/' . $_FILES['audio-file']['name'];

		// valid file size
	if ( $_FILES['file-upload']['size'] > 0 || $_FILES['file-upload']['size'] <= MAX_FILE_SIZE ) {
		$OK = true;
	}
		
		// valid MIME types ( although I'm not sure what valid mime types the wwt software accepts )
	$permitted = array( 'audio/mpeg', 'audio/mpeg3', 'audio/x-mpeg-3', 
		'audio/mpeg', 'audio/x-mpeg', 'audio/mp3',
		'audio/x-mp3', 'audio/mpeg3', 'audio/x-mpeg3',
		'audio/mpg', 'audio/x-mpg', 'audio/x-mpegaudio',
		'audio/basic', 'audio/mid', 'audio/x-aiff',
		'audio/x-aiff', 'audio/x-aiff', 'audio/x-mpegurl',
		'audio/x-pn-realaudio', 'audio/x-pn-realaudio', 'audio/x-wav'
	);
	
 		// check that file is of an permitted MIME type
	foreach ($permitted as $type) {
		if ( $type == $_FILES['file-upload']['type'] ) {
			$OK = true;
			break;
		}
	}
	
		// default empty path if not found
	$webPath = "";
		
	if ( $OK && $_FILES['audio-file']['name'] != NULL ) {
		move_uploaded_file($_FILES['audio-file']['tmp_name'], $path);	
		$webPath = WP_PLUGIN_URL.'/wwt-creator/tours/' . urlencode( $_FILES['audio-file']['name'] );
	}

	return $webPath;
}

?>