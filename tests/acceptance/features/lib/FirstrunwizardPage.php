<?php
/**
 * ownCloud
 *
 * @author Bhawana Prasain  <bhawana.prs@gmail.com>
 * @copyright Copyright (c)  Bhawana Prasain 2019 bhawana.prs@gmail.com
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

use \Behat\Mink\Element\NodeElement;

/**
 * Page object for Firstrunwizard
 *
 */

class FirstrunwizardPage extends OwncloudPage {
	protected $closeWizardXpath = "//*[@id='closeWizard']";
	protected $firstrunwizardPopupXpath = "//*[@id='firstrunwizard']";

	/**
	 * Closes Popup message from Firstrunwizard
	 *
	 * @return void
	 */
	public function closePopup() {
		$closeButton = $this->find("xpath", $this->closeWizardXpath);
		$this->assertElementNotNull($closeButton, "no close button");
		$closeButton->click();
		$this->waitTillElementIsNull($this->closeWizardXpath);
	}

	/**
	 * @return NodeElement|null
	 */
	public function getWizardPopup() {
		return $this->find("xpath", $this->firstrunwizardPopupXpath);
	}
}
