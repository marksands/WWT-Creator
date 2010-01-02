	
	$$ = jQuery.noConflict();
	
	// helper
	function convertToDecimal(old) {
		var flag = false;
		var degrees = (old).replace(/:[^:]+$$/, '');
		var minutes = (old).replace(/^.\d+:/, '');
		
		if ( /^\d+[.]/.test(minutes) ) {
			var seconds = minutes.replace(/^\d+./, '');
			flag = true;
		}
		
		// truncate seconds
		if ( /[.]\d+$$/.test(minutes) ) {
			minutes = minutes.replace(/.\d+$$/, '');
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
				
		$$("a[rel='modal']").colorbox({
			transition:"fade",
			initialWidth:"263",
			initialHeight:"109",
			overlayClose:"false"
		});
		
		$$('#messier').change(function(){
			$$('#ra').val(convertToDecimal(messier_catalog[$$(this).val()].ra));
			$$('#dec').val(convertToDecimal(messier_catalog[$$(this).val()].dec));
		});
				
		// for YUI, cause it doesn't like this :(
		// 	$$('.wwt-del').one('click',function(){$$(this:parent).effect("highlight",{color:"#ff0000"},800);setTimeout($$(this:parent).remove(),6600);});
		
		// $$('.wwt-del').one('click', function() {
		// 	$$(this:parent).effect("highlight", { color:"#ff0000" }, 800);
		// 	setTimeout( $$(this:parent).remove(), 600 );
		// });
		// 		
		// SUBMIT TOUR
		// http://stackoverflow.com/questions/353379/how-to-get-multiple-parameters-with-same-name-from-a-url-in-php
		$$(".wwt-save-button").click(function(e) {
			$$('#wwt-generate-tour').val('1');
				
				var raVals = new Array();
				var decVals = new Array();

				$$("input[id^='ra']").each(function() {
					raVals.push( $$(this).val() );
				});
				$$("input[id^='dec']").each(function() {
					decVals.push( $$(this).val() );
				});
				
				// send ajax request to php file, close loader on success
				// http://www.talkphp.com/vbarticles.php?do=article&articleid=58&title=simple-ajax-with-jquery	
				jQuery.ajax({
					type: "POST",
					async: false,
					url: "../wp-content/plugins/wwt-creator/functions/register.php",
					data: "ra=" + raVals.join(',')
					  + "&dec=" + decVals.join(',')
				});	
			// success: $$.fn.colorbox.close()
			
		  document.forms[0].submit();
			return false;
		});
		
		$$('.wwt-add-button').click(function(e) {
			
			var raVal = $$('#ra').val();
				$$('#ra').val('');
			var decVal = $$('#dec').val();
				$$('#dec').val('');
			var id = $$('#galaxy-id').val();
				$$('#galaxy-id').val('');

			$$('<div class="hilite" id="row'+id+'" />')
				.appendTo('#add-galaxy-div');

			$$('<input type="text" class="wwt-ra" id="ra'+id+'" name="ra'+id+'" value="'+raVal+'" />')
				.appendTo('#row'+id+'');

			$$('<input type="text" class="wwt-dec" id="dec'+id+'" name="dec'+id+'" value="'+decVal+'" />')
				.appendTo('#row'+id+'');

			$$('<a id="wwt-del-button-id" class="wwt-del-button"><span class="wwt-del">Delete</span></a>')
				.attr({
					onClick: 'removeFormField("'+id+'")'
				})
				.appendTo('#row'+id);

			$$("#row"+id).effect("highlight", { color:"#ffff66" }, 1500);

			id = ( id - 1 ) + 2;
			$$('#galaxy-id').val(id);

			return false;
		});
			
	});