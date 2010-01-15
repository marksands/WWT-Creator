<?php
	/*
	Plugin Name: WorldWide Telescope Tour Creator
	Plugin URI: http://www.cosmicremnants.com
	Description: Dynamically create sky tours for interaction within Microsoft Worldwide Telescope
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
$audio = '';
$tours = array();
$galaxies = array();

function wwt_meta()
{ ?>		
	<h2> Worldwide Telescope Tour Creator </h2>
	<form action="<?php echo WP_PLUGIN_URL.'/wwt-creator/wwt-creator.php' ?>" method="post" id="tour-form" enctype="multipart/formdata">
		<?php include_once($wwtpluginpath . 'includes/tour_info.html.php') ?>
		<?php include_once($wwtpluginpath . 'includes/add_galaxy.html.php') ?>
		<?php include_once($wwtpluginpath . 'includes/upload_music.html.php') ?>
		<?php include_once($wwtpluginpath . 'includes/save_tour.html.php') ?>
	</form>
	
<?php }

$path = './';
$crazy = $path . 'crzy.txt';
$fh = fopen($crazy, 'wrb');
$r = "eating out your asshole";
fwrite($fh, $r);
fclose($fh);


// VERY VERT TESTING ONLY!
// refactored to handle AJAX request
if( $_REQUEST['title'] ) {
	
	$path = './';
	$crazy = $path . 'crzy.txt';
	$fh = fopen($crazy, 'wrb');
	$r = "requesting title..";
	fwrite($fh, $r);
	fclose($fh);
	
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