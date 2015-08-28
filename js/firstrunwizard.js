function showfirstrunwizard(){
	$.colorbox({
		opacity:0.4, 
		transition:"elastic", 
		speed:100, 
		width:"70%", 
		height:"80%",
		closeButton:false,
		overlayClose:false,
		//data:true,
		scrolling:false,
		href: OC.filePath('firstrunwizard', '', 'wizard.php'),
		onComplete : function(){
			if (!SVGSupport()) {
				replaceSVG();
			}
			$('#displayavatar .avatardiv').avatar(OC.currentUser, 128, true);
		},
		onClosed : function(){
			$.ajax({
			url: OC.filePath('firstrunwizard', 'ajax', 'disable.php'),
			data: ""
			});
		}	
	});
}

function changeWizardValues() {
	var name = $(this).attr("name");
	var newValue = $('#' + name).val();
	var oldValue = $('#old' + name).val();
	
	if (newValue !== oldValue) {
		// Serialize the data
		var post = $('#'+ name +'form').serialize();
		var url = OC.generateUrl('apps/firstrunwizard/ajax/{filename}.php', {filename: name});

		$.post(url, post, function (data) {
			if (data.status === "success") {
				$('#old'+ name).val(newValue);
				// update displayName on the top right expand button
				if (name === "wizarddisplayname"){
					$('#expandDisplayName').text(newValue);
					if (newValue.slice(0,1) !== oldValue.slice(0,1)){
						updateAvatar();
					}
				}
			} else {
				$('#old'+ name).val('');
			}
			OC.msg.finishedSaving('#'+ name +'form .msg', data);
		});
	}
}


//function updateAvatar (hidedefault) {
//	var $headerdiv = $('#header .avatardiv');
//	var $displaydiv = $('#displayavatar .avatardiv');
//
//	if (hidedefault) {
//		$headerdiv.hide();
//		$('#header .avatardiv').removeClass('avatardiv-shown');
//	} else {
//		$headerdiv.css({'background-color': ''});
//		$headerdiv.avatar(OC.currentUser, 32, true);
//		$('#header .avatardiv').addClass('avatardiv-shown');
//	}
//	$displaydiv.css({'background-color': ''});
//	$displaydiv.avatar(OC.currentUser, 128, true);
//
//	$('#removeavatar').show();
//}
//
//function showAvatarCropper () {
//	var $cropper = $('#cropper');
//	$cropper.prepend("<img>");
//	var $cropperImage = $('#cropper img');
//
//	$cropperImage.attr('src',
//		OC.generateUrl('/avatar/tmp') + '?requesttoken=' + encodeURIComponent(oc_requesttoken) + '#' + Math.floor(Math.random() * 1000));
//
//	// Looks weird, but on('load', ...) doesn't work in IE8
//	$cropperImage.ready(function () {
//		$('#displayavatar').hide();
//		$cropper.show();
//
//		$cropperImage.Jcrop({
//			onChange: saveCoords,
//			onSelect: saveCoords,
//			aspectRatio: 1,
//			boxHeight: 500,
//			boxWidth: 500,
//			setSelect: [0, 0, 300, 300]
//		});
//	});
//}
//
//function sendCropData () {
//	cleanCropper();
//
//	var cropperData = $('#cropper').data();
//	var data = {
//		x: cropperData.x,
//		y: cropperData.y,
//		w: cropperData.w,
//		h: cropperData.h
//	};
//	$.post(OC.generateUrl('/avatar/cropped'), {crop: data}, avatarResponseHandler);
//}
//
//function saveCoords (c) {
//	$('#cropper').data(c);
//}
//
//function cleanCropper () {
//	var $cropper = $('#cropper');
//	$('#displayavatar').show();
//	$cropper.hide();
//	$('.jcrop-holder').remove();
//	$('#cropper img').removeData('Jcrop').removeAttr('style').removeAttr('src');
//	$('#cropper img').remove();
//}
//
//function avatarResponseHandler (data) {
//	var $warning = $('#avatar .warning');
//	$warning.hide();
//	if (data.status === "success") {
//		updateAvatar();
//	} else if (data.data === "notsquare") {
//		showAvatarCropper();
//	} else {
//		$warning.show();
//		$warning.text(data.data.message);
//	}
//}
//
//
//
//
//var uploadparms = {
//	done: function (e, data) {
//		avatarResponseHandler(data.result);
//	}
//};
//
//
//
//$('#uploadavatarbutton').click(function () {
//	$('#uploadavatar').click();
//});
//
//$('#uploadavatar').fileupload(uploadparms);
//
//$('#selectavatar').click(function () {
//	OC.dialogs.filepicker(
//		t('settings', "Select a profile picture"),
//		function (path) {
//			$.post(OC.generateUrl('/avatar/'), {path: path}, avatarResponseHandler);
//		},
//		false,
//		["image/png", "image/jpeg"]
//	);
//});
//
//$('#removeavatar').click(function () {
//	$.ajax({
//		type: 'DELETE',
//		url: OC.generateUrl('/avatar/'),
//		success: function () {
//			updateAvatar(true);
//			$('#removeavatar').hide();
//		}
//	});
//});
//
//$('#abortcropperbutton').click(function () {
//	cleanCropper();
//});
//
//$('#sendcropperbutton').click(function () {
//	sendCropData();
//});
//
//// does the user have a custom avatar? if he does hide #removeavatar
//// needs to be this complicated because we can't check yet if an avatar has been loaded, because it's async
//var url = OC.generateUrl(
//	'/avatar/{user}/{size}',
//	{user: OC.currentUser, size: 1}
//) + '?requesttoken=' + encodeURIComponent(oc_requesttoken);
//$.get(url, function (result) {
//	if (typeof(result) === 'object') {
//		$('#removeavatar').hide();
//	}
//});


$('#showWizard').live('click', function() {	
	showfirstrunwizard();
});

$('#closeWizard').live('click', function() {	
		$.colorbox.close();
});

$(document).on( "focusout", "#wizarddisplayname", changeWizardValues);
$(document).on( "focusout", "#wizardemail", changeWizardValues);