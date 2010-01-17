<?php	

if( $_POST ) {
	
	$ras  = explode( ",", $_POST['wwtra'] );
	$decs = explode( ",", $_POST['wwtdec']);
	
	$galaxies = array();
	
	for( $i = 0; $i < sizeof($ras); ++$i ) {
		$galaxies[] = array( 'ra' => $ras[$i], 'dec' => $decs[$i] );
	}
	
	$xmltext = "<?xml version=\"1.0\"?>\n<Tour></Tour>";
	$xmlobj = simplexml_load_string($xmltext);

	$TourStopsTag = $xmlobj->addChild( "TourStops" );
	foreach( $galaxies as $gal ) {
		$TourStopTag = $TourStopsTag->addChild( "TourStop" );	
			$TourStopTag->addChild( "RA", $gal['ra'] );
			$TourStopTag->addChild( "Dec", $gal['dec'] );
	}

	$dom = new DOMDocument('1.0');
	$dom->preserveWhiteSpace = false;
	$dom->formatOutput = true;
	$dom->loadXML($xmlobj->asXML());	
	$dom->save("../tour2.xml");		
}
		
?>