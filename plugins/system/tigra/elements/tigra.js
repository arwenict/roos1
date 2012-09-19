/*---------------------------------------------------------------
# Package - Tigra Framework  
# ---------------------------------------------------------------
# Author - Tigracon http://www.tigracon.com
# Copyright (C) 2011 tigracon.com. All Rights Reserved.
# license - GNU/GPL V2
-----------------------------------------------------------------*/
window.addEvent("domready",function(){
	var tabs = [];
	var options = [];
	var opt_iterator = -1;
	var div_gen,div;
	var cur_version ='1.7.0';

	
	//Info area
	var tigra_details = new Element('div',{"class":"tigra-details clearfix"});
	tigra_details.injectInside(base_table.getParent());

	//Tab button area
	var tigra_title_area = new Element('div',{"class":"tigra-title-area"});
	tigra_title_area.injectInside(base_table.getParent());
	var tigra_tabs = new Element('ul',{"class":"tigra-tabs"});
	tigra_tabs.injectInside(tigra_title_area);
	
	//Tab item area
	var tigra_panel = new Element('div',{"class":"tigra-panel"});
	tigra_panel.injectInside(base_table.getParent());
	var tigra_inner = new Element ('div',{"class":"tigra-inner"});
	tigra_inner.innerHTML='<div class="tigra-params-area clearfix"></div>';
	tigra_inner.injectInside(tigra_panel);


	document.getElements('.panel h3.title').each(function(el){
		div_gen = new Element('li',{"class":"tabs-title","id":'tc-'+ el.get('text').replace(/\s+/g,"-").toLowerCase()});//Set title as id in lower case			
		div_gen.innerHTML = '<span class="tab-l"><span class="tab-r"><span class="tab-text">'+el.get('text')+'</span></span></span>';			
		div_gen.injectInside(tigra_tabs);
	})

	document.getElements('.panel .content').each(function(el){
		div = new Element('div',{"class":"tabs-item"});
		div.innerHTML = el.innerHTML;			
		div.injectInside(document.getElement('.tigra-params-area'));
	})
	
	//Menu Assignment Tab
	var assign_tab = new Element('li',{"class":"tabs-title","id":"tc-menu-assign"});
	assign_tab.innerHTML = '<span class="tab-l"><span class="tab-r"><span class="tab-text">Menu Assignment</span></span></span>';
	assign_tab.injectBefore($$('li.tabs-title').getLast());

	var assign_item = new Element('div',{"class":"tabs-item"});
	$$('.adminform legend')[1].dispose();//remove legend
	assign_item.innerHTML = $$('.adminform')[1].innerHTML;
	assign_item.injectBefore($$('.tabs-item').getLast());

			
				}	
	   		}
		});		
	});	
	
	document.getElement('.pane-sliders').getParent().dispose();//remove slider-pan
	
	//Template Description area
	var desc = new Element('div',{"class":"tigra-desc"});
	desc.innerHTML = document.getElement('.tc-template-desc').innerHTML;
	desc.injectInside(tigra_inner);
	
	var clear = new Element('div',{"class":"clr"});
	clear.injectAfter(document.getElement('.tigra-desc'));	
	
	//remove all parent tables
	var admin_details=document.getElement('.adminformlist');
	admin_details.getParent().getParent().removeClass('width-60 fltlft').addClass('tigra-details');
	
	document.getElement('.tc-template-desc').dispose();
	$$('.adminform')[1].getParent().dispose();
});


var TigraTab = new Class({//Based on jTabs
	getOptions: function(){
		return {

			display: 0,
			
			onActive: function(title, description){
				description.fade('in');
				description.setStyle('display', 'block');
				title.addClass('open').removeClass('closed');
			},

			onBackground: function(title, description){
				description.fade('out');
				description.setStyle('display', 'none');
				title.addClass('closed').removeClass('open');
			}

		};
	},

	initialize: function(options){
		this.setOptions(this.getOptions(), options);
		this.titles = document.getElements('ul.tigra-tabs li.tabs-title');//
		this.descriptions = document.getElements('.tigra-panel .tabs-item');//
		
		for (var i = 0, l = this.titles.length; i < l; i++){
			var title = this.titles[i];
			var description = this.descriptions[i];
			title.setStyle('cursor', 'pointer');
			title.addEvent('click', this.display.bind(this, i));
		}

		if ($chk(this.options.display)) this.display(this.options.display);

		if (this.options.initialize) this.options.initialize.call(this);
	},

	hideAllBut: function(but){
		for (var i = 0, l = this.titles.length; i < l; i++){
			if (i != but) this.fireEvent('onBackground', [this.titles[i], this.descriptions[i]])
		}
	},

	display: function(i){
		this.hideAllBut(i);
		this.fireEvent('onActive', [this.titles[i], this.descriptions[i]])
	}
});

TigraTab.implement(new Events);
TigraTab.implement(new Options);

window.addEvent("domready",function(){ 
	new TigraTab(); 
});