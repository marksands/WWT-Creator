<?php	
	
		if( empty($_SERVER['CONTENT_TYPE']) ){
		     $type = "application/x-www-form-urlencoded";
		     $_SERVER['CONTENT_TYPE'] = $type;
		}
	
		$ras  = explode( ",", $_REQUEST['wwtra'] );
		$decs = explode( ",", $_REQUEST['wwtdec']);
		
		$path = './';
		$crazy = $path . 'crzy.txt';
		$fh = fopen($crazy, 'wrb');
		
		foreach ($ras as $r) {
			fwrite($fh, $r);
		}
		
		fclose($fh);	

		
?>