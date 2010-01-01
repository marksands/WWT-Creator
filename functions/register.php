<?php	

	// $_GET wrapper
	function GET($name, $default=null) {
		if ( isset($_GET[$name]) )
			return $_GET[$name];
		return $default;
	}

	// $_POST wrapper
	function POST($name, $default=null) {
		if ( isset($_POST[$name]) )
			return $_POST[$name];
		return $default;
	}

	// $_REQUEST wrapper
	function REQUEST($name, $default=null) {
		if ( isset($_REQUEST[$name]) )
			return $_REQUEST[$name];
		return $default;
	}



/*

	Mark, it's not getting any of the 'data' callback from the ajax response.
	So, figure out why either jquery isn't loading the data or the php file
	isn't picking up the response. Either way this sucks :( and I might cry.
	I was hoping to have this finished tonight. Maybe tomorrow? We'll see.

*/

		$ras  = explode( ",", POST('ra') );
		$decs = explode( ",", POST('dec'));

		for( $i = 0; $i < sizeof($ras); ++$i ) {
			$galaxies[] = array( 'ra'  => $ras[$i], 'dec' => $decs[$i] );
		}
		
?>