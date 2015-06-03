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
	<div id="app-navigation">
		<div id="firstrunwizard">
			<?php print_unescaped($this->inc('part.left')); ?>
		</div>
	</div>

	<div id="app-content">
		<div id="app-content-wrapper">
			<div id="firstrunwizard">
				<?php print_unescaped($this->inc('part.content')); ?>
			</div>
		</div>
	</div>
</div>