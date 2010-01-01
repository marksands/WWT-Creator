<?php
	/*
	Plugin Name: WorldWide Telescope Tour Creator
	Plugin URI: http://www.cosmicremnants.com
	Description: Plugin for dynamically creating tours for interaction within Microsoft Worldwide Telescope
	Author: Mark Sands & Jarod Luebbert
	Version: 1.0
	Author URI: http://www.galaxyzoo.org
	*/

require_once('functions/audio.php');
require_once('functions/functionIncludes.php');
require_once('functions/getTourFromXML.php');
require_once('functions/XMLGenerator.php');
require_once('test.php');

add_action('init', 'addInitCode');	
add_action('admin_head','addHeaderCode');
add_action('admin_menu', 'WWTMenu');

$wwtpluginpath = WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)).'/';

global $title = '';
global $description = '';
global $author = '';
global $email = '';
global $tours = array();
global $galaxies = array();
global $audio = '';

$tour_objects_id = array();


function wwt_meta()
{ ?>		
	<h2> Worldwide Telescope Tour Creator </h2>
	<form action="<?php echo $PHP_SELF; ?>" method="post" id="tour-form" enctype="multipart/formdata">
		<?php include_once($wwtpluginpath . 'includes/tour_info.html.php') ?>
		<?php include_once($wwtpluginpath . 'includes/add_galaxy.html.php') ?>
		<?php include_once($wwtpluginpath . 'includes/upload_music.html.php') ?>
		<?php include_once($wwtpluginpath . 'includes/save_tour.html.php') ?>
	</form>
	
<?php }


// VERY VERT TESTING ONLY!
// refactored to handle AJAX request
if( POST('title') ) {
	
	$audio = UploadMusic();

	$title = POST('title');
	$description = POST('description');
	$author = POST('author');
	$email = POST('email');
	
	foreach ( $galaxies as $gal )
	{
		$tours[] = array(
			  'duration' => '00:00:10',
			  'ra' => $gal['ra'],
			  'dec' => $gal['dec'],
			  'zoomlevel' => '0.1'
			);
	}
	
	toXML( $title, $description, $author, $email, $galaxies, $tours, $audio );
	
	$info = array( 
		'title' => $title,
		'description' => $description
	);
	
	getTourFromXML( $info, $audio );
}

?>