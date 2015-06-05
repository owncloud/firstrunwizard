<?php
if ($_['enableAvatars']) {
	vendor_script('jcrop/js/jquery.Jcrop');
	vendor_style('jcrop/css/jquery.Jcrop');
	script('files', 'jquery.fileupload');
}
script('firstrunwizard', 'script');
style('firstrunwizard', 'style');
?>
<div id="app">
	<div id="firstrunwizard-left">
		<?php print_unescaped($this->inc('part.left')); ?>
	</div>

	<div id="firstrunwizard-content">
		<?php print_unescaped($this->inc('part.content')); ?>
	</div>

</div>