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
use Page\FirstRunWizardPage;
use TestHelpers\SetupHelper;
use Page\PersonalGeneralSettingsPageFirstRunWizard;

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
	 * @var FirstRunWizardPage
	 */
	private $firstRunWizardPage;

	/**
	 * @var PersonalGeneralSettingsPageFirstRunWizard
	 */
	private $personalGeneralSettingsPageFirstRunWizard;

	/**
	 * @var string
	 */
	private $pathOfWizardFileFromServerRoot = "/apps/firstrunwizard/templates/wizard.php";

	/**
	 * @var string
	 */
	private $contentOfWizardFile = null;

	/**
	 * WebUIFirstrunwizardContext constructor.
	 *
	 * @param FirstRunWizardPage $firstRunWizardPage
	 * @param PersonalGeneralSettingsPageFirstRunWizard $personalGeneralSettingsPageFirstRunWizard
	 */
	public function __construct(
		FirstRunWizardPage $firstRunWizardPage,
		PersonalGeneralSettingsPageFirstRunWizard $personalGeneralSettingsPageFirstRunWizard
	) {
		$this->firstRunWizardPage = $firstRunWizardPage;
		$this->personalGeneralSettingsPageFirstRunWizard = $personalGeneralSettingsPageFirstRunWizard;
	}

	/**
	 * @Then the user should see the firstrunwizard popup message
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
	public function theUserShouldSeeTheFirstrunwizardPopupMessage():void {
		$firstRunWizardScreen = $this->firstRunWizardPage->getWizardPopup();
		if ($firstRunWizardScreen === null) {
			throw new Exception("Could not find firstrunwizard popup");
		}
		if ($firstRunWizardScreen->isVisible() === false) {
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
	public function theUserShouldNotNotSeeTheFirstrunwizardPopUpMessage(): void {
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
	public function closeDialogBox(): void {
		$this->firstRunWizardPage->closePopup();
	}

	/**
	 * @When the user requests to show firstrunwizard popup in settings page
	 *
	 * @return void
	 */
	public function requestToShowFirstRunWizardPopupInSettingsPage(): void {
		$this->personalGeneralSettingsPageFirstRunWizard->showFirstRunWizardPopupInSettingsPage($this->getSession());
	}

	/**
	 * @Then the heading of the popup should be :expectedMessage
	 *
	 * @param string $expectedMessage
	 *
	 * @throws Exception
	 * @return void
	 */
	public function theHeadingOfThePopupShouldBe($expectedMessage): void {
		$headingMessage = $this->firstRunWizardPage->getHeadingMessage();

		PHPUnit\Framework\Assert::assertSame(
			$expectedMessage,
			$headingMessage,
			"Firstrunwizard was expected to show $expectedMessage but showed $headingMessage."
		);
	}

	/**
	 * @Given the administrator has changed the default popup message of firstrunwizard to :newMessage
	 *
	 * @param string $newMessage
	 *
	 * @return void
	 * @throws Exception
	 */
	public function changeTheDefaultPopupMessage(string $newMessage): void {
		SetupHelper::init(
			$this->featureContext->getAdminUsername(),
			$this->featureContext->getAdminPassword(),
			$this->featureContext->getBaseUrl(),
			$this->featureContext->getOcPath()
		);

		$this->contentOfWizardFile = SetupHelper::readFileFromServer(
			$this->pathOfWizardFileFromServerRoot
		);

		$content = "<div id='firstrunwizard'><h1>$newMessage</h1></div>";
		SetupHelper::createFileOnServer(
			$this->pathOfWizardFileFromServerRoot,
			$content
		);
	}

	/**
	 * @BeforeScenario
	 *
	 * @param BeforeScenarioScope $scope
	 *
	 * @return void
	 */
	public function setUpScenario(BeforeScenarioScope $scope): void {
		// Get the environment
		$environment = $scope->getEnvironment();
		// Get all the contexts you need in this context
		$this->featureContext = $environment->getContext('FeatureContext');
		$this->webUIGeneralContext = $environment->getContext('WebUIGeneralContext');
	}

	/**
	 * @AfterScenario
	 *
	 * @return void
	 */
	public function afterScenario(): void {
		if ($this->contentOfWizardFile !== null) {
			SetupHelper::createFileOnServer(
				$this->pathOfWizardFileFromServerRoot,
				$this->contentOfWizardFile
			);
		}
	}
}
