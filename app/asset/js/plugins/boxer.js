(function( $ ) {
    $.fn.boxer = function(options) {
	
	var boxObj = this, boxContainerObject = null;
	
	boxObj.getItems = function(){
	    return boxObj.next().find('.item');
	};
	boxObj.getContainer = function(){
	    return boxContainerObject;
	};
	boxObj.verticalRealign = function(){
	    if(boxContainerObject !== null){
		var boxTop = parseFloat(boxObj.position().top) + parseFloat(boxObj.height()) + 
			parseFloat(boxObj.css('padding-top')) + parseFloat(boxObj.css('padding-bottom')) 
			+ parseFloat(boxObj.css('border-top-width')) + parseFloat(boxObj.css('border-bottom-width'));
		boxContainerObject.css({
		   'top':boxTop+'px' 
		});
		return true;
	    }
	    return false;
	};
	boxObj.setUnselectableItems = function(items){
	    if(items instanceof Array){
		for(var i = 0; i < items.length; i++){
		    boxContainerObject.find('.item').not('.unselectable').filter(function(){
			return $.trim($(this).text()) === items[i];
		    }).addClass('unselectable');
		}
	    }else{
		boxContainerObject.find('.item').not('.unselectable').filter(function(){
		    return $trim($(this).text()) === items;
		}).addClass('unselectable');
	    }
	    boxContainerObject.find('.item').unbind('click');
	    boxContainerObject.find('.item').not('.unselectable').on('click',function(){
		settings.onItemClick($(this));
		boxObj.change();
		return boxObj;
	    });
	};
	var defaults = {
	    align: "center",
            position:{
		"left":null
	    },
	    boxWidth: 50,
	    items: [],
	    type: "combo",
	    createC: false,
	    boxStyle:{
		"border":"1px outset black",
		"border-top-style":"none",
		"display":"none"
	    },
	    containedItems: null,
	    boxContainer: null,
	    markDefaultColor: "#DDDDDD",
	    onClick: function(){
		boxContainerObject.toggle();
	    },
	    onItemClick: function(item){
		boxObj.val($.trim(item.text()));
		boxContainerObject.toggle();
	    },
	    onEnterPressed: function(){
		switch(settings.type){
		    case "combo":{
			var chosen = null;
			chosen = boxContainerObject.find('.item').filter(function(){
				return $(this).is(':visible') === true;
			    }).first();
			boxObj.val($.trim(chosen.text()));
			boxContainerObject.hide();
			break;
		    }
		}
	    },
	    onArrowDownPressed: function(){
		var items = boxContainerObject.find('.marked-item').not('.unselectable'),next = null;
		if(items.length === 0){
		    next = boxContainerObject.find('.item').not('.unselectable').first();
		}else{
		    items.removeClass('marked-item');
		    next = items.next().not('.unselectable');
		}
		next.addClass('marked-item');
		boxObj.val($.trim(next.text()));
	    },
	    onArrowUpPressed: function(){
		var items = boxContainerObject.find('.marked-item'),prev = null;
		if(items.length === 0){
		    prev = boxContainerObject.find('.item').not('.unselectable').last();
		}else{
		    items.removeClass('marked-item');
		    prev = items.prev().not('.unselectable');
		}
		prev.addClass('marked-item');
		boxObj.val($.trim(prev.text()));
	    },
	    onKeyPressed: function(){
		if(boxObj.val().length > 0){
		    var all = boxContainerObject.find('.item').not('.unselectable');
		    all.show();
		    var nc = boxContainerObject.find('.item').not('.unselectable').filter(function(){
			return $(this).text().indexOf(boxObj.val()) <= -1;
		    });
		    nc.hide();
		}else{
		    boxContainerObject.find('.item').not('.unselectable').show();
		}
	    }
        };
	
	var settings = $.extend( true, {}, defaults, options );
	
	if(settings.createC){
	    var div = '<div class="item-container"><table style="width:100%">';
	    for(var i = 0; i < settings.items.length; i++){
		div += '<tr class="item"><td>'+settings.items[i]+'</td></tr>';
	    }
	    div += '</table></div>';
	    boxObj.after(div);
	    boxObj.next().css(settings.boxStyle);
	    boxContainerObject = boxObj.next();
	}else if(settings.boxContainer !== null){
	    if(settings.boxContainer.attr('class').indexOf('item-container') < 0){
		settings.boxContainer.addClass('item-container');
	    }
	    boxContainerObject = settings.boxContainer;
	    if(boxContainerObject.is(':visible')){
		boxContainerObject.toggle();
	    }
	    boxObj.after(boxContainerObject);
	}
	
	if(boxContainerObject !== null){
	    var mw = parseFloat(boxObj.width());
	    var boxWidth = mw*(parseFloat(settings.boxWidth)/100);
	    boxContainerObject
		.css({'position':'absolute',
		      'background-color':'white',
		      'min-width':mw/2+'px',
		      'width':boxWidth+'px'});
	    
	    if(isNaN(settings.left)){
		switch(settings.align){
		    case "center":{
			var r = (parseFloat(boxObj.width()) - parseFloat(boxContainerObject.width()))/2;
			var left = parseFloat(boxObj.position().left) + parseFloat(boxObj.css("margin-left"));
			boxContainerObject.css({"left":(left+r )+"px"});
			break;
		    }
		    case "left":{
			boxContainerObject.css({"left":boxObj.position().left+"px"});
			break;
		    }
		    case "right":{
			var r = parseFloat(boxObj.width()) - parseFloat(boxContainerObject.width());
			var left = parseFloat(boxObj.position().left) + parseFloat(boxObj.css("margin-left"));
			boxContainerObject.css({"left":(left+r)+"px"});
			break;
		    }
		}
	    }
	    //events
	    boxObj.unbind('click')
		  .unbind('keyup');
	    boxContainerObject.find('.item').not('.unselectable').unbind('click');
	    boxObj.on('click',function(){
		settings.onClick.call();
		return boxObj;
	    });
	    boxContainerObject.find('.item').not('.unselectable').on('click',function(){
		settings.onItemClick($(this));
		boxObj.change();
		return boxObj;
	    });
	    boxObj.on('keyup',function(e){
		if(boxContainerObject.is(':visible')){
		    switch(e.keyCode){
			case 13:{
			    settings.onEnterPressed.call();
			    break;
			}
			case 38:{
			    settings.onArrowUpPressed.call();
			    break;
			}
			case 40:{
			    settings.onArrowDownPressed.call();
			    break;
			}
			default:{
			    settings.onKeyPressed.call();
			    break;
			}
		    }
		    
		}
	    });
	}
	return boxObj;
    };
}( jQuery ));


