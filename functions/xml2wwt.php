<?php

function send_post_headers_xml2wwt( &$info ) {
	
	// static information, bad practice to place in a function, but
	// this information shouldn't ever have to be changed..
	$server  = 'www.worldwidetelescope.org';
	$port    = '80';
	$uri     = 'http://www.worldwidetelescope.org/wwtweb/xml2wtt.aspx';
	$content = '';
	
	$path = WP_CONTENT_DIR.'/plugins/'.'wwt-creator/';
	
	if ( !$path . '/tours')
	$tourDir = $path . '/tours/';
	
	$xmlFile = $path . 'tour.xml';
	$tourFile = $tourDir . 'tour-' . $info['title'] . '.wtt';
	
	$fh = fopen($xmlFile, 'r');
	$content = fread($fh, filesize($xmlFile));
	fclose($fh);
	
	$post_results = write( $server, $port, $uri, $content );
	
	$fh = fopen($tourFile, 'w');
	fwrite($fh,$post_results);
	fclose($fh);
	
	write_to_database( $info );
}
	
function write( $server, $port, $uri, &$content ) {
    if (empty($server))     { return false; }
    if (!is_numeric($port)) { return false; }
    if (empty($uri))        { return false; }
    if (empty($content))    { return false; }
    // generate headers in array.
    $t   = array();
    $t[] = 'POST ' . $uri . ' HTTP/1.1';
    $t[] = 'Content-Type: text/xml';
    $t[] = 'Host: ' . $server . ':' . $port;
    $t[] = 'Content-Length: ' . strlen($content);
    $t[] = 'Connection: close';
    $t   = implode("\r\n",$t) . "\r\n\r\n" . $content;
    //
    // Open socket, provide error report vars and timeout of 10
    // seconds.
    //
    $fp  = @fsockopen($server,$port);
    // If we don't have a stream resource, abort.
    if (!(get_resource_type($fp) == 'stream')) { echo "no stream resource!"; return false; }
    //
    // Send headers and content.
    //
    if (!fwrite($fp,$t)) {
        fclose($fp);
        return false;
        }
    //
    // Read all of response into $rsp and close the socket.
    //
    $rsp = '';
    while(!feof($fp)) { $rsp .= fgets($fp,8192); }
    fclose($fp);

    //
    // Call parseHttpResponse() to return the results.
    //
    return parseHttpResponse($rsp);
}

//
// Accepts provided http content, checks for a valid http response,
// unchunks if needed, returns http content without headers on
// success, false on any errors.
//
function parseHttpResponse($content=null) {
    if (empty($content)) { return false; }
    // split into array, headers and content.
    $hunks = explode("\r\n\r\n",trim($content));
    if (!is_array($hunks) or count($hunks) < 2) {
        return false;
	}
    $header  = $hunks[count($hunks) - 2];
    $body    = $hunks[count($hunks) - 1];
    $headers = explode("\n",$header);
    unset($hunks);
    unset($header);	
    if (in_array('Transfer-Coding: chunked',$headers)) {
        return trim(unchunkHttpResponse($body));
	} else {
        return trim($body);
	}
}

//
// Validate http responses by checking header.  Expects array of
// headers as argument.  Returns boolean.
//
function validateHttpResponse($headers=null) {
    if (!is_array($headers) or count($headers) < 1) { return false; }
    switch(trim(strtolower($headers[0]))) {
        case 'http/1.0 100 ok':
        case 'http/1.0 200 ok':
        case 'http/1.1 100 ok':
        case 'http/1.1 200 ok':
            return true;
        break;
	}
    return false;
}

//
// Unchunk http content.  Returns unchunked content on success,
// false on any errors...  Borrows from code posted above by
// jbr at ya-right dot com.
//
function unchunkHttpResponse($str=null) {
    if (!is_string($str) or strlen($str) < 1) { return false; }
    $eol = "\r\n";
    $add = strlen($eol);
    $tmp = $str;
    $str = '';
    do {
        $tmp = ltrim($tmp);
        $pos = strpos($tmp, $eol);
        if ($pos === false) { return false; }
        $len = hexdec(substr($tmp,0,$pos));
        if (!is_numeric($len) or $len < 0) { return false; }
        $str .= substr($tmp, ($pos + $add), $len);
        $tmp  = substr($tmp, ($len + $pos + $add));
        $check = trim($tmp);
	} while(!empty($check));
    unset($tmp);
    return $str;
}


function write_to_database( &$info )
{
	$wpdatabase = 'gztest';

	$link = mysqli_connect( 'mysql.verysuperfluo.us', 'galaxyzoo', 'galaxyzoo' );

	if(!$link) {
		$error = 'Login failed! Unable to connect to database.';
		echo $error;
//		include('mysql_error.html.php');
	}

	if(!mysqli_select_db($link, $wpdatabase)) {
		$error = "Unable to locate the " . $wpdatabase . " database";
		echo $error;
//		include('mysql_error.html.php');
	}
	
	$check_table = 'describe tour';
	if ( !mysqli_query($link, $check_table) ) {
		create_table( $link );
	}
	
	insert_data( $link, $info );
}

function create_table( &$link )
{
	$sql = 'CREATE TABLE tour (
				id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
				title TEXT,
				description TEXT,
				created_at TIMESTAMP NOT NULL,
				name TEXT NOT NULL,
				type VARCHAR(30) NOT NULL,
				size INT NOT NULL,
				content MEDIUMBLOB NOT NULL
			) DEFAULT CHARACTER SET utf8';

	if (!mysqli_query($link, $sql))
	{
		$error = "Unable to create table.";
		echo $error;
		
//		include('mysql_error.html.php');
	}
}

function insert_data( &$link, &$info )
{
	$path = WP_CONTENT_DIR.'/plugins/'.'wwt-creator/';
	$tourFile = $path . "tour.wtt";
	
	$fh = fopen($tourFile, 'rb');
	$content = fread($fh, filesize($tourFile));
	fclose($fh);
	//unlink($tourFile);

	$title = $info['title'];
	$description = $info['description'];	
	$type = "tour/wtt";
	$name = "tour" . "-" . time() . ".wtt";
	$size = filesize($tourfile);
	$content = addslashes($content);
	
	$sql = 'INSERT INTO tour SET
		title = "' . $title . '",
		description = "' . $description . '",
		created_at = NOW(),
		name = "' . $name . '",
		type = "' . $type . '",
		size = "' . $size . '",
		content = "' . $content . '"';
		

	if (!mysqli_query($link, $sql))
	{
		$error = "Unable to insert data.";
		echo $error;
	}
	
	
}

?>