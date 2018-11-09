<?php

namespace OCA\FirstRunWizard\Tests;

use OCA\FirstRunWizard\Config;
use OCP\IConfig;
use OCP\IUserSession;

/**
 * Class ConfigTest
 *
 * @package OCA\FirstRunWizard\Tests
 */
class ConfigTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @param bool $isUserAvailable
	 *
	 * @dataProvider enableDisableData
	 *
	 * @return void
	 */
	public function testEnable($isUserAvailable) {
		/**
		 * @var IConfig | \PHPUnit_Framework_MockObject_MockObject $config
		 */
		$config = $this->getMockBuilder('\OCP\IConfig')
			->disableOriginalConstructor()->getMock();
		/**
		 * @var IUserSession | \PHPUnit_Framework_MockObject_MockObject $userSession
		 */
		$userSession = $this->getMockBuilder('\OCP\IUserSession')
			->disableOriginalConstructor()->getMock();
		$user = $this->getMockBuilder('\OCP\IUser')
			->disableOriginalConstructor()->getMock();

		if ($isUserAvailable) {
			$user->expects($this->once())
				->method('getUID')
				->will($this->returnValue('user123'));

			$userSession->expects($this->once())
				->method('getUser')
				->will($this->returnValue($user));

			$config->expects($this->once())
				->method('setUserValue')
				->with('user123', 'firstrunwizard', 'show', 1);

			$c = new Config($config, $userSession);
			$c->enable();
		} else {
			$userSession->expects($this->once())
				->method('getUser')
				->will($this->returnValue(null));
			$user->expects($this->never())
				->method('getUID');
			$config->expects($this->never())
				->method('setUserValue');

			$c = new Config($config, $userSession);
			$c->enable();
		}
	}

	/**
	 * @param bool $isUserAvailable
	 *
	 * @return void
	 *
	 * @dataProvider enableDisableData
	 */
	public function testDisable($isUserAvailable) {
		/**
		 * @var IConfig | \PHPUnit_Framework_MockObject_MockObject $config
		 */
		$config = $this->getMockBuilder('\OCP\IConfig')
			->disableOriginalConstructor()->getMock();
		/**
		 * @var IUserSession | \PHPUnit_Framework_MockObject_MockObject $userSession
		 */
		$userSession = $this->getMockBuilder('\OCP\IUserSession')
			->disableOriginalConstructor()->getMock();
		$user = $this->getMockBuilder('\OCP\IUser')
			->disableOriginalConstructor()->getMock();

		if ($isUserAvailable) {
			$user->expects($this->once())
				->method('getUID')
				->will($this->returnValue('user123'));

			$userSession->expects($this->once())
				->method('getUser')
				->will($this->returnValue($user));

			$config->expects($this->once())
				->method('setUserValue')
				->with('user123', 'firstrunwizard', 'show', 0);

			$c = new Config($config, $userSession);
			$c->disable();
		} else {
			$userSession->expects($this->once())
				->method('getUser')
				->will($this->returnValue(null));
			$user->expects($this->never())
				->method('getUID');
			$config->expects($this->never())
				->method('setUserValue');

			$c = new Config($config, $userSession);
			$c->disable();
		}
	}

	/**
	 * @return array
	 */
	public function enableDisableData() {
		return [
			[true],
			[false],
		];
	}

	/**
	 * @param bool $isEnabled
	 *
	 * @return void
	 *
	 * @dataProvider isEnabledData
	 */
	public function testIsEnabled($isEnabled) {
		/**
		 * @var IConfig | \PHPUnit_Framework_MockObject_MockObject $config
		 */
		$config = $this->getMockBuilder('\OCP\IConfig')
			->disableOriginalConstructor()->getMock();
		/**
		 * @var IUserSession | \PHPUnit_Framework_MockObject_MockObject $userSession
		 */
		$userSession = $this->getMockBuilder('\OCP\IUserSession')
			->disableOriginalConstructor()->getMock();
		$user = $this->getMockBuilder('\OCP\IUser')
			->disableOriginalConstructor()->getMock();

		if ($isEnabled === true) {
			$user->expects($this->once())
				->method('getUID')
				->will($this->returnValue('user123'));

			$userSession->expects($this->once())
				->method('getUser')
				->will($this->returnValue($user));

			$config->expects($this->once())
				->method('getUserValue')
				->with('user123', 'firstrunwizard', 'show', 1)
				->will($this->returnValue(1));

			$c = new Config($config, $userSession);
			$this->assertEquals(true, $c->isEnabled());
		} elseif ($isEnabled === false) {
			$user->expects($this->once())
				->method('getUID')
				->will($this->returnValue('user123'));

			$userSession->expects($this->once())
				->method('getUser')
				->will($this->returnValue($user));

			$config->expects($this->once())
				->method('getUserValue')
				->with('user123', 'firstrunwizard', 'show', 1)
				->will($this->returnValue(0));

			$c = new Config($config, $userSession);
			$this->assertEquals(false, $c->isEnabled());
		} elseif ($isEnabled === null) {
			$userSession->expects($this->once())
				->method('getUser')
				->will($this->returnValue(null));
			$user->expects($this->never())
				->method('getUID');
			$config->expects($this->never())
				->method('getUserValue');

			$c = new Config($config, $userSession);
			$this->assertEquals(false, $c->isEnabled());
		}
	}

	/**
	 * @return array
	 */
	public function isEnabledData() {
		return [
			[true],
			[false],
			[null],
		];
	}

	/**
	 * Test that the config is reset for all users
	 *
	 * @return void
	 *
	 * @throws \OCP\PreConditionNotMetException
	 */
	public function testResetAllUsers() {
		$users = [];
		$users[] = $this->getMockBuilder('\OCP\IUser')
			->disableOriginalConstructor()->getMock();
		$users[] = $this->getMockBuilder('\OCP\IUser')
			->disableOriginalConstructor()->getMock();
		/**
		 * @var IConfig | \PHPUnit_Framework_MockObject_MockObject $config
		 */
		$config = $this->getMockBuilder('\OCP\IConfig')
			->disableOriginalConstructor()->getMock();
		$config->method('getUsersForUserValue')
			->with('firstrunwizard', 'show', 0)
			->willReturn($users);
		$config->expects($this->exactly(\count($users)))
			->method('setUserValue');
		/**
		 * @var IUserSession | \PHPUnit_Framework_MockObject_MockObject $userSession
		 */
		$userSession = $this->getMockBuilder('\OCP\IUserSession')
			->disableOriginalConstructor()->getMock();
		$c = new Config($config, $userSession);
		// Create a fake callback to check it gets called
		$mock = $this->getMockBuilder('stdClass');
		$mock->setMethods(['callback']);
		$mock = $mock->getMock();
		$mock->expects($this->exactly(\count($users)))
			->method('callback')
			->will($this->returnValue(true));
		$c->resetAllUsers([$mock, 'callback']);
	}
}
