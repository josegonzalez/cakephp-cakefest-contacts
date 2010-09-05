$(document).ready(function(){
	// Stylizes the form based on focus
	$('form div.input input').focus(function(){
		$(this).closest('div').stop().addClass('active');
	}).blur(function(){
		$(this).closest('div').stop().removeClass('active');
	});
	
	// Adds new meta field inputs as fields are consumed
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
	
	// Sliding animation for index list
	$(".accordion .head").toggle(function() {
		$(this).addClass('expanded').children().slideDown("slow");
	}, function() {
		$this = $(this);
		$this.children().slideUp("slow", function () {
			$this.removeClass('expanded');
		});
	}).children().hide();
});