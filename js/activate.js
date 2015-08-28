$(function () {
	//do not show when upgrade is in progress or an error message
	//is visible on the login page
	if ($('#upgrade').length === 0 && $('#body-login .error').length === 0) {
		showfirstrunwizard();
	}
});
