<?php
	/*
	Plugin Name: WWT Dynamic Tour Creator
	Plugin URI: http://www.galaxyzoo.org
	Description: Plugin for dynamically creating tours for interaction within Microsoft Worldwide Telescope
	Author: Mark Sands & Jarod Luebbert
	Version: 1.0
	Author URI: http://www.galaxyzoo.org
	*/

require_once('functions/audio.php');
require_once('functions/functionIncludes.php');
require_once('functions/getTourFromXML.php');
require_once('functions/XMLGenerator.php');

add_action('init', 'addInitCode');	
add_action('admin_head','addHeaderCode');
add_action('admin_menu', 'WWTMenu');

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
	<form action="<?php echo $PHP_SELF;?>" method="post" id="tour-form" enctype="multipart/formdata">
		<?php include_once($wwtpluginpath . 'includes/tour_info.html.php') ?>
		<?php include_once($wwtpluginpath . 'includes/add_galaxy.html.php') ?>
		<?php include_once($wwtpluginpath . 'includes/upload_music.html.php') ?>
		<?php include_once($wwtpluginpath . 'includes/save_tour.html.php') ?>
	</form>
	
<?php }




// TODO: Fix embarassing code
// bruteforce tour objects
if( GET('ra') ) {
	
	for ( $i = 0; $i < 999; $i++ ) {
		$raid = 'ra' . $i;
		$decid = 'dec' . $i;
	
		$raval = GET($raid); 
		$decval = GET($decid);
	 
		if ( $raval != null && $decval != null)
			$galaxies[] = array('ra' => $raval, 'dec' => $decval);
	}

	$audio = UploadMusic();
	
	writeToVariables( $title, $description, $author, $email, $galaxies, $tours );	
	toXML( $title, $description, $author, $email, $galaxies, $tours, $audio );
	
	$info = array( 
		'title' => $title,
		'description' => $description
	);
	
	getTourFromXML( $info, $audio );
}

?>