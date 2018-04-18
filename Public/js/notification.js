if ($("#alert")){
	$("#alert-container").append($("#alert"));

	window.setTimeout(function() {
	$("#alert").fadeTo(500, 0).slideUp(500, function(){
	$(this).remove();
	    });
	}, 4000);

	// Adjusts margin when url contains 'authentification'
	var url = $(location).attr('href');
	var result = url.search('authentification');
	if (result > -1) {
		var height = ($('nav').height()  + parseInt($('nav').css('padding-top')) + parseInt($('nav').css('padding-bottom')));
		$("#alert-container").css('top', height);
	}
}