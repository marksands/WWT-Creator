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

$wwtpluginpath = WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)).'/';

$title = '';
$description = '';
$author = '';
$email = '';
$audio = '';
$tours = array();

function wwt_meta()
{ ?>		
	<h2> WorldWide Telescope Tour Creator </h2>
	<form action="<?php echo $PHP_SELF;?>" method="post" id="tour-form" enctype="multipart/formdata">
		<?php include_once($wwtpluginpath . 'includes/tour_info.html.php') ?>
		<?php include_once($wwtpluginpath . 'includes/add_galaxy.html.php') ?>
		<?php include_once($wwtpluginpath . 'includes/upload_music.html.php') ?>
		<?php include_once($wwtpluginpath . 'includes/save_tour.html.php') ?>
	</form>
	
<?php }

if( $_POST['title'] ) {

	// http://debuggable.com/posts/parsing-xml-using-simplexml:480f4dfe-6a58-4a17-a133-455acbdd56cb
	$xml = simplexml_load_file(WP_CONTENT_DIR.'/plugins/wwt-creator/tour2.xml');
	foreach($xml as $stops) {
		foreach( $stops as $stop) {
			$tours[] = array( 
				'duration' => '00:00:10',
				'ra' => $stop->RA,
				'dec' => $stop->Dec,
				'zoomlevel' => '0.1'
			);
		}
	}
	
	$audio = UploadMusic();

	$title = $_REQUEST['title'];
	$description = $_REQUEST['description'];
	$author = $_REQUEST['author'];
	$email = $_REQUEST['email'];
	
	$info = array( 
		'title' => $title,
		'description' => $description
	);
	
	toXML( $title, $description, $author, $email, $tours, $audio );
	getTourFromXML( $info, $audio );
}

?>