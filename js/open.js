/**
 * ownCloud - firstrunwizard
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Renaud Fortier <renaud.fortier@fsaa.ulaval.ca>
 * @copyright Renaud Fortier 2015
 */

$(document).ready(function () {
	'use strict';
	//do not show when upgrade is in progress or an error message
	//is visible on the login page
	if ($('#upgrade').length === 0 && $('#body-login .error').length === 0) {
		$(function (){
			$('<div></div>').dialog({
				modal: true,
				height: 650,
				width: 1000,
				closeOnEscape: false,
				open: function (){
					$(this).load(OC.generateUrl('/apps/firstrunwizard/'));
				},
				close: function() {
					$(this).remove();
				}
			});
		});
	}
});