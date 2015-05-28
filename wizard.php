<?php

/**
* ownCloud - First Run Wizard
*
* @author Frank Karlitschek
* @copyright 2012 Frank Karlitschek frank@owncloud.org
*
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
* License as published by the Free Software Foundation; either
* version 3 of the License, or any later version.
*
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU AFFERO GENERAL PUBLIC LICENSE for more details.
*
* You should have received a copy of the GNU Affero General Public
* License along with this library.  If not, see <http://www.gnu.org/licenses/>.
*
*/

// Check if we are a user
\OCP\User::checkLoggedIn();

$defaults = new \OCP\Defaults();
$config = \OC::$server->getConfig();
$user = \OC::$server->getUserSession()->getUser();

//links to clients
$clients = array(
	'desktop' => $config->getSystemValue('customclient_desktop', $defaults->getSyncClientUrl()),
	'android' => $config->getSystemValue('customclient_android', $defaults->getAndroidClientUrl()),
	'ios'     => $config->getSystemValue('customclient_ios', $defaults->getiOSClientUrl())
);

$tmpl = new \OCP\Template('firstrunwizard', 'main', '');
$tmpl->assign('clients', $clients);

if ($user->canChangeDisplayName()) {
	$tmpl->assign('displayName', $user->getDisplayName());
	// this is the only permission a backend provides and is also used
	// for the permission of setting a email address
	$tmpl->assign('email', $config->getUserValue($user->getUID(), 'settings', 'email'));
}

if ($config->getSystemValue('enable_avatars', true) === true) {
	$tmpl->assign('enableAvatars', true);
	$tmpl->assign('avatarChangeSupported', $user->canChangeAvatar());
}

$tmpl->printPage();