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
use Behat\Mink\Element\NodeElement;

/**
 * Page object for Firstrunwizard
 *
 */

class FirstRunWizardPage extends OwncloudPage {
	protected $closeWizardXpath = "//*[@id='closeWizard']";
	protected $headingMessageXpath = "//*[@id='firstrunwizard']/h1";
	protected $firstRunWizardXpath = "//*[@id='firstrunwizard']";

	/**
	 * Closes Popup message from Firstrunwizard
	 *
	 * @return void
	 */
	public function closePopup(): void {
		$closeButton = $this->find("xpath", $this->closeWizardXpath);
		$this->assertElementNotNull(
			$closeButton,
			__METHOD__ .
			"Could not find close button xpath: '$this->closeWizardXpath'"
		);
		$closeButton->click();
		$this->waitTillElementIsNull($this->closeWizardXpath);
	}

	/**
	 * @param Session $session
	 * @param int $timeout_msec
	 *
	 * @return void
	 */
	public function waitTillPageIsLoaded(
		Session $session,
		int $timeout_msec = STANDARD_UI_WAIT_TIMEOUT_MILLISEC
	): void {
		$this->waitTillXpathIsVisible($this->closeWizardXpath, $timeout_msec);
	}

	/**
	 * @return NodeElement|null
	 */
	public function getWizardPopup(): ?NodeElement {
		return $this->find("xpath", $this->firstRunWizardXpath);
	}

	/**
	 * Returns the message from firstrunwizard at heading
	 *
	 * @return string
	 */
	public function getHeadingMessage(): string {
		$assertHeadingMessage = $this->find('xpath', $this->headingMessageXpath);
		$this->assertElementNotNull(
			$assertHeadingMessage,
			__METHOD__ .
			"Could not find heading element xpath: '$this->headingMessageXpath'"
		);
		$headingMessage = $assertHeadingMessage->getText();
		return $headingMessage;
	}
}
