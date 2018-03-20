$("document").ready(function(){
	var bodyHeight = Math.round($("body").height());
	var windowHeight = Math.round($(window).height());
	
	if (windowHeight - bodyHeight > 0) {
		$("footer").css("margin-top", windowHeight - bodyHeight - 74 )
	}
});