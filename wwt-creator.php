<?php
	/*
	Plugin Name: WWT Dynamic Tour Creator
	Plugin URI: http://www.galaxyzoo.org
	Description: Plugin for dynamically creating tours for interaction within Microsoft Worldwide Telescope
	Author: Mark Sands & Jarod Luebbert
	Version: 0.3a
	Author URI: http://www.galaxyzoo.org
	*/

require_once('functions/xml2wwt.php');
require_once('functions/functions.php');
require_once('functions/header_functions.php');
require_once('functions/audio.php');

add_action('init', 'addInitCode');	
add_action('admin_head','addHeaderCode');
add_action('admin_menu', 'wwt_admin_actions');
add_action('admin_menu', 'wwt_tour_archive_post');


$wwtpluginpath = WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)).'/';

$title = '';
$description = '';
$author = '';
$email = '';
$tours = array();
$galaxies = array();
$audio = '';

$tour_objects_id = array();


function wwt_meta()
{ ?>		
	<h2> Worldwide Telescope Tour Creator </h2>

	<form method="post" action="<?php echo $PHP_SELF;?>" name="tour-form" enctype="multipart/form-data">		

		<?php include_once($wwtpluginpath . 'includes/tour_info.html.php') ?>
		<?php include_once($wwtpluginpath . 'includes/add_galaxy.html.php') ?>
		<?php include_once($wwtpluginpath . 'includes/upload_music.html.php') ?>
		<?php include_once($wwtpluginpath . 'includes/save_tour.html.php') ?>
	
	</form>
	
<?php }



// TODO: Make this feature work
if( isset( $_REQUEST['ra'] ) ) {
	
	for ( $i = 0; $i < 999; $i++ ) {
		$raid = 'ra' . $i;
		$decid = 'dec' . $i;
	
		$raval = $_REQUEST[$raid]; 
		$decval = $_REQUEST[$decid];
	 
		if ( $raval != null && $decval != null)
			$galaxies[] = array('ra' => $raval, 'dec' => $decval);
	}
	
	echo "\nThis is the audio file format: " . $_FILES["audio-file"]["name"] . "\n";
	echo "\nThis is the audio file format: " . $_FILES["audio-file"]["tmp_name"] . "\n";
	echo "\nThis is the audio file format: " . $_FILES["audio-file"]["type"] . "\n";
	
	
	$audio = UploadMusic();
	echo "\naudio return? " . $audio . "\n";
	
	write_vars( $title, $description, $author, $email, $galaxies, $tours );	
	wwt_write_to_xml_test( $title, $description, $author, $email, $galaxies, $tours, $audio );

	$info = array( 
		'title' => $title,
		'description' => $description
	);
	
	send_post_headers_xml2wwt( $info );
}

?>