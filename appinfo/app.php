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

\OCP\App::addNavigationEntry([
	// the string under which your app will be referenced in owncloud
	'id' => 'firstrunwizard',

	// sorting weight for the navigation. The higher the number, the higher
	// will it be listed in the navigation
	'order' => 10,

	// the route that will be shown on startup
	'href' => \OCP\Util::linkToRoute('firstrunwizard.page.index'),

	// the icon that will be shown in the navigation
	// this file needs to exist in img/
	'icon' => \OCP\Util::imagePath('firstrunwizard', 'app.svg'),

	// the title of your application. This will be used in the
	// navigation or on the settings page of your app
	'name' => \OC_L10N::get('firstrunwizard')->t('First run Wizard')
]);

// execute OCA\firstrunwizard\Hooks\User::deleteUser before a user is being deleted
//\OCP\Util::connectHook('OC_User', 'pre_deleteUser', 'OCA\firstrunwizard\Hooks\User', 'deleteUser');