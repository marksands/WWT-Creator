	// helper
	function convertToDecimal(old) {
		var flag = false;
		var degrees = (old).replace(/:[^:]+$/, '');
		var minutes = (old).replace(/^.\d+:/, '');
		
		if ( /^\d+[.]/.test(minutes) ) {
			var seconds = minutes.replace(/^\d+./, '');
			flag = true;
		}
		
		// truncate seconds
		if ( /[.]\d+$/.test(minutes) ) {
			minutes = minutes.replace(/.\d+$/, '');
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
	
	// minified this
	function addPresetGalaxy() {
	
		var sel = document.getElementById('messier');
		var pos = sel.options[sel.selectedIndex].value - 1;
	
		$('#ra').val(convertToDecimal(messier_catalog[pos].ra));
		$('#dec').val(convertToDecimal(messier_catalog[pos].dec);
		
		return false;
	}
	
	function removeAndHighlight(id) {
		$('#add-galaxy-div').removeChild($('#row'+id));	
		return false;
	}

	function removeFormField(id) {
		$($('#row'+id)).effect("highlight", { color:"#ff0000" }, 800);
		setTimeout("removeAndHighlight(" + id + ")", 600 );
	}
	
	jQuery(function() {
		
		$(".wwt-save-button").click(function(e) {
			$('#wwt-generate-tour').val('1');
		  document.forms[0].submit();
			return false;
		});
		
		$('.wwt-add-button').click(function(e) {
			
			var raVal = $('#ra').value();
				$('#ra').val('');
			var decVal = $('#dec').value();
				$('#dec').val('');
			var id = $('#galaxy-id').value();
				$('#galaxy-id').val('');

			$('<div id="row'+id+'" />')
				.appendTo('#add-galaxy-div');

			$('<input type="text" class="wwt-ra" id="ra'+id+'" name="ra'+id+'" value="'+raVal+'" />')
				.appendTo('#row'+id+'');

			$('<input type="text" class="wwt-dec" id="dec'+id+'" name="dec'+id+'" value="'+decVal+'" />')
				.appendTo('#row'+id+'');

			$('<a id="wwt-del-button-id" class="wwt-del-button"><span class="wwt-del">Delete</span></a>')
				.attr({
					onClick: 'removeFormField("'+id+'")'
				})
				.appendTo('#row'+id)

			id = ( id - 1 ) + 2;
			$('#galaxy-id').val(id);

			$($('#row'+id-1)).effect("highlight", { color:"#ffff66" }, 1500);
			//addHighlight(id-1);

			return false;
		});
			
	});