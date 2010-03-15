<?php
	/*
	Plugin Name: WorldWide Telescope Tour Creator
	Plugin URI: http://www.cosmicremnants.com
	Description: Dynamically create sky tours for interaction within Microsoft Worldwide Telescope
	Author: Mark Sands & Jarod Luebbert
	Version: 1.0
	Author URI: http://www.galaxyzoo.org
	*/

$wwt_title = '';
$wwt_description = '';
$wwt_author = '';
$wwt_email = '';
$wwt_audio = '';
$tours = array();
$galaxies = array();

require('functions/tour_audio.php');
require('functions/wp_actions.php');
require('functions/tour_gen.php');
require('functions/xml_gen.php');

$wwtpluginpath = WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)).'/';

function wwt_meta()
{ ?>		
	<h2> WorldWide Telescope Tour Creator </h2>
	<form action="<?php echo $PHP_SELF ?>" method="post" id="tour-form" enctype="multipart/formdata">
		<?php include_once($wwtpluginpath . 'includes/tour_info.html.php') ?>
		<?php include_once($wwtpluginpath . 'includes/add_galaxy.html.php') ?>
		<?php include_once($wwtpluginpath . 'includes/upload_music.html.php') ?>
		<?php include_once($wwtpluginpath . 'includes/save_tour.html.php') ?>
	</form>
	
<?php }


if( $_POST['wwt_title'] ) {

	// http://debuggable.com/posts/parsing-xml-using-simplexml:480f4dfe-6a58-4a17-a133-455acbdd56cb
	$xml = simplexml_load_file(WP_PLUGIN_DIR.'/wwt-creator/tour2.xml');
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
 
	$title = $_REQUEST['wwt_title'];
	$description = $_REQUEST['wwt_description'];
	$author = $_REQUEST['wwt_author'];
	
	// empty email address defaults to blogger's email
	if ( $_POST['wwt-author'] ) {
		$wwt_email = $_POST['wwt_email'];
	} else {
		$wwt_email = get_option('admin_email');
	}
	
	$info = array( 
		'title' => $title,
		'description' => $description
	);
 
	toXML( $title, $description, $author, $email, $tours, $audio );
	getTourFromXML( $info, $audio );
}

?>