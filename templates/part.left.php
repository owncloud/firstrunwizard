<div id="firstrunwizard-left">
	<h2><?php p($l->t('Get the apps to sync your files')); ?></h2>

	<a target="_blank" href="<?php p($_['clients']['desktop']); ?>">
	<img src="<?php print_unescaped(OCP\Util::imagePath('core', 'desktopapp.png')); ?>"
		 alt="<?php p($l->t('Desktop client')); ?>" />
	</a>
	<a target="_blank" href="<?php p($_['clients']['android']); ?>">
	<img src="<?php print_unescaped(OCP\Util::imagePath('core', 'googleplay.png')); ?>"
		 alt="<?php p($l->t('Android app')); ?>" />
	</a>
	<a target="_blank" href="<?php p($_['clients']['ios']); ?>">
	<img src="<?php print_unescaped(OCP\Util::imagePath('core', 'appstore.png')); ?>"
		 alt="<?php p($l->t('iOS app')); ?>" />
	</a>

	<?php if (OC_Util::getEditionString() === ''): ?>
		<h2><?php p($l->t('Connect your desktop apps to %s', array($theme->getName()))); ?></h2>
		<a target="_blank" class="button" href="<?php p(link_to_docs('user-sync-calendars')) ?>">
			<img class="appsmall appsmall-calendar svg" alt=""
				 src="<?php print_unescaped(OCP\Util::imagePath('core', 'places/calendar-dark.svg')); ?>" />
		<?php p($l->t('Connect your Calendar')); ?>
		</a>
		<a target="_blank" class="button" href="<?php p(link_to_docs('user-sync-contacts')) ?>">
			<img class="appsmall appsmall-contacts svg" alt=""
				 src="<?php print_unescaped(OCP\Util::imagePath('core', 'places/contacts-dark.svg')); ?>" />
		<?php p($l->t('Connect your Contacts')); ?>
		</a>
		<a target="_blank" class="button" href="<?php p(link_to_docs('user-webdav')); ?>">
			<img class="appsmall svg" alt=""
				 src="<?php print_unescaped(OCP\Util::imagePath('core', 'places/folder.svg')); ?>" />
		<?php p($l->t('Access files via WebDAV')); ?>
		</a>
	<?php else: ?>
		<br><br><br>
		<a target="_blank" class="button" href="<?php p(link_to_docs('user-manual')); ?>">
			<img class="appsmall svg" src="<?php print_unescaped(OCP\Util::imagePath('settings', 'help.svg')); ?>" /> <?php p($l->t('Documentation')); ?>
		</a>
		<a target="_blank" class="button" href="<?php p(link_to_docs('user-webdav')); ?>">
			<img class="appsmall svg" src="<?php print_unescaped(OCP\Util::imagePath('core', 'places/folder.svg')); ?>" /> <?php p($l->t('Access files via WebDAV')); ?>
		</a>
	<?php endif; ?>
</div>