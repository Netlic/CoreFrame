(function( $ ) {
    $.fn.richText = function(options) {
        var rchtObj = this,doc = null,allocBtns = null, btnContainer = null;
	
	rchtObj.getEditor = function(){
	    return settings.editor;
	};
	rchtObj.getDocument = function(){
	    return doc;
	};
	rchtObj.clearText = function(){
	    doc.open();
	    doc.write('<p></p>');
	    doc.close();
	};
	rchtObj.inputText = function(text){
	    doc.open();
	    doc.write('<p>'+text+'</p>');
	    doc.close();
	};
	rchtObj.getButtonContainer = function(){
	    return btnContainer;
	};
	//rich text editor buttons
	var buttons = {
	    bold:{
		style: {"font-weight":"bold"},
		title: "Tučné\n\CTRL B",
		textRepre: "B",
		key: 66
	    },
	    italic : {
		style: {"font-style":"italic"},
		title: "Kurzíva\n\CTRL I",
		textRepre: "I",
		key: 73
	    },
	    underline : {
		style:{"text-decoration":"underline"},
		title: "Podčiarknutie\n\CTRL U",
		textRepre: "U",
		key: 85
	    },
	    undo:{
		style:{/*"font-size":"10px"*/},
		title: "Späť"
	    },
	    redo:{
		style:{/*"font-size":"10px"*/},
		title: "Dopredu"
	    },
	    cut:{
		style:{/*"font-size":"10px"*/},
		title: "Vystrihnúť"
	    },
	    copy:{
		style:{/*"font-size":"10px"*/},
		title: "Kopírovať"
	    },
	    paste:{
		style:{/*"font-size":"10px"*/},
		title: "Prilepiť"
	    },
	    justifyCenter:{
		style:{/*"font-size":"10px"*/},
		title: "Centrovať",
		textRepre: "Centrovať"
	    },
	    justifyLeft:{
		style:{/*"font-size":"10px"*/},
		title: "Zarovnať vľavo",
		textRepre: "Vľavo"
	    },
	    justifyRight:{
		style:{/*"font-size":"10px"*/},
		title: "Zarovnať vpravo",
		textRepre: "Vpravo"
	    },
	    justifyFull:{
		style:{/*"font-size":"10px"*/},
		title: "Zarovnať",
		textRepre: "Zarovnať"
	    }
        };
        
	//default settings
        var defaults = {
	    lang: "SK",
	    buttons: 'bold,italic,underline,undo,redo,justifyCenter,justifyLeft,justifyRight,justifyFull',
	    buttonDefaultStyle:{
		
	    },
	    editor: null,
	    editorDefaultStyle: {
		"border-top":"1px grey solid"
	    },
	    initText:"Sem napíšte text",
	    customButton:{}
	};
	
        var settings = $.extend(true, {}, defaults, options);
        
	function start(){
	    var btnDiv = $('<div></div>').addClass('btn-div').css({"text-align":"center"}),
		editor = $('<iframe></iframe>').addClass('rchtext-custom');
	    btnContainer = btnDiv;
	    btnDiv.append(addButtons());
	    rchtObj
		.css({"clear":"both"})
		.append(btnDiv)
		.append(editor);
	    allocBtns = btnDiv.find('.func-btn').css({"text-align":"center","min-width":"25px"});
	    var h = parseFloat(rchtObj.height()) - parseFloat(btnDiv.height());
	    editor.css({"width":"100%","height":h+"px"/*,"border":"none"*/});
	    settings.editor = editor;
	    doc = editor[0].contentWindow.document;
	    doc.designMode="on";
	    doc.open();
	    doc.write('<p>'+settings.initText+'</p>');
	    doc.close();
	}
	
	function addButtons(){
	    var btns = $('<div/>').css({"height":"1cm"});
	    $.each(settings.buttons.split(','), function(key, btn){
		btns.append(createButton(btn));
	    });
	    return btns;
	}
	
	function createButton(btn){
	    var text = btn;
	    var bunka = $('<div style="display: inline-block;"></div>');
	    if(typeof(buttons[btn]) !== "undefined"){
		text = buttons[btn].textRepre || buttons[btn].key || btn;
		bunka
		    .attr('title',buttons[btn].title)
		    .addClass('func-btn')
		    .attr('data-cmd',btn)
		    .css(buttons[btn].style);
		if(typeof settings.customButton[btn] === "undefined"){
		    bunka.text(text);
		}else{
		    bunka.append(settings.customButton[btn]);
		}
	    }
	    return bunka;
	}
	
	function buttonCall(cmd){
	    settings.editor.focus();
	    try{ 
		doc.execCommand("styleWithCSS", false, false); 
	    }catch(e){ 
		try{ 
		    doc.execCommand("useCSS", false, true); 
		}catch(e2){}
	    }
	    try{
		doc.execCommand(cmd, false, buttons[cmd].param);
	    }catch(e){
		throw e;
	    }
	}
	
	function getHotkey(btn){
	    return buttons[btn].key;
	}
	
	start();
        settings.editor.css(settings.editorDefaultStyle);
	
	allocBtns.unbind('click').on('click',function(e){
	    buttonCall($(e.target).attr('data-cmd'));
	});
	
	$(doc).on('keydown',function(e){
	    if(e.ctrlKey){
		$.each(settings.buttons.split(','), function(key, btn){
		    var hk = getHotkey(btn);
		    if(hk && hk === e.keyCode){
			e.preventDefault();
			buttonCall(btn);
		    }
		});
	    }
	});
	return rchtObj;
    };
}( jQuery ));