function ComboBox(element){
    this.Init(element);
}

ComboBox.prototype = {
    rozlisenie_X : null,
    rozlisenie_Y : null,
    comboboxes : null,
    options : null,
    active_element : null,
    animate : false,
    selected_color : null,
    selected_font_color : null,
    cursor_color : null,
    cursor_font_color : null,
    
    Init: function(element){
        this.rozlisenie_X = $(window).width();
        this.rozlisenie_Y = $(window).height();
    
        this.comboboxes = [];
        this.options = [];
        this.selected_color = 'black';
        this.selected_font_color = 'white';
        this.cursor_color = 'orange';
        this.cursor_font_color = 'white';
        if(typeof(element) != 'undefined'){
            if($.isArray(element)){
                for(var i = 0; i < element.length; i++){
                    this.comboboxes.push({'element':element[i],'options':[]})
                }
            }
            else{
                this.comboboxes.push({'element':element,'options':[]})
            }
            if(this.comboboxes.length > 0){
                this.active_element = this.comboboxes[0];
            }
        }
    },
    
    AddOption: function(options,elements){
        if(typeof(options) != 'undefined'){
            var index = -1
            if(typeof(elements) != 'undefined'){
                var h_field = [];
                for(var key in this.comboboxes){
                    h_field.push(this.comboboxes[key]['element'])
                }
                if(jQuery.isArray(elements)){
                    for(var element in elements){
                        if($.isNumeric(element)){
                            index = element
                        }else{
                            index = jQuery.inArray(element, h_field)
                        }
                        if(index > -1){
                            if(jQuery.isArray(options)){
                                for(var option in options){
                                    this.comboboxes[index]['options'].push(options[option])
                                }
                            }else{
                                this.comboboxes[index]['options'].push(options)
                            }
                        }else{
                            throw "Element nen·jden˝, metÛda 'AddOption()'"
                        }
                    }
                }else{
                    if($.isNumeric(elements)){
                        index = elements
                    }else{
                        index = jQuery.inArray(elements, h_field)
                    }
                    if(index > -1){
                        if(jQuery.isArray(options)){
                            for(option in options){
                                
                                this.comboboxes[index]['options'].push(options[option])
                            }
                        }else{
                            this.comboboxes[index]['options'].push(options)
                        }
                    }else{
                        throw "Element nen·jden˝, metÛda 'AddOption()'"
                    }
                }
            }else{
                if(this.comboboxes.length > 0){
                    index = jQuery.inArray(this.active_element, this.comboboxes)
                    if(jQuery.isArray(options)){
                        for(option in options){
                            this.comboboxes[index]['options'].push(options[option])
                        }
                    }else{
                        this.comboboxes[index]['options'].push(options)
                    }
                }else{
                    throw "Neexistuj˙ci element, metÛda 'AddOption()'";
                }
            }
        }else{
            throw "AspoÚ jedna moûnosù musÌ byù öpecifikovan·, metÛda 'AddOption()'";
        }
    },
    
    CreateComboBoxAll: function(){
        this.CreateComboBoxDef(null,0)
    },
    
    CreateComboBoxDef: function(element,flag){
        var pos_y = 0;
        var pos_x = 0;
        var h_field = [];
        var selected_color = this.selected_color;
        var selected_font_color = this.selected_font_color;
        var cursor_color = this.cursor_color;
        var cursor_font_color = this.cursor_font_color;
        var rozlisenie_Y = this.rozlisenie_Y;
        var cbbxs = this.comboboxes
        var el = [];
        for(var key in cbbxs){
            h_field.push(cbbxs[key]['element'])
        }
        switch(flag){
            case 0:{
                el = h_field
                break
            }
            case 1:{
                el.push(element)
                break
            }
        }
        for(var fe = 0; fe < el.length; fe++){
            $(el[fe]).unbind('focusout').focusout(function(){
                var option_box = $(this).next()
                $('body').unbind('click').click(function(){
                    option_box.css('display','none')
                    $('body').unbind('click')
                })
                
            })
            $(el[fe]).unbind('click').click(function(){
                if($(this).next().css('display') == 'none'){
                    pos_y = parseFloat($(this).position().top) + parseFloat($(this).height())
                    pos_x = parseFloat($(this).position().left)
                    $(this).next().css({'display':'block',
                                        'top':pos_y+'px',
                                        'left':pos_x+'px'})
                }else{
                    $(this).next().css('display','none')
                }
            })
            pos_y = parseFloat($(el[fe]).position().top) + parseFloat($(el[fe]).height())
            
            pos_x = parseFloat($(el[fe]).position().left)
            var options = "";
            var pos_element = 0
            pos_element = $.inArray(el[fe], h_field)
            
            if(pos_element > -1){
                for(var o in cbbxs[pos_element]['options']){
                    options += '<div style = "cursor:pointer;font-size:12px">'+cbbxs[pos_element]['options'][o]+'</div>'
                }
            }else{
                throw "Element nen·jden˝ CreateComboBoxDef()"
            }
            
            var v_option_box = 100;
            if((parseInt(pos_y) + v_option_box) >= rozlisenie_Y){
                v_option_box -= (parseInt(pos_y) + v_option_box) - rozlisenie_Y - 10
            }
            $(el[fe]).after('<div data-set = "option_box" style = "overflow:auto;display:none;position:absolute;top:'+pos_y+'px;left:'+pos_x+'px;width:'+$(el[fe]).width()+'px;height:'+v_option_box+'px;background-color:white">'+options+'</div>')
            
            var $option_box = $(el[fe]).next()
            $option_box.children().each(function(){
                $(this).unbind('click').click(function(){
                    $option_box.prev().val($(this).text())
                    $option_box.fadeOut(10)
                    $option_box.prev().change()
                })
                $(this).unbind('mouseenter').mouseenter(function(){
                    $(this).css({'background-color':cursor_color,
                                 'color':cursor_font_color})
                })
                $(this).unbind('mouseleave').mouseleave(function(){
                    $(this).css({'background-color':'white',
                                 'color':'black'})
                })
                $(this).focus(function(){
                    $(this).unbind('mouseenter').mouseenter(function(){
                        $(this).css({'background-color':cursor_color,
                                     'color':cursor_font_color})
                    })
                })
            })
            var arrow_down = 0;
            var arrow_up = 0;
            var scroll_down = 0;
            var scroll_up = 0;
            $(el[fe]).keyup(function(event){
                var input = $(this)
                switch(event.keyCode){
                    case 13:{
                        var p_zhodnych = $(this).next().children().filter(function(){
                            return $(this).text().indexOf(input.val()) >= 0
                        })
                        if(p_zhodnych.length == 1){
                            input.val(p_zhodnych.text())
                            input.next().css({'display':'none'});
                            input.change()
                        }    
                        break;
                    }
                    case 38:{
                        $option_box.children().eq(($option_box.children().length - 1) - parseInt(arrow_up)).css({'background-color':cursor_color,
                                                                                                                 'color':cursor_font_color})
                        var overflowed = $option_box.children().eq(($option_box.children().length - 1) - parseInt(arrow_up)).position().top
                        if(overflowed < 0){
                            scroll_down += overflowed
                            scroll_up += overflowed
                            $option_box.animate({
                               scrollTop:scroll_up
                           })
                        }
                        
                        input.val($option_box.children().eq(($option_box.children().length - 1) - parseInt(arrow_up)).text())
                        if(arrow_up > 0){
                            $option_box.children().eq(($option_box.children().length) - parseInt(arrow_up)).css({'background-color':'white',
                                                                                                                 'color':'black'})
                        }
                        if(($option_box.children().length -1) - parseInt(arrow_up) < 0){
                            scroll_up = $option_box.children(':last').position().top + $option_box.children().eq(0 + parseInt(arrow_down)).height()-$option_box.height()
                            scroll_down = $option_box.prop('scrollHeight')
                            $option_box.animate({
                               scrollTop: scroll_down
                            })
                            arrow_up = 0
                        }
                        arrow_down = $option_box.children().length - parseInt(arrow_up)
                        arrow_up++;
                        //alert(scroll_up)
                        break;
                    }
                    case 40:{
                        if((0 + parseInt(arrow_down)) == $option_box.children().length){
                            scroll_up = 0 - $option_box.prop('scrollHeight')
                            scroll_down = 0
                            $option_box.animate({
                               scrollTop: scroll_up
                            })
                            $option_box.children().eq($option_box.children().length-1).css({'background-color':'white',
                                                                                            'color':'black'})
                            arrow_down = 0
                        }
                        $option_box.children().eq(0 + parseInt(arrow_down)).css({'background-color':cursor_color,
                                                                                 'color':cursor_font_color})
                        
                        overflowed = $option_box.children().eq(0 + parseInt(arrow_down)).position().top + $option_box.children().eq(0 + parseInt(arrow_down)).height()
                        if(overflowed > $option_box.height()){
                           
                           scroll_up += (overflowed-$option_box.height())
                           scroll_down += (overflowed-$option_box.height())
                           $option_box.animate({
                               scrollTop:scroll_down
                           })
                        }
                        
                        arrow_up = $option_box.children().length - (parseInt(arrow_down))
                        input.val($option_box.children().eq(0 + parseInt(arrow_down)).text())
                        if(arrow_down > 0){
                            $option_box.children().eq(0 + parseInt(arrow_down) - 1).css({'background-color':'white',
                                                                                         'color':'black'})
                        }
                        arrow_down++;
                        //alert(scroll_up)
                        break;
                    }
                   default:{
                        var hladaj_retaz = $(this).next().children().filter(function(){
                            return $(this).text().indexOf(input.val()) >= 0
                        })
                                
                        $(this).next().children().filter(function(){
                            return $(this).text().indexOf(input.val()) < 0
                        }).fadeOut(500)
                        
                        if(hladaj_retaz.length > 0){
                            hladaj_retaz.each(function(){
                                $(this).fadeIn(500)
                                var povodny = $(this).text()
                                var pozicia = povodny.indexOf(input.val())
                                var zac_str = povodny.substring(0, pozicia)
                                var vyz_str = povodny.substring(pozicia,pozicia+input.val().length)
                                var kon_str = povodny.substring(pozicia+input.val().length,povodny.length)
                                $(this).html(zac_str+'<label style = "background-color:'+selected_color+';color:'+selected_font_color+'">'+vyz_str+'</label>'+kon_str)
                            })
                        }
                        break;
                    }
                }
            })
        }
    },
    
    SelectOptionBox: function(element){
        var ret = null
        if(typeof(element) != 'undefined'){
            if($.isArray(element)){
                for(var i = 0;i < element.length; i++){
                    if($.isNumeric(element)){
                        if($(this.comboboxes[element]['element']).next().prop('tagName') != "DIV" || $(this.comboboxes[element]['element']).next()!= 'option_box'){
                            this.CreateComboBoxDef(this.comboboxes[element]['element'], 1)
                        }
                        ret = $(this.comboboxes[element]['element']).next()
                    }else{
                        if($(element).next().prop('tagName') != "DIV" || $(element).next().attr('data') == 'option_box'){
                            this.CreateComboBoxDef(element, 1)
                        }
                        ret = $(element).next()
                    }
                }
            }else{
                if($.isNumeric(element)){
                    if($(this.comboboxes[element]['element']).next().prop('tagName') != "DIV" || $(this.comboboxes[element]['element']).next()!= 'option_box'){
                        this.CreateComboBoxDef(this.comboboxes[element]['element'], 1)
                    }
                    ret = $(this.comboboxes[element]['element']).next()
                }else{
                    if($(element).next().prop('tagName') != "DIV" || $(element).next().attr('data-set') != 'option_box'){
                        this.CreateComboBoxDef(element, 1)
                    }
                    ret = $(element).next()
                }
            }
        }else{
            this.CreateComboBoxDef(this.active_element['element'], 1)
        }
        return ret;
    },
    
    GetDeafultOption : function (option) {
        var o = ""
        var cursor_color = this.cursor_color;
        var cursor_font_color = this.cursor_font_color;
        if(typeof(option) != 'undefined')
            o = option
        return $('<div></div>').css({'cursor':'pointer',
                                     'font-size':'12px'})
                               .text(o)
                               .unbind('click').click(function(){
                                    $(this).parent().prev().val($(this).text())
                                    $(this).parent().css({'display':'none'})
                                })
                                .unbind('mouseenter').mouseenter(function(){
                                    $(this).css({'background-color':cursor_color,
                                                 'color':cursor_font_color})
                                })
                                .unbind('mouseleave').mouseleave(function(){
                                    $(this).css({'background-color':'white',
                                                 'color':'black'})
                                })
                                .focus(function(){
                                    $(this).unbind('mouseenter').mouseenter(function(){
                                        $(this).css({'background-color':cursor_color,
                                                     'color':cursor_font_color})
                                    })
                                })
    },
    
    GetOptions : function(element){
        if (typeof(element) != 'undefined') {
            if($.isNumeric(elements)){
                index = elements
            }else{
                index = jQuery.inArray(elements, h_field)
            }
        }else{
            index = jQuery.inArray(this.active_element, this.comboboxes)
        }
        return this.comboboxes[index]['options'];
    },
    
    RemoveOption : function(options,elements){
        if(typeof(options) != 'undefined'){
            var index = -1
            if(typeof(elements) != 'undefined'){
                var h_field = [];
                for(var key in this.comboboxes){
                    h_field.push(this.comboboxes[key]['element'])
                }
                if(jQuery.isArray(elements)){
                    for(var element in elements){
                        if($.isNumeric(element)){
                            index = element
                        }else{
                            index = jQuery.inArray(element, h_field)
                        }
                        if(index > -1){
                            if(jQuery.isArray(options)){
                                for(var option in options){
                                    var option_box = $(this.comboboxes[index]['element'])
                                    if(option_box.next().prop('tagName') == "DIV" && option_box.next().attr('data-set') == 'option_box'){
                                        option_box.next().children().eq($.inArray(options[option], this.comboboxes[index]['options'])).remove()
                                    }
                                    this.comboboxes[index]['options'].splice($.inArray(options[option], this.comboboxes[index]['options']),1)
                                }
                            }else{
                                if(option_box.next().prop('tagName') == "DIV" && option_box.next().attr('data-set') == 'option_box'){
                                    option_box.next().children().eq($.inArray(options, this.comboboxes[index]['options'])).remove()
                                }
                                this.comboboxes[index]['options'].splice($.inArray(options, this.comboboxes[index]['options']),1)
                            }
                        }else{
                            throw "Element nen·jden˝, metÛda 'AddOption()'"
                        }
                    }
                }else{
                    if($.isNumeric(elements)){
                        index = elements
                    }else{
                        index = jQuery.inArray(elements, h_field)
                    }
                    if(index > -1){
                        if(jQuery.isArray(options)){
                            for(option in options){
                                option_box = $(this.comboboxes[index]['element'])
                                if(option_box.next().prop('tagName') == "DIV" && option_box.next().attr('data-set') == 'option_box'){
                                    option_box.next().children().eq($.inArray(options[option], this.comboboxes[index]['options'])).remove()
                                }
                                this.comboboxes[index]['options'].splice($.inArray(options[option], this.comboboxes[index]['options']),1)
                            }
                        }else{
                            option_box = $(this.comboboxes[index]['element'])
                            if(option_box.next().prop('tagName') == "DIV" && option_box.next().attr('data-set') == 'option_box'){
                                option_box.next().children().eq($.inArray(options, this.comboboxes[index]['options'])).remove()
                            }
                            this.comboboxes[index]['options'].splice($.inArray(options, this.comboboxes[index]['options']),1)
                        }
                    }else{
                        throw "Element nen·jden˝, metÛda 'RemoveOption()'"
                    }
                }
            }else{
                if(this.comboboxes.length > 0){
                    index = jQuery.inArray(this.active_element, this.comboboxes)
                    if(jQuery.isArray(options)){
                        for(option in options){
                            option_box = $(this.comboboxes[index]['element'])
                            if(option_box.next().prop('tagName') == "DIV" && option_box.next().attr('data-set') == 'option_box'){
                                option_box.next().children().eq($.inArray(options[option], this.comboboxes[index]['options'])).remove()
                            }
                            this.comboboxes[index]['options'].splice($.inArray(options[option], this.comboboxes[index]['options']),1)
                        }
                    }else{
                        option_box = $(this.comboboxes[index]['element'])
                        if(option_box.next().prop('tagName') == "DIV" && option_box.next().attr('data-set') == 'option_box'){
                            option_box.next().children().eq($.inArray(options, this.comboboxes[index]['options'])).remove()
                        }
                        this.comboboxes[index]['options'].splice($.inArray(options, this.comboboxes[index]['options']),1)
                    }
                }else{
                    throw "Neexistuj˙ci element, metÛda 'RemoveOption()'";
                }
            }
        }else{
            if(this.comboboxes.length > 0){
                index = jQuery.inArray(this.active_element, this.comboboxes)
                option_box = $(this.comboboxes[index]['element'])
                if(option_box.next().prop('tagName') == "DIV" && option_box.next().attr('data-set') == 'option_box'){
                    option_box.next().children().remove()
                }
                this.comboboxes[index]['options'] = []
            }else{
                throw "Neexistuj˙ci element, metÛda 'RemoveOption()'";
            }
        }
    },
    
    SetActiveElement: function(){
        
    }
}
