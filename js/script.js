/**
 * ownCloud - firstrunwizard
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Your Name <mail@example.com>
 * @copyright Your Name 2015
 */

'use strict';

(function ($, OC) {
	$(document).ready(function () {
		
		function changeValues() {
			var name = $(this).attr('name');
			var newValue = $('#' + name).val();
			var oldValue = $('#old' + name).val();

			if (newValue !== oldValue) {
				var data = {newValue: newValue};
				var url = OC.generateUrl('/apps/firstrunwizard/' + name);
				$.post(url, data, function (response) {
					if (response.status === "success") {
						$('#old' + name).val(newValue);
						if (name === "displayname"){
							// update displayName on the top right expand button
							$('#expandDisplayName').text(newValue);
							if (newValue.slice(0,1) !== oldValue.slice(0,1) && ($('#avatar').length > 0)) {
								updateAvatar();
							}
						}
					} else {
						$('#old' + name).val('');
					}
					OC.msg.finishedAction('#' + name + 'form .msg', response);
				});
			}
		}
		
		function updateAvatar (hidedefault) {
			var $headerdiv = $('#header .avatardiv');
			var $displaydiv = $('#displayavatar .avatardiv');

			if (hidedefault) {
				$headerdiv.hide();
				$('#header .avatardiv').removeClass('avatardiv-shown');
			} else {
				$headerdiv.css({'background-color': ''});
				$headerdiv.avatar(OC.currentUser, 32, true);
				$('#header .avatardiv').addClass('avatardiv-shown');
			}
			$displaydiv.css({'background-color': ''});
			$displaydiv.avatar(OC.currentUser, 128, true);

			$('#removeavatar').show();
		}
		
		function showAvatarCropper () {
			var $cropper = $('#cropper');
			$cropper.prepend("<img>");
			var $cropperImage = $('#cropper img');

			$cropperImage.attr('src',
				OC.generateUrl('/avatar/tmp') + '?requesttoken=' + 
						encodeURIComponent(oc_requesttoken) + '#' + 
						Math.floor(Math.random() * 1000)
						);

			// Looks weird, but on('load', ...) doesn't work in IE8
			$cropperImage.ready(function () {
				$('#displayavatar').hide();
				$cropper.show();

				$cropperImage.Jcrop({
					onChange: saveCoords,
					onSelect: saveCoords,
					aspectRatio: 1,
					boxHeight: 500,
					boxWidth: 500,
					setSelect: [0, 0, 300, 300]
				});
			});
		}

		function sendCropData () {
			cleanCropper();

			var cropperData = $('#cropper').data();
			var data = {
				x: cropperData.x,
				y: cropperData.y,
				w: cropperData.w,
				h: cropperData.h
			};
			$.post(OC.generateUrl('/avatar/cropped'), {crop: data}, avatarResponseHandler);
		}

		function saveCoords (c) {
			$('#cropper').data(c);
		}

		function cleanCropper () {
			var $cropper = $('#cropper');
			$('#displayavatar').show();
			$cropper.hide();
			$('.jcrop-holder').remove();
			$('#cropper img').removeData('Jcrop').removeAttr('style').removeAttr('src');
			$('#cropper img').remove();
		}
		
		function avatarResponseHandler (data) {
			var $warning = $('#avatar .warning');
			$warning.hide();
			if (data.status === "success") {
				updateAvatar();
			} else if (data.data === "notsquare") {
				showAvatarCropper();
			} else {
				$warning.show();
				$warning.text(data.data.message);
			}
		}

		if ($('#avatar').length > 0){
			var uploadparms = {
				done: function (e, data) {
					avatarResponseHandler(data.result);
				}
			};

			$('#uploadavatarbutton').click(function () {
				$('#uploadavatar').click();
			});

			$('#uploadavatar').fileupload(uploadparms);

			$('#selectavatar').click(function () {
				OC.dialogs.filepicker(
					t('settings', "Select a profile picture"),
					function (path) {
						$.post(OC.generateUrl('/avatar/'), {path: path}, avatarResponseHandler);
					},
					false,
					["image/png", "image/jpeg"]
				);
			});

			$('#removeavatar').click(function () {
				$.ajax({
					type: 'DELETE',
					url: OC.generateUrl('/avatar/'),
					success: function () {
						updateAvatar(true);
						$('#removeavatar').hide();
					}
				});
			});

			$('#abortcropperbutton').click(function () {
				cleanCropper();
			});

			$('#sendcropperbutton').click(function () {
				sendCropData();
			});

			// does the user have a custom avatar? if he does hide #removeavatar
			// needs to be this complicated because we can't check yet if an avatar has been loaded, because it's async
			var url = OC.generateUrl(
				'/avatar/{user}/{size}',
				{user: OC.currentUser, size: 1}
			) + '?requesttoken=' + encodeURIComponent(oc_requesttoken);

			$.get(url, function (result) {
				if (typeof(result) === 'object') {
					$('#removeavatar').hide();
				}
			});
		}
		
		$(document).on('focusout', '#displayname', changeValues);
		$(document).on('focusout', '#email', changeValues);
		
		$("#app").dialog({
			height: 650,
			width: 1000,
			closeOnEscape: false,
			modal: true,
			close: function() {
				var url = OC.generateUrl('/apps/firstrunwizard/close');
				$.post(url, function(response) {
					$(location).attr('href', response.defaultPageUrl);
				});
			}
		});
	});
})(jQuery, OC);