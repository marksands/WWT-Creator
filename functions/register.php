<?php	

if( $_POST ) {

	global $galaxies;
	
	$ras  = explode( ",", $_POST['wwtra'] );
	$decs = explode( ",", $_POST['wwtdec']);
	
	for( $i = 0; $i < sizeof($ras); ++$i ) {
		$galaxies[] = array( 'ra'  => $ras[$i], 'dec' => $decs[$i] );
	}
	
}
		
?>