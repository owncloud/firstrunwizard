<div id="firstrunwizard-content">
	<span class="welcome">
		<h1><?php p($l->t('Welcome to %s', array($theme->getTitle()))); ?></h1>
		<?php if (OC_Util::getEditionString() === ''): ?>
			<p><?php p($l->t('Your personal web services. All your files, contacts, calendar and more, in one place.')); ?></p>
		<?php else: ?>
			<p><?php p($theme->getSlogan()); ?></p>
		<?php endif; ?>
		<hr>
	</span>
	
	<h2><?php p($l->t('Take time to enter or update your personal information.')); ?></h2>
	
	<?php if ($_['displayName'] !== null): ?>
		<form id="displaynameform">
			<h3>
				<label for="displayname"><?php p($l->t('Full name')) ?></label>
			</h3>
			<input type="text" id="displayname" name="displayname"
				   value="<?php p($_['displayName']) ?>"
				   autocomplete="on" autocapitalize="off" autocorrect="off" autofocus/>
			<span class="msg"></span>
			<input type="hidden" id="olddisplayname" name="olddisplayname" value="<?php p($_['displayName']) ?>" />
		</form>
	<?php endif; ?>

	<?php if ($_['email'] !== null): ?>
		<form id="emailform">
			<h3><label for="email"><?php p($l->t('Email')); ?></label></h3>
			<input type="email" name="email" id="email" value="<?php p($_['email']); ?>"
				   placeholder="<?php p($l->t('Your email address')); ?>"
				   autocomplete="on" autocapitalize="off" autocorrect="off" />
			<span class="msg"></span><br />
			<input type="hidden" id="oldemail" name="oldemail" value="<?php p($_['email']) ?>" />
		</form>
	<?php endif; ?>

	<?php if ($_['enableAvatars']): ?>
	<form id="avatar" method="post" action="<?php p(\OC_Helper::linkToRoute('core.avatar.postAvatar')); ?>">
		<h3><?php p($l->t('Profile picture')); ?></h3>
		<div id="displayavatar">
			<div class="avatardiv"></div><br>
			<div class="warning hidden"></div>
			<?php if ($_['avatarChangeSupported']): ?>
			<div class="inlineblock button" id="uploadavatarbutton"><?php p($l->t('Upload new')); ?></div>
			<input type="file" class="hidden" name="files[]" id="uploadavatar">
			<div class="inlineblock button" id="selectavatar"><?php p($l->t('Select new from Files')); ?></div>
			<div class="inlineblock button" id="removeavatar"><?php p($l->t('Remove image')); ?></div><br>
			<?php p($l->t('Either png or jpg. Ideally square but you will be able to crop it.')); ?>
			<?php else: ?>
			<?php p($l->t('Your avatar is provided by your original account.')); ?>
			<?php endif; ?>
		</div>
		<div id="cropper" class="hidden">
			<div class="inlineblock button" id="abortcropperbutton"><?php p($l->t('Cancel')); ?></div>
			<div class="inlineblock button primary" id="sendcropperbutton"><?php p($l->t('Choose as profile image')); ?></div>
		</div>
	</form>
	<?php endif; ?>
</div>