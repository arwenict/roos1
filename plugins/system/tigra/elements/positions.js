/*---------------------------------------------------------------
# Package - Tigra Framework  
# ---------------------------------------------------------------
# Author - Tigra Framework tigra.eucso.info
# Copyright (C) 2011 Tigracon.com. All Rights Reserved.
# license - GNU/GPL V2
# Websites: http://www.tigracon.com 
-----------------------------------------------------------------*/
window.addEvent("domready",function(){
	var posID=document.id('jform_position');
	var tc_pos = document.id('tc_pos');
	var tc_tmpl=document.id('tc_tmpl');
	var elmns = document.getElements ('optgroup.tc_optgroup');
	
	//Inject Template and Position dropdown list
	tc_pos.injectAfter(posID.getParent()).style.display=null;
	tc_tmpl.injectAfter(posID.getParent()).style.display=null;	
	
	document.getElement ('optgroup#' + tc_tmpl.value).style.display=null;
	
	//Generate module position by changing template
	tc_tmpl.addEvents({
		change: function(){
			genPos();
		},
		keyup: function(){
			genPos();
		}
	});
	
	//Change module position
	tc_pos.addEvents({
		change: function(){
			posID.value=tc_pos.value;
		},
		keyup: function(){
			posID.value=tc_pos.value;
		}
	});
	
	//Generate Positions
	function genPos() {
		for (i=0; i<elmns.length;i++) {
			elmns[i].style.display="none";
		}
		document.getElement ('optgroup#' + tc_tmpl.value).style.display=null;
		var elmn = document.getElements ('#' + tc_tmpl.value + ' option');
		tc_pos.value = elmn[0].value;	
	}
	
});