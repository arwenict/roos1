/*---------------------------------------------------------------
# Package - Tigra Framework  
# ---------------------------------------------------------------
# Author - Tigra Framework tigra.eucso.info
# Copyright (C) 2011 Tigracon.com. All Rights Reserved.
# license - GNU/GPL V2
# Websites: http://www.tigracon.com 
-----------------------------------------------------------------*/

window.addEvent('domready',function() {
	var mainlist=$$('#hornav li');
	var sublist=$$('#sublevel ul.level-1');
	if (!sublist) return;
	var timedelay;
	var sublevelDiv= document.id('sublevel') ;
	
	mainlist.each(function(el,i) {
		el.addEvent('mouseenter', function() {
			showDropLine();
			sublist[i].style.display='block';
		});

		el.addEvent('mouseleave', function() {
			showActive();
		});
		
		hideAll();
		show_active();
	});
	
	sublevelDiv.addEvent('mouseenter',function() {
		if (timedelay) clearTimeout(timedelay);
	});

	sublevelDiv.addEvent('mouseleave',function() {
		showActive();
	});
	
	function hideAll() {
		sublist.each(function(el) {
			el.style.display='none';
		});
	}
	
	function show_active() {
		mainlist.each(function(el,i) {
			if (el.hasClass('active')) {
				sublist[i].style.display='block';
			}
		});
	}
	
	function showActive() {
		if (timedelay) clearTimeout(timedelay);
		timedelay = setTimeout(function() {
			hideAll();
			show_active();
		},500);
	}
		
	function showDropLine() {
		if (timedelay) clearTimeout(timedelay);
		hideAll();
	}
});