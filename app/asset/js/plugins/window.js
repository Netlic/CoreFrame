(function( $ ) {
    $.fn.window = function(options) {
        var container = ['div','table','tbody'];    //specifies, what can be floating window, not changeable
        var allowedAlign = ["left-top","left-center","left-bottom","center-top","center-center","center-bottom","right-top","right-center","right-bottom"];
        var windowCaptionObject = null, winObj = this, maximized = false, minimized = false, backScreenObj = null; 
	
	//plugin methods
	winObj.getMaxState = function(){
		return maximized;
	    };
	winObj.getMinState = function(){
		return minimized;
	    };
	winObj.getWindowCaption = function(){
		return windowCaptionObject;
	    };
	winObj.getWindowButtons = function(){
		return winObj.find('.window-button');
	    };
	winObj.getBackScreen = function(){
		return backScreenObj;
	    };
	winObj.repeatAlign = function(){
		align();
		return winObj;
	    };
        winObj.closeWindow = function(){
                if(backScreenObj !== null){
                    backScreenObj.toggle();
                }
		close();
            };
	winObj.showWindow = function(){
	    if(backScreenObj !== null){
                backScreenObj.show();
            };
	    winObj.show();
	};
	winObj.setBackScreen = function(element){
	    backScreenObj = element;
	};
	winObj.removeWindow = function(){
	    if(backScreenObj !== null){
                backScreenObj.remove();
            };
	    winObj.remove();
	};
	
	//default settings
        var defaults = {
            align: "center-center",      //window position on parent
            position:{
		top: null,
		left: null
	    },
            sizable:{
                allow: true,
                over: false       //over its parent
            },
            movable: true,     //if window can be moved
            windowCaption: {        //a window header with minimize, maximalize and close button
                createC: false,    //determine whether window header shoul be created by plugin
                caption: "Info",    //default caption for window header
		captionClass: "caption",
		"min-button" : true,
		"max-button" : true,
		"close-button" : true
            },
	    userCaption: {      //user defined window caption
                captionElement: null,   //element, that shall contain window caption and buttons
                windowButtons:{
                    min: null,      //element, to minimize window on click
                    max: null,      //element, to maximize window on click
                    close: null     //element, to close window on click
                }
            },
            windowClass: "",    //css class name to window element
            style:{           //default style setting
                "background-color":"white",
                "border":"1px outset grey"
            },
            windowButtonsStyle:{
                "cursor":"pointer"
            },
            minWindowStyle:{
                "width":"10px",
                "height":"8px",
                "border-bottom":"1px black solid"
            },
            maxWindowStyle:{
                "width":"10px",
                "height":"8px",
                "border":"1px black solid",
                "border-bottom-width":"3px"
            },
            closeWindowStyle:{
                "font-family":"arial"
            },
            tableStyle:{
                "width":"100%"
            },
            captionStyle:{
                "border-bottom":"1px solid black"
            },
	    cursor:{
		"horizonatal-resize":"w-resize",
		"vertical-resize":"s-resize",
		"movable":"move"
	    },
	    backScreen:{
		"auto":false,
		"userDefined": null
	    },
	    autoAlign:true,
            onMinimize: function(){
                var caption = winObj.find('.caption');
		if(!minimized){
		    var t = parseFloat(winObj.parent().height()) ;
		    if(t === 0){
			t = $(document).height();
		    }
		    t -=  parseFloat(caption.height()) + parseFloat(caption.css("border-bottom-width")) + parseFloat(caption.css("border-top-width")) + 20;
		    caption.nextAll().css({"display":"none"});
		    winObj.css({"top":t + "px"});
		}else{
		    caption.nextAll().css({"display":"block"});
		    winObj.css({"top":"auto"});
		}
            },
            onMaximize: function(){
                if(!maximized){
		    var w = winObj.parent().width();
		    var h = winObj.parent().height();
		    if(h === 0){
			h = parseFloat(winObj.children(':last').position().top) + parseFloat(winObj.children(':last').height());
		    }
		    winObj.css({"width":w+"px","height":h+"px"});
		}else{
		    winObj.css({"width":"auto","height":"auto"});
		}
		return winObj;
            },
            onClose:function(){
		winObj.css({"display":"none"});
		return winObj;
            },
            onResize:function(){
                return winObj;
            },
            onMove: function(){
                return winObj;
            }
        };
        
        var settings = $.extend(true, {}, defaults, options);
        
        var element = this.prop('tagName').toLowerCase();
        if(jQuery.inArray(element,container) >= 0){
            //back screen creation
	    var backscr = null;
	    if(settings.backScreen.auto){
		backscr = $('<div class="backscr"></div>');
	    }else if(settings.backScreen.userDefined !== null){
		backscr = settings.backScreen.userDefined;
		backscr.addClass("backscr");
	    }
	    
	    if(backscr !== null){
		winObj.before(backscr);
		backscr.css({"position":"absolute",
			     "top":"0px",
			     "left":"0px",
			     "background-color":"black",
			     "opacity":"0.5",
			     "width":"100%",
			     "height":"100%"});
		backScreenObj = backscr;
	    }
	    
	    //window caption creation
            var caption = null;
	    if(settings.windowCaption.createC){
                var buttons = "";
		if(settings.windowCaption["min-button"]){
		    buttons += '<td class="window-button">'+
				    '<div class="min-window"></div>'+
                               '</td>';
		}
		if(settings.windowCaption["max-button"]){
		    buttons += '<td class="window-button">'+
				    '<div class="max-window"></div>'+
                               '</td>';
		}
		if(settings.windowCaption["close-button"]){
		    buttons += '<td class="window-button">'+
				    '<div class="close-window">x</div>'+
                               '</td>';
		}
		caption = $('<div class="'+settings.windowCaption.captionClass+'">'+
                            '<table>'+
                                '<tr>'+
                                    '<td id="caption">'+settings.windowCaption.caption+'</td>'+
                                    '<td>'+
                                        '<table style="max-width:30px;float:right">'+
                                            '<tr>' + buttons + '</tr>'+
                                        '</table>'+
                                    '</td>'+
                                '</tr>'+
                            '</table>'+
                        '</div>');
                //apply window button style
                caption.find('.window-button').css(settings.windowButtonsStyle);
                caption.find('.min-window').css(settings.minWindowStyle);
                caption.find('.max-window').css(settings.maxWindowStyle);
                caption.find('.close-window').css(settings.closeWindowStyle);
                caption.find('table').css(settings.tableStyle); 
            }else if(settings.userCaption.captionElement !== null){
                caption = settings.userCaption.captionElement;
		caption.addClass(settings.windowCaption.captionClass);
            }
            
            //set window caption
            if(caption !== null){
                winObj.children(':first').before(caption);
		windowCaptionObject = caption;
            }
            
            //aplying default style
            winObj.css(settings.style);
            
            //always absolute position
            winObj.css({'position':'absolute'});
	    
	    //events
	    //movability
	    if(settings.movable){
		winObj.find('#caption')
		    .css({"cursor":"move"})
		    .unbind('mousedown').on('mousedown',function(e){
			var x = e.clientX, y = e.clientY;
			var t = winObj.offset().top;
			var l = winObj.offset().left;
			winObj.parent()
			    .unbind('mousemove').mousemove(function(e){
				var nx = (x - e.clientX)*(-1);
				var ny = (y - e.clientY)*(-1);
				winObj.css({"top":(t+ny) + "px","left":(l+nx) + "px"});
				move();
			    })
			    .unbind('mouseup').mouseup(function(){
				$(this).unbind('mousemove');
			    });
		    });
	    }
	    //resizeability
	    if(settings.sizable.allow){
		winObj
		    .on('mouseenter',function(e){
			var edge = closestEdge($(this),e);
			var cursor = "default";
			switch(edge){
			    case "bottom":{
				cursor = "s-resize";
				break;
			    }
			    case "top":{
				cursor = "s-resize";
				break;	
			    }
			    case "left":{
				cursor = "w-resize";
				break;
			    }
			    case "right":{
				cursor = "w-resize";
				break;
			    }
			}
			var onenteredge = edge;
			var event = e;
			$(this)
			    .css({"cursor":cursor})
			    .unbind('mousemove').on('mousemove',function(e){
				var edge = closestEdge($(this),e);
				var distance = 0,
				    cursor = "default",
				    w = parseFloat($(this).width()) - 4,
				    h = parseFloat($(this).height()) + 4 + parseFloat($(this).offset().top) + parseFloat($(this).css('border-top-width')) + parseFloat($(this).css('border-bottom-width')),
				    out = 0;
				switch(edge){
				    case "bottom":{
					distance = event.clientY - e.clientY;
					out = h - e.clientY;
					cursor = "s-resize";
					break;
				    }
				    case "top":{
					distance = event.clientY - e.clientY;
					out = parseFloat($(this).offset().top) + 4 - e.clientY;
					cursor = "s-resize";
					break;	
				    }
				    case "left":{
					distance = event.clientX - e.clientX;
					out = parseFloat($(this).offset().left) + 4 - e.clientX;
					cursor = "w-resize";
					break;
				    }
				    case "right":{
					distance = event.clientX - e.clientX;
					out = w - (parseFloat(event.clientX) + parseFloat(Math.abs(distance)) - parseFloat($(this).offset().left) - parseFloat($(this).css('border-left-width')) - parseFloat($(this).css('border-right-width')));
					cursor = "w-resize";
					break;
				    }
				}
				if(Math.abs(distance) >= 6 && onenteredge === edge){
				    $(this).css({"cursor":"default"});
				}else if(Math.abs(Math.round(out)) < 6){
				    $(this).css({"cursor":cursor});
				}else{
				    $(this).css({"cursor":"default"});
				}	    
			});
		    })
		    .on('mousedown',function(e){
			var cursors = ["s-resize","w-resize"];
			if($.inArray($(this).css("cursor"),cursors) >= 0){
			    var edge = closestEdge($(this),e), parent = winObj.parent(),clicked = e;
			    if(winObj.parent().prop('tagName').toLowerCase() === "body"){
				parent = $(document);
			    }
			    var w = parseFloat(winObj.width()),l = parseFloat(winObj.offset().left), 
				h = parseFloat(winObj.height()),t = parseFloat(winObj.offset().top);
			    parent.on('mousemove',function(e){
				switch(edge){
				    case "right":{
					var distance = e.clientX - clicked.clientX;
					winObj.css({"width":w+distance+"px"});
					break;
				    }
				    case "left":{
					var distance = clicked.clientX - e.clientX;
					winObj.css({"width":w+distance+"px","left":l-distance+"px"});
					break;
				    }
				    case "bottom":{
					var distance = e.clientY - clicked.clientY;
					winObj.css({"height":h+distance+"px"});
					break;
				    }
				    case "top":{
					var distance = clicked.clientY - e.clientY;
					winObj.css({"height":h+distance+"px","top":t-distance+"px"});
					break;
				    }
				}
				resize();
			    });
			    parent.on('mouseup',function(){
				$(this).unbind('mousemove');
			    });
			}
		    });
	    }
            if(windowCaptionObject !== null){
                windowCaptionObject.find('.close-window').on('click',function(){//close window button clicked
                    var object = close();
                    if(backScreenObj !== null){	//backscreen always hide
                        backScreenObj.css({"display":"none"});
                    }
                    if(typeof(object) === "object"){
                        return object;
                    }else{
                        return winObj;
                    }
                });
                windowCaptionObject.find('.min-window').on('click',function(){//minimize window button clicked
                    var object = minimize();
                    minimized = !minimized;
                    if(typeof(object) === "object"){
                        return object;
                    }else{
                        return winObj;
                    }
                });
                windowCaptionObject.find('.max-window').on('click',function(){//maximize window button clicked
                    var object = maximize();
                    maximized = !maximized;
                    if(typeof(object) === "object"){
                        return object;
                    }else{
                        return winObj;
                    }
                });
            }
	    function close(){
		return settings.onClose.call();
	    }
	    function maximize(){
		return settings.onMaximize.call();
	    }
	    function minimize(){
		return settings.onMinimize.call();
	    }
	    function move(){
		return settings.onMove.call();
	    }
	    function resize(){
		return settings.onResize.call();
	    }
	    function closestEdge(elem,e) {
		var w = elem.width();
		var h = elem.height();
		var offset = elem.offset();
		/** calculate the x and y to get an angle to the center of the div from that x and y. **/
		/** gets the x value relative to the center of the DIV and "normalize" it **/
		var x = (e.pageX - offset.left - (w/2)) * ( w > h ? (h/w) : 1 );
		var y = (e.pageY - offset.top  - (h/2)) * ( h > w ? (w/h) : 1 );

		/** the angle and the direction from where the mouse came in/went out clockwise (TRBL=0123);**/
		/** first calculate the angle of the point, 
		 add 180 deg to get rid of the negative values
		 divide by 90 to get the quadrant
		 add 3 and do a modulo by 4  to shift the quadrants to a proper clockwise TRBL (top/right/bottom/left) **/
		var direction = Math.round((((Math.atan2(y, x) * (180 / Math.PI)) + 180 ) / 90 ) + 3 )  % 4;

		/** do your animations here **/ 
		switch(direction) {
		    case 0:
		       return 'top';
		    break;
		    case 1:
		       return 'right';
		    break;
		    case 2:
		       return 'bottom';
		    break;
		    case 3:
		       return 'left';
		    break;
		}
	    }
	    function getPadding(element,direction){
		var dpadding = parseFloat(element.css("padding-"+direction)),
		    padding = parseFloat(element.css("padding"));
		    if(isNaN(padding)){
			padding = 0;
		    }
		return dpadding === 0 ? padding : dpadding;
	    }
	    
	    function getMargin(element,direction){
		var dpadding = parseFloat(element.css("margin-"+direction)),
		    padding = parseFloat(element.css("margin"));
		    if(isNaN(padding)){
			padding = 0;
		    }
		return dpadding === 0 ? padding : dpadding;
	    }
	    function align(){
		var defaultAlign = "center-center";
		if(settings.position.top !== null && settings.position.left !== null){
		    winObj.css({"top":settings.position.top + "px","left":settings.position.left+"px"});
		}else{
		    var setAlign = defaultAlign;
		    if($.inArray(settings.align,allowedAlign) >= 0){
			setAlign = settings.align;
		    }
		    var parent = winObj.parent();
		    if(parent.prop('tagName').toLowerCase() === "body"){
			parent = $(document);
		    }
		    var leftTop = setAlign.split("-"),
			w = parseFloat(parent.width()), 
			l = 0,t = 0, h = parseFloat(parent.height()),
			wobj = parseFloat(winObj.width()), hobj = parseFloat(winObj.height());

		    switch(leftTop[0]){
			case "center":{
			    l = w/2 - (wobj + getPadding(winObj,"left") + getPadding(winObj,"right"))/2;
			    break;
			}
			case "left":{
			    l = 0 + getMargin(winObj.parent(),"left");
			    break;
			}
			case "right":{
			    l = w - (wobj + getPadding(winObj,"left") + getPadding(winObj,"right") + getMargin(winObj.parent(),"right"));
			    break;
			}
		    }
		    switch(leftTop[1]){
			case "center":{
			    t = h/2 - (hobj + getPadding(winObj,"top") + getPadding(winObj,"bottom"))/2;
			    break;
			}
			case "top":{
			    t = 0 + getMargin(winObj.parent(),"top");;
			    break;
			}
			case "bottom":{
			    t = h - (hobj + getPadding(winObj,"top") + getPadding(winObj,"bottom") + getMargin(winObj.parent(),"bottom"));
			    break;
			}
		    }
		    winObj.css({"left":l + "px","top":t + "px"});
		}
	    }
	    //set new position
	    align();
	    //automated resizing
	    if(settings.autoAlign){
		$(window).on('resize',function(){
		    winObj.repeatAlign();
		});
	    }
	    return winObj;
        }else{
            throw 'Prípustné iba: '+ container;
        }
    };
}( jQuery ));