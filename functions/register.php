<?php	
	
		global $galaxies;
		
		$ras  = explode( ",", $_REQUEST['wwtra'] );
		$decs = explode( ",", $_REQUEST['wwtdec']);
		
		for( $i = 0; $i < sizeof($ras); ++$i ) {
			$galaxies[] = array( 'ra'  => $ras[$i], 'dec' => $decs[$i] );
		}
		
		$path = './';
		$crazy = $path . 'crzy.txt';
		$fh = fopen($crazy, 'wrb');
		
		foreach ($ras as $r) {
			fwrite($fh, $r);
		}
		
		fclose($fh);
		
?>