/*---------------------------------------------------------------
# Package - Tigra Framework  
# ---------------------------------------------------------------
# Author - Tigra Framework tigra.eucso.info
# Copyright (C) 2011 Tigracon.com. All Rights Reserved.
# license - GNU/GPL V2
# Websites: http://www.tigracon.com 
-----------------------------------------------------------------*/
window.addEvent("domready",function(){
	var tcToppanel = {
		initialize: function () {	
			this.open = false;
			this.wrapper =document.getElement('.tc-toppanel-wrap').setStyle('display', 'block');			
			this.container =document.id('tc-toppanel');
			this.box = this.container.inject(new Element('div', {'id': 'toppanel_container'}).inject(this.container.getParent()));
			this.handle = document.id('toppanel-handler');
			this.box = new Fx.Slide(this.box,{transition: Fx.Transitions.Expo.easeOut});
			this.box.hide();			
			this.handle.addEvent('click', this.toggle.bind(this));
		},

		show: function () {
			this.box.slideIn();
			this.open = true;
		},

		hide: function () {
			this.box.slideOut();
			this.open = false;
		},

		toggle: function () {
			if (this.open) {
				this.hide();
			} else {
				this.show();
			}
		}
	};
tcToppanel.initialize();
})