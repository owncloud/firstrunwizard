function showfirstrunwizard(){
	url = OC.generateUrl('/apps/firstrunwizard/');
	$.get(url, function (response){
		$.colorbox({
		opacity:0.4, 
		transition:"elastic", 
		speed:100, 
		width:"70%", 
		height:"70%", 
		html: response,
		onComplete : function(){
			if (!SVGSupport()) {
				replaceSVG();
			}
		}
		});
	})
}

$('#showWizard').live('click', function () {	
	showfirstrunwizard();
});

$('#closeWizard').live('click', function () {	
		$.colorbox.close();
});