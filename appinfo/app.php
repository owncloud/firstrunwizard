<?php
/**
 * ownCloud - firstrunwizard
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Your Name <mail@example.com>
 * @copyright Your Name 2015
 */

namespace OCA\FirstRunWizard\AppInfo;

if (\OCP\User::isLoggedIn()) {
	$config = \OC::$server->getConfig();
	$user = \OC::$server->getUserSession()->getUser();

	if ($config->getUserValue($user->getUID() , 'firstrunwizard' , 'show' , '1' ) === '1'){
		header('Location: ' . \OC::$server->getURLGenerator()->linkToRoute('firstrunwizard.page.index'));
	}

}
