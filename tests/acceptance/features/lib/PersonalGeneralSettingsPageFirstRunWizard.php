<?php declare(strict_types=1);
/**
 * ownCloud
 *
 * @author Bhawana Prasain  <bhawana.prs@gmail.com>
 * @copyright Copyright (c) Bhawana Prasain 2019 bhawana.prs@gmail.com
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

namespace Page;

use Behat\Mink\Session;

/**
 * Page object for General section of Settings page
 *
 */

class PersonalGeneralSettingsPageFirstRunWizard extends PersonalGeneralSettingsPage {
	protected $showFirstRunWizardScreenXpath = "//*[@id=\"showWizard\"]";

	/**
	 * Shows popup message from firstrunwizard in Settings page
	 *
	 * @param Session $session
	 *
	 * @return void
	 */
	public function showFirstRunWizardPopupInSettingsPage(Session $session): void {
		$firstRunWizardPopUp = $this->find("xpath", $this->showFirstRunWizardScreenXpath);
		$this->assertElementNotNull($firstRunWizardPopUp, "'Show First Run Wizard' button could not be found.");
		$firstRunWizardPopUp->click();
		/**
		 * @var FirstRunWizardPage $firstRunWizardPage
		 */
		$firstRunWizardPage = $this->getPage("FirstrunwizardPage");
		$firstRunWizardPage->waitTillPageIsLoaded($session);
	}
}
