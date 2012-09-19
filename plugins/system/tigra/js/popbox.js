/*---------------------------------------------------------------
# Package - Tigra Framework  
# ---------------------------------------------------------------
# Author - Tigra Framework tigra.eucso.info
# Copyright (C) 2011 Tigracon.com. All Rights Reserved.
# license - GNU/GPL V2
# Websites: http://www.tigracon.com 
-----------------------------------------------------------------*/
window.addEvent('domready', function () {
    var boxes = [];
    showBox = function (box, caller) {
        box = $(box);
        if (!box) return;
		if ($(caller)) box._caller = $(caller);
        boxes.include(box);
        if (box.getStyle('display') == 'none') {
            box.setStyles({
                display: 'block',
                opacity: 0
            })
        }
        if (box.status == 'show') {
            box.status = 'hide';
            box.set('tween', {
                duration: 400
            }).fade('out')
			if (box._caller) box._caller.removeClass ('show');
        } else {
            boxes.each(function (box1) {
                if (box1 != box && box1.status == 'show') {
                    box1.status = 'hide';
                    box1.set('tween', {
                        duration: 400
                    }).fade('out')
                }
            }, this);
            box.status = 'show';
            box.set('tween', {
                duration: 400
            }).fade('in')
			if (box._caller) box._caller.addClass ('show');
        }
    }
});
