<?php
function write_vars( &$title, &$description, &$author, &$email, &$galaxies, &$tours ) {
	
	$title = $_REQUEST['title'];
	$description = $_REQUEST['description'];
	$author = $_REQUEST['author'];
	$email = $_REQUEST['email'];
	
	foreach ( $galaxies as $gal )
	{
		$tours[] = array(
			  'duration' => '00:00:10',     //$_REQUEST['Duration'];
			  'ra' => $gal['ra'],
			  'dec' => $gal['dec'],
			  'zoomlevel' => '0.1'          //$_REQUEST['ZoomLevel'];
			);
	}
}

function wwt_write_to_xml_test(	&$title, &$description, &$author, &$email, &$galaxies, &$tours, &$audio ) {  

	$doc = new DOMDocument(); 
	$doc->formatOutput = true; 

	$url = "galaxyzoo.org";
	$team = "galaxyzoo";

	$r = $doc->createElement( "Tour" ); /* <Tour> */
	$doc->appendChild( $r );
	
	
	$titleHandle = $doc->createElement( "Title" ); /* <Title> */
	$titleHandle->appendChild(
		$doc->createTextNode( $title )
	);
	$r->appendChild( $titleHandle );	/* </Title> */
	
	$descriptionHandle = $doc->createElement( "Description" ); /* <Description> */
	$descriptionHandle->appendChild(
		$doc->createTextNode( $description )
	);
	$r->appendChild( $descriptionHandle );	/* </Description> */
	
	$authorHandle = $doc->createElement( "Author" ); /* <Author> */
	$authorHandle->appendChild(
		$doc->createTextNode( $author )
	);
	$r->appendChild( $authorHandle );	/* </Author> */
	
	$emailHandle = $doc->createElement( "Email" ); /* <Email> */
	$emailHandle->appendChild(
		$doc->createTextNode( $email )
	);
	$r->appendChild( $emailHandle );	/* </Email> */
	
	$urlHandle = $doc->createElement( "OrganizationURL" ); /* <OrganizationURL> */
	$urlHandle->appendChild(
		$doc->createTextNode( $url )
	);
	$r->appendChild( $urlHandle );	/* </OrganizationName> */
	
	$teamHandle = $doc->createElement( "OrganizationName" ); /* <OrganizationName> */
	$teamHandle->appendChild(
		$doc->createTextNode( $team )
	);
	$r->appendChild( $teamHandle );	/* </OrganizationName> */
	
	
	$q = $doc->createElement( "TourStops" ); /* <TourStops> */
	$doc->appendChild( $q );
	
	foreach( $tours as $tour )
	{
		$b = $doc->createElement( "TourStop" ); /* <TourStop> */

		$duration = $doc->createElement( "Duration" ); /* <Duration> */
		$duration->appendChild(			$doc->createTextNode( $tour['duration'] )		);
		$b->appendChild( $duration );	/* </Duration> */

		$RA = $doc->createElement( "RA" ); /* <RA> */
		$RA->appendChild(			$doc->createTextNode( $tour['ra'] )		);
		$b->appendChild( $RA );	/* </RA> */

		$Dec = $doc->createElement( "Dec" ); /* <Dec> */
		$Dec->appendChild(			$doc->createTextNode( $tour['dec'] )		);
		$b->appendChild( $Dec );	/* </Dec> */
		
		$Dec = $doc->createElement( "ZoomLevel" ); /* <ZoomLevel> */
		$Dec->appendChild(			$doc->createTextNode( $tour['zoomlevel'] )		);
		$b->appendChild( $Dec );	/* </ZoomLevel> */
		
		$q->appendChild( $b ); /* </TourStop> */
	}
	
	$r->appendChild( $q ); /* end </TourStops> */
	
	$music = $doc->createElement( "MusicTrack" ); /* <MusicTrack> */
	
	$mufname = $doc->createElement( "Filename" ); /* <Filename> */
	$mufname->appendChild(		$doc->createTextNode( $audio)	);
	$music->appendChild( $mufname ); /* </Filename> */
	
	$r->appendChild( $music ); /* </MusicTrack> */
	
	
	$voice = $doc->createElement( "VoiceTrack" ); /* <VoiceTrack> */
	
	$vfname = $doc->createElement( "Filename" ); /* <Filename> */
	$vfname->appendChild(		$doc->createTextNode( "voice_track.wma" )	);
	$voice->appendChild( $vfname ); /* </Filename> */
	
	$r->appendChild( $voice ); /* </VoiceTrack> */
	
	$path = WP_CONTENT_DIR.'/plugins/'.'wwt-creator/';
	$doc->save( $path . "tour.xml" );
}

?>