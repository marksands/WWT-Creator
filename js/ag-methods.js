	
	jQuery.noConflict();
	
	// helper
	function convertToDecimal(old) {
		var flag = false;
		var degrees = (old).replace(/:[^:]+jQuery/, '');
		var minutes = (old).replace(/^.\d+:/, '');
		
		if ( /^\d+[.]/.test(minutes) ) {
			var seconds = minutes.replace(/^\d+./, '');
			flag = true;
		}
		
		// truncate seconds
		if ( /[.]\d+jQuery/.test(minutes) ) {
			minutes = minutes.replace(/.\d+jQuery/, '');
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
				
		jQuery("a[rel='modal']").colorbox({
			transition:"fade",
			initialWidth:"263",
			initialHeight:"109",
			overlayClose:"false"
		});
		
		jQuery('#messier').change(function(){
			jQuery('#ra').val(convertToDecimal(messier_catalog[jQuery(this).val()-1].ra));
			jQuery('#dec').val(convertToDecimal(messier_catalog[jQuery(this).val()-1].dec));
		});

		jQuery('#wwt-del-button-id').live('click', function() {
			jQuery(this).parent().effect("highlight", { color:"#f00" }, 800, function(){
				jQuery(this).remove();
			});
		});
		
		jQuery('.wwt-add-button').click(function(e) {
			
				// RA - set and reset
			var raVal = jQuery('#ra').val();
				jQuery('#ra').val('');
				// DEC - set and reset
			var decVal = jQuery('#dec').val();
				jQuery('#dec').val('');
				// ID - set and reset
			var id = jQuery('#galaxy-id').val();
				jQuery('#galaxy-id').val('');
				
				// add the ra/dec to the list
			jQuery('<div class="hilite" id="row'+id+'" />')
				.appendTo('#add-galaxy-div');
				
				// Add the RA/DEC inputs and a delete button
			jQuery('<input type="text" class="wwt-ra" id="ra'+id+'" name="ra'+id+'" value="'+raVal+'" /><input type="text" class="wwt-dec" id="dec'+id+'" name="dec'+id+'" value="'+decVal+'" /><a id="wwt-del-button-id" class="wwt-del-button"><span class="wwt-del">Delete</span></a>')
				.appendTo('#row'+id);

				// yellow fade
			jQuery("#row"+id).effect("highlight", { color:"#ffff66" }, 1500);

			id = (id - 1) + 2;
			jQuery('#galaxy-id').val(id);

			return false;
		});
			
	});