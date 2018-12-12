<?php

namespace OCA\FirstRunWizard\Tests;

use OCA\FirstRunWizard\Util;
use OCP\App\IAppManager;
use OCP\Defaults;
use OCP\IConfig;

class UtilTest extends \PHPUnit_Framework_TestCase {

	/**
	 * same code as in core: tests/lib/UtilTest.php
	 */
	public function testGetEditionString() {
		$edition = \OC_Util::getEditionString();
		$this->assertTrue(\is_string($edition));
	}

	/**
	 * @dataProvider getSyncClientUrlsData
	 */
	public function testGetSyncClientUrls($configValues, $defaultValues) {
		/** @var IAppManager $appManager */
		$appManager = $this->getMockBuilder('\OCP\App\IAppManager')
			->disableOriginalConstructor()->getMock();
		/** @var IConfig | \PHPUnit_Framework_MockObject_MockObject $config */
		$config = $this->getMockBuilder('\OCP\IConfig')
			->disableOriginalConstructor()->getMock();
		/** @var Defaults | \PHPUnit_Framework_MockObject_MockObject $defaults */
		$defaults = $this->getMockBuilder('\OCP\Defaults')
			->disableOriginalConstructor()->getMock();

		$defaults->expects($this->once())
			->method('getSyncClientUrl')
			->will($this->returnValue($defaultValues[0]));
		$defaults->expects($this->once())
			->method('getAndroidClientUrl')
			->will($this->returnValue($defaultValues[1]));
		$defaults->expects($this->once())
			->method('getiOSClientUrl')
			->will($this->returnValue($defaultValues[2]));

		$config->expects($this->at(0))
			->method('getSystemValue')
			->with('customclient_desktop', $defaultValues[0])
			->will($this->returnValue($configValues[0]));
		$config->expects($this->at(1))
			->method('getSystemValue')
			->with('customclient_android', $defaultValues[1])
			->will($this->returnValue($configValues[1]));
		$config->expects($this->at(2))
			->method('getSystemValue')
			->with('customclient_ios', $defaultValues[2])
			->will($this->returnValue($configValues[2]));

		$util = new Util($appManager, $config, $defaults);
		$this->assertEquals([
			'desktop' => $configValues[0],
			'android' => $configValues[1],
			'ios' => $configValues[2],
		], $util->getSyncClientUrls());
	}

	public function getSyncClientUrlsData() {
		return [
			[
				['a', 'b', 'c'],
				['d', 'e', 'f'],
			],
		];
	}
}
