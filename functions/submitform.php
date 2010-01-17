<?php

// AJAX Request Handler
if( $_POST ) {
		
	$audio = UploadMusic();

	$title = $_REQUEST['title'];
	$description = $_REQUEST['description'];
	$author = $_REQUEST['author'];
	$email = $_REQUEST['email'];
	
	foreach ( $galaxies as $gal ) {
		$tours[] = array(
			  'duration' => '00:00:10',
			  'ra' => $gal['ra'],
			  'dec' => $gal['dec'],
			  'zoomlevel' => '0.1'
			);
	}
	
	$info = array( 
		'title' => $title,
		'description' => $description
	);
	
	toXML( $title, $description, $author, $email, $galaxies, $tours, $audio );
	getTourFromXML( $info, $audio );
}

?>