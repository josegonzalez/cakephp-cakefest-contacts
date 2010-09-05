$(document).ready(function(){
	$('.ajax').live('click', function(){
		$this = $(this);
		if ($this.attr('rel')) {
			$($this.attr('rel')).load($this.attr('href'));
		} else {
			$this.prettyPhoto();
		}
	});
	
	$('form input').focus(function(){
		$(this).closest('div').stop().animate({ backgroundColor: "#a7bf51"}, 800);
	}).blur(function(){
		$(this).closest('div').stop().animate({ backgroundColor: "#ffffff"}, 800);
	});
	
	$("div.meta").each(function(i,div) {
		$(div).find("input").bind("change",function(e) {
			if ($(this).parents("div:first").find("input:first").val()=="" && 
				$(this).parents("div:first").prev().find("input:first").val()=="") {
				$(this).parents("div:first").hide();
			} else {
				$(this).parents("div:first").show();
				$(this).parents("div:first").next().find("input:first").trigger("change");
			}
		});
		$(div).find("input:first").trigger("change");
	});
});