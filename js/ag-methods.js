	
	$f = jQuery.noConflict();
	$s = jQuery.noConflict();

	function submitTourForm() {
	  document.getElementById('wwt-generate-tour').value = '1';		
	  document.forms[0].submit();
	}


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
	
	function addPresetGalaxy() {
	
		var sel = document.getElementById('messier');
		var pos = sel.options[sel.selectedIndex].value - 1;
		
		var raV = messier_catalog[pos].ra;
		var decV= messier_catalog[pos].dec;
		
		raV = convertToDecimal(raV);
		decV = convertToDecimal(decV);
		
		document.getElementById('ra').value = raV;
		document.getElementById('dec').value = decV;
	}
	
	function removeAndHighlight(id) {
	
		var parent = document.getElementById('add-galaxy-div');
		var child = document.getElementById('row' + id);
		
		parent.removeChild(child);
	}

	function removeFormField(id) {

		var child = document.getElementById('row' + id);
		
		$s(child).effect("highlight", { color:"#ff0000" }, 800);
		setTimeout("removeAndHighlight(" + id + ")", 600 );
	}
	
	
	function addFormField() {

		var raVal = document.getElementById('ra').value;
		var decVal = document.getElementById('dec').value;
		var id = document.getElementById('galaxy-id').value;

		document.getElementById('ra').value = "";
		document.getElementById('dec').value = "";
		document.getElementById('is_tour').value = "1";        


		$f('<div id="row'+id+'" />')
			.appendTo('#add-galaxy-div');

		$f('<input type="text" id="ra'+id+'" name="ra'+id+'" value="'+raVal+'" />')
			.addClass('wwt-ra')
			.appendTo('#row'+id+'');
			
		$f('<input type="text" id="dec'+id+'" name="dec'+id+'" value="'+decVal+'" />')
			.addClass('wwt-dec')
			.appendTo('#row'+id+'');

		$('<a id="wwt-del-button-id" class="wwt-del-button"><span class="wwt-del">Delete</span></a>')
		.attr({
			onClick: 'removeFormField("'+id+'")'
		})
		.appendTo('#row'+id)
		
		//var spanObj = '<span class="wwt-del">Delete</span>';
		//$f('#wwt-del-button-id').html(spanObj);

		id = ( id - 1 ) + 2;
		$f('#galaxy-id').val(id);

		$f('#row'+id+'').effect("highlight", { color:"#ffff66" }, 1500); 
	}	
	
	/*
	function addFormField() {
		
		var raVal = document.getElementById('ra').value;
		var decVal = document.getElementById('dec').value;
		
		document.getElementById('ra').value = "";
		document.getElementById('dec').value = "";
		
		var id = document.getElementById('galaxy-id').value;
		document.getElementById('is_tour').value = "1";
				
		var topDiv=document.createElement('div');
			topDiv.id = 'row' + id;
		
		var ra=document.createElement('input');
			ra.type='text';
			ra.id='ra' + id;
			ra.name='ra' + id;
			ra.value=raVal;
			ra.setAttribute('class', 'wwt-ra');
		
		var dec=document.createElement('input');
			dec.type='text';
			dec.id='dec' + id;
			dec.name='dec' + id;
			dec.value=decVal;
			dec.setAttribute('class', 'wwt-dec');
			
		var a=document.createElement('a');
			a.setAttribute('class', 'wwt-del-button');
			a.setAttribute('id', 'wwt-del-button-id');
			a.setAttribute('onClick', 'removeFormField("' + id + '")' );
		
		var spn=document.createElement('span');
			spn.setAttribute('class', 'wwt-del');
			spn.appendChild(document.createTextNode("Delete"));
		
		a.appendChild(spn);
		
		topDiv.appendChild(ra);
		topDiv.appendChild(dec);
		topDiv.appendChild(a);
			
		document.getElementById('add-galaxy-div').appendChild(topDiv);
		
		id = (id - 1) + 2;
		document.getElementById('galaxy-id').value = id;

		// color #ffff00??
		$f(topDiv).effect("highlight", { color:"#ffff66" }, 1500); 
	}
	*/