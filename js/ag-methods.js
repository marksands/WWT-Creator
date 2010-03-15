	
	$z = jQuery.noConflict();
	
	// helper
	function convertToDecimal(old) {
		var flag = false;
		var degrees = (old).replace(/:[^:]+$z/, '');
		var minutes = (old).replace(/^.\d+:/, '');
		
		if ( /^\d+[.]/.test(minutes) ) {
			var seconds = minutes.replace(/^\d+./, '');
			flag = true;
		}
		
		// truncate seconds
		if ( /[.]\d+$z/.test(minutes) ) {
			minutes = minutes.replace(/.\d+$z/, '');
		}
		
		if ( /^0/.test(minutes) ) {
			 // remove initial 0 if exists
			minutes = minutes.replace(/^0/, '');
		}
		
		var last = 0.0;
		
		if ( flag ) {
			last = parseFloat(degrees) + parseFloat(minutes/60) + parseFloat(seconds/360);
		} else {
			last = parseFloat(degrees) + parseFloat(minutes/60);
		}
		
		last = Math.round(last)/100;
		
		return last;
	}

	jQuery(function() {
				
		$z("a[rel='modal']").colorbox({
			transition:"fade",
			initialWidth:"263",
			initialHeight:"109",
			overlayClose:"false"
		});
		
		$z('#messier').change(function(){
			$z('#ra').val(convertToDecimal(messier_catalog[$z(this).val()-1].ra));
			$z('#dec').val(convertToDecimal(messier_catalog[$z(this).val()-1].dec));
		});

		(function(){
			var queue = [], paused = false;
			this.timer = function(fn){
				queue.push( fn ); runTimer();
			};
			this.pause = function(){
				paused = true;
			};
			this.resume = function(){
				paused = false; setTimeout(runTimer, 1);
			};
			function runTimer(){ 
				if ( !paused && queue.length ) {
					queue.shift()();
					
					if ( !paused ) {
						resume();
					}
				}
			}
		})();

		$z('#wwt-del-button-id').live('click', function() {
			timer(function(){ 
				pause();
				setTimeout(function(){
					$z(this).parent().effect("highlight", { color:"#ff0000" }, 800);
					resume();
				}, 800);
			});
			timer(function(){
				pause();
				setTimeout(function(){
					$z(this).parent().remove()
					resume();
				}, 200);
			});
		});
					
		// Submit tour, sends an ajax request to save the ra/dec vals and submits the tour for php to take care of the rest
		// for jQuery example see:
		// http://stackoverflow.com/questions/353379/how-to-get-multiple-parameters-with-same-name-from-a-url-in-php
		// $z("#wwt-save-button").click(function(e) {
		// 
		// 		var raVals = new Array();
		// 		var decVals = new Array();
		// 
		// 		$z("input[id^='ra']").each(function() {
		// 			raVals.push( $z(this).val() );
		// 		});
		// 		$z("input[id^='dec']").each(function() {
		// 			decVals.push( $z(this).val() );
		// 		});
		// 		// remove empty input fields
		// 		raVals.pop();
		// 		decVals.pop();
		// 		
		// 		var url = "../wp-content/plugins/wwt-creator/functions/register.php";		
		// 		var params = "wwtra="+raVals.join(',') + "&wwtdec=" + decVals.join(',');
		// 		
		// 		// cross browser AJAX support
		// 		var http = null;
		// 		try{
		// 		  // Opera 8.0+, Firefox, Safari
		// 		  http = new XMLHttpRequest();
		// 		} catch (e){
		// 		  // Internet Explorer Browsers
		// 		  try{
		// 		    http = new ActiveXObject("Msxml2.XMLHTTP");
		// 		  } catch (e) {
		// 		    try{
		// 		      http = new ActiveXObject("Microsoft.XMLHTTP");
		// 		    } catch (e){
		// 		      alert("Your browser does not support Ajax. Please upgrade!");
		// 		      return false;
		// 		    }
		// 		  }
		// 		}
		// 		
		// 		http.onreadystatechange = function() {
		// 			if( http.readyState == 4 && http.status == 200 ) {
		// 				$z('#tour-form').submit();
		// 			}
		// 		}
		// 		
		// 		http.open( "POST", url, true );
		// 		http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		// 		http.send( params );
		// 		
		// 		return false;
		// 	});
		
		$z('.wwt-add-button').click(function(e) {
			
			var raVal = $z('#ra').val();
				$z('#ra').val('');
			var decVal = $z('#dec').val();
				$z('#dec').val('');
			var id = $z('#galaxy-id').val();
				$z('#galaxy-id').val('');

			$z('<div class="hilite" id="row'+id+'" />')
				.appendTo('#add-galaxy-div');

			$z('<input type="text" class="wwt-ra" id="ra'+id+'" name="ra'+id+'" value="'+raVal+'" /><input type="text" class="wwt-dec" id="dec'+id+'" name="dec'+id+'" value="'+decVal+'" /><a id="wwt-del-button-id" class="wwt-del-button"><span class="wwt-del">Delete</span></a>')
				.appendTo('#row'+id);

			$z("#row"+id).effect("highlight", { color:"#ffff66" }, 1500);

			id = (id - 1) + 2;
			$z('#galaxy-id').val(id);

			return false;
		});
			
	});