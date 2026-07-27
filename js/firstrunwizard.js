function showfirstrunwizard(){
	$.colorbox({
		opacity:0.4, 
		transition:"elastic", 
		speed:100, 
		width:"70%", 
		height:"70%", 
		href: OC.generateUrl('/apps/firstrunwizard/wizard'),
		onClosed : function(){
			$.ajax({
			url: OC.generateUrl('/apps/firstrunwizard/ajax/disable'),
			data: ""
			});
		}  
	});
}

$(document).on('click', '#showWizard', showfirstrunwizard);
$(document).on('click', '#closeWizard', $.colorbox.close);
