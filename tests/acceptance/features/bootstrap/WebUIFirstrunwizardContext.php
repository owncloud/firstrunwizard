<?php
/**
 * ownCloud
 *
 * @author Bhawana Prasain <bhawana.prs@gmail.com>
 * @copyright Copyright (c) 2019 Bhawana Prasain bhawana.prs@gmail.com
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

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\MinkExtension\Context\RawMinkContext;
use Page\FirstrunwizardPage;

require_once 'bootstrap.php';

/**
 * Context for First run wizard specific webUI steps
 */
class WebUIFirstrunwizardContext extends RawMinkContext implements Context {

	/**
	 * @var FeatureContext
	 */
	private $featureContext;
	
	/**
	 * @var WebUIGeneralContext
	 */
	private $webUIGeneralContext;

	/**
	 * @var FirstrunwizardPage
	 */
	private $firstrunwizardPage;

	/**
	 * WebUIFirstrunwizardContext constructor.
	 *
	 * @param FirstrunwizardPage $firstrunwizardPage
	 */
	public function __construct(FirstrunwizardPage $firstRunWizardPage) {
		$this->firstRunWizardPage = $firstRunWizardPage;
	}

	/**
	 * @Then the user should see the firstrunwizard popup message
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
	public function theUserShouldSeeTheFirstrunwizardPopupMessage() {
		$firstrunwizardScreen = $this->firstRunWizardPage->getWizardPopup();
		if ($firstrunwizardScreen === null) {
			throw new Exception("Could not find firstrunwizard popup");
		}
		if ($firstrunwizardScreen->isVisible() === false) {
			throw new Exception("Firstrunwizard popup is not visible");
		}
	}

	/**
	 * @Then the user should not see the firstrunwizard popup message
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
	public function theUserShouldNotNotSeeTheFirstrunwizardPopUpMessage() {
		$firstrunwizardScreen = $this->firstRunWizardPage->getWizardPopup();

		if ($firstrunwizardScreen !== null) {
			if ($firstrunwizardScreen->isVisible() === true) {
				throw new Exception("The firstrunwizard popup is not expected to appear but is present");
			}
		}
	}

	/**
	 * @When the user closes the firstrunwizard popup message
	 * @Given the user has closed the firstrunwizard popup message
	 *
	 * @return void
	 */
	public function closeDialogBox() {
		$this->firstRunWizardPage->closePopup();
	}

	/**
	 * @BeforeScenario
	 *
	 * @param BeforeScenarioScope $scope
	 *
	 * @return void
	 */
	public function setUpScenario(BeforeScenarioScope $scope) {
		// Get the environment
		$environment = $scope->getEnvironment();
		// Get all the contexts you need in this context
		$this->featureContext = $environment->getContext('FeatureContext');
		$this->webUIGeneralContext = $environment->getContext('WebUIGeneralContext');
	}
}
