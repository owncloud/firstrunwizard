<?php
/**
 * @author Bart Visscher <bartv@thisnet.nl>
 * @author Christopher Schäpers <kondou@ts.unde.re>
 * @author David Reagan <reagand@lanecc.edu>
 * @author Jan-Christoph Borchardt <hey@jancborchardt.net>
 * @author Lukas Reschke <lukas@owncloud.com>
 * @author Robin Appelman <icewind@owncloud.com>
 *
 * @copyright Copyright (c) 2015, ownCloud, Inc.
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */

OCP\JSON::callCheck();
OCP\JSON::checkLoggedIn();
OCP\JSON::checkAppEnabled('firstrunwizard');

$l = \OC::$server->getL10N('settings');
$mailer = \OC::$server->getMailer();
$uid = \OC::$server->getUserSession()->getUser()->getUID();
$email = (string)$_POST["wizardemail"];

if($email !== '' && !$mailer->validateMailAddress($email)) {
	OCP\JSON::error(array("data" => array( "message" => $l->t('Invalid mail address'))));
}else{
	\OC::$server->getConfig()->setUserValue($uid, 'settings', 'email', $email);
	OCP\JSON::success(array("data" => array( "message" => $l->t('Your email has been changed.'))));
}


