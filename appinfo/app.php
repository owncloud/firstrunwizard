<?php
/**
 * ownCloud - firstrunwizard
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Renaud Fortier <renaud.fortier@fsaa.ulaval.ca>
 * @copyright Renaud Fortier 2015
 */

namespace OCA\FirstRunWizard\AppInfo;

if (\OCP\User::isLoggedIn()) {
	$config = \OC::$server->getConfig();
	$user = \OC::$server->getUserSession()->getUser();
	
	//uncomment for testing
	//$config->setUserValue($user->getUID() , 'firstrunwizard' , 'show' , '1' );
	
	if ($config->getUserValue($user->getUID() , 'firstrunwizard' , 'show' , '1' ) === '1'){
		header('Location: ' . \OC::$server->getURLGenerator()->linkToRoute('firstrunwizard.page.index'));
	}
}
