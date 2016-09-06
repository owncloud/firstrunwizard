<?php
/**
 * ownCloud - firstrunwizard App
 *
 * @author Frank Karlitschek
 * @copyright 2012 Frank Karlitschek karlitschek@kde.org
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
namespace OCA\FirstRunWizard\AppInfo;

style('firstrunwizard', 'colorbox');
script('firstrunwizard', 'jquery.colorbox');
script('firstrunwizard', 'firstrunwizard');
style('firstrunwizard', 'firstrunwizard');

if (\OCP\User::isLoggedIn()) {
	$config = \OC::$server->getConfig();
	$user = \OC::$server->getUserSession()->getUser();
	
	if ($config->getUserValue($user->getUID() , 'firstrunwizard' , 'show' , '1' ) === '1'){
		script('firstrunwizard', 'activate');
		$config->setUserValue($user->getUID() , 'firstrunwizard' , 'show' , '0' );
	}
}
