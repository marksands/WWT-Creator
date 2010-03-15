<?php

// http://debuggable.com/posts/parsing-xml-using-simplexml:480f4dfe-6a58-4a17-a133-455acbdd56cb
function toXML(	&$title, &$description, &$author, &$email, &$tours, &$audio ) {  

	$url = "galaxyzoo.org";
	$team = "galaxyzoo";

	$xmltext = "<?xml version=\"1.0\"?>\n<Tour></Tour>";
	$xmlobj = simplexml_load_string($xmltext);

	$xmlobj->addChild( "Title", $title );
	$xmlobj->addChild( "Description", $description );
	$xmlobj->addChild( "Author", $author );
	$xmlobj->addChild( "Email", $email );
	$xmlobj->addChild( "OrganizationURL", $url );
	$xmlobj->addChild( "OrganizationName", $team );

	$TourStopsTag = $xmlobj->addChild( "TourStops" );
	foreach( $tours as $tour ) {
		$TourStopTag = $TourStopsTag->addChild( "TourStop" );	
			$TourStopTag->addChild( "Duration", $tour['duration'] );
			$TourStopTag->addChild( "RA", $tour['ra'] );
			$TourStopTag->addChild( "Dec", $tour['dec'] );
			$TourStopTag->addChild( "ZoomLevel", $tour['zoomlevel'] );
	}

	$MusicTag = $xmlobj->addChild( "MusicTrack" );
		$MusicTag->addChild( "Filename", $audio );
	$VoiceTag = $xmlobj->addChild( "VoiceTrack" );
		$VoiceTag->addChild( "Filename", "" );

	$path = WP_CONTENT_DIR.'/plugins/'.'wwt-creator/';
		
	$dom = new DOMDocument('1.0');
	$dom->preserveWhiteSpace = false;
	$dom->formatOutput = true;
	$dom->loadXML($xmlobj->asXML());
	$dom->save( $path . "tour.xml" );
}

?>