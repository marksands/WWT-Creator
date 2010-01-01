<?php	

	// $_POST wrapper
	function POST($name, $default=null) {
		if ( isset($_POST[$name]) )
			return $_POST[$name];
		return $default;
	}

	$tour_id = POST('tour');

	$path = WP_CONTENT_DIR.'/plugins/'.'wwt-creator/';
	$tourDir = $path . 'tours/';

  $results = array();

	if ($handle = opendir($tourDir)) {
	    while ($file = readdir($handle)) {
	        if ($file != '.' && $file != '..') {
	            $results[] = $file;
	        }
	    }
	    closedir($handle);
	}
	
	unlink( $results[ $tour_id ] );
		
?>