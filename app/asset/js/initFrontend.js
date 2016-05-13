$.ajaxSetup({
    type: 'POST',
    cache: true,
    beforeSend:function(jqXHR, settings){
	settings.data += "&origUrl="+settings.url;
	settings.url = "index.php";
    },
    data:{'isAjax':true}
});
$.fn.extend({
    findTrueHeight: function(){
	var height = parseFloat(this.height()),
	margin = parseFloat(this.css('margin-top')) + parseFloat(this.css('margin-bottom')),
	padding = parseFloat(this.css('padding-top')) + parseFloat(this.css('padding-bottom')),
	border = parseFloat(this.css('border-top-width')) + parseFloat(this.css('border-bottom-width'));
	return height + margin + padding + border;
    },
    findTrueWidth: function(){
	var width = parseFloat(this.width()),
	margin = parseFloat(this.css('margin-left')) + parseFloat(this.css('margin-right')),
	padding = parseFloat(this.css('padding-left')) + parseFloat(this.css('padding-right')),
	border = parseFloat(this.css('border-left-width')) + parseFloat(this.css('border-right-width'));
	return width + margin + padding + border;
    },
    calculateContent: function(){
	var cpHeight = parseFloat($('.content').parent().height());
	var cprevHeight = parseFloat($('.content').prev().height());
	return cpHeight - cprevHeight;
    }
});