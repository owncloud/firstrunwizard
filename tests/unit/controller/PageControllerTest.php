<?php
/**
 * ownCloud - myapp
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Your Name <mail@example.com>
 * @copyright Your Name 2015
 */

namespace OCA\FirstRunWizard\Controller;

use PHPUnit_Framework_TestCase;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Http\DataResponse;

class PageControllerTest extends PHPUnit_Framework_TestCase {

	private $controller;
	private $userId = 'john';
	private $userSession;
	private $mockUser;
	private $config;

		
	protected function mockUserSession() {
		$this->mockUser = $this->getMockBuilder('\OCP\IUser')
			->disableOriginalConstructor()
			->getMock();
		$this->userSession->expects($this->any())
			->method('getUser')
			->will($this->returnValue($this->mockUser));
	}
	
	public function setUp() {
		$this->userSession = $this->getMockBuilder('OCP\IUserSession')
			->disableOriginalConstructor()
			->getMock();
		$this->config = $this->getMockBuilder('OCP\IConfig')
				->disableOriginalConstructor()
				->getMock();
		$request = $this->getMockBuilder('OCP\IRequest')
				->disableOriginalConstructor()
				->getMock();
		$l10n = $this->getMockBuilder('OCP\IL10N')->getMock();
		
		$this->mockUserSession();
			
		$this->controller = new PageController(
			'firstrunwizard', $request, $this->userSession, $this->config, $l10n, $this->userId
		);
	}

	public function testIndexTemplate() {
		$result = $this->controller->index();
		$this->assertEquals('main', $result->getTemplateName());
		$this->assertTrue($result instanceof TemplateResponse);
	}
	
	public function testIndex() {
		$this->mockUser->expects($this->once())
			->method('canChangeDisplayName')
			->will($this->returnValue(true));
				
		$this->mockUser->expects($this->once())
			->method('getDisplayName')
			->will($this->returnValue('John Doe'));
		
		$this->mockUser->expects($this->once())
			->method('canChangeAvatar')
			->will($this->returnValue(true));
		
		$this->config->expects($this->once())
            ->method('getUserValue')
            ->will($this->returnValue('John.Doe@exemple.com'));
		
		$this->config->expects($this->any())
			->method('getSystemValue')
			->will($this->returnValue(true));
 		
		$result = $this->controller->index();

		$this->assertEquals(['displayName' => 'John Doe',
					'email' => 'John.Doe@exemple.com',
					'enableAvatars' => true,
					'avatarChangeSupported' => true,
					'clients' => ['desktop' => true,
								'android' => true,
								'ios' => true]
					], $result->getParams());
	}
	
	public function testIndexCantChangeDisplayName() {
		$this->mockUser->expects($this->once())
			->method('canChangeDisplayName')
			->will($this->returnValue(false));
				
		$this->mockUser->expects($this->never())
			->method('getDisplayName');
		
		$this->mockUser->expects($this->once())
			->method('canChangeAvatar')
			->will($this->returnValue(true));
		
		$this->config->expects($this->never())
            ->method('getUserValue');
		
		$this->config->expects($this->any())
			->method('getSystemValue')
			->will($this->returnValue(true));
 		
		$result = $this->controller->index();

		$this->assertEquals(['displayName' => Null,
					'email' => Null,
					'enableAvatars' => true,
					'avatarChangeSupported' => true,
					'clients' => ['desktop' => true,
								'android' => true,
								'ios' => true]
					], $result->getParams());
	}
	
	public function testIndexAvatarDisable() {
		$this->mockUser->expects($this->once())
			->method('canChangeDisplayName')
			->will($this->returnValue(true));
				
		$this->mockUser->expects($this->once())
			->method('getDisplayName')
			->will($this->returnValue('John Doe'));
		
		$this->mockUser->expects($this->never())
			->method('canChangeAvatar');
		
		$this->config->expects($this->once())
            ->method('getUserValue')
            ->will($this->returnValue('John.Doe@exemple.com'));
		
		$this->config->expects($this->any())
			->method('getSystemValue')
			->will($this->returnValue(false));
 		
		$result = $this->controller->index();

		$this->assertEquals(['displayName' => 'John Doe',
					'email' => 'John.Doe@exemple.com',
					'enableAvatars' => Null,
					'avatarChangeSupported' => Null,
					'clients' => ['desktop' => false,
								'android' => false,
								'ios' => false]
					], $result->getParams());
	}

	public function testSetDisplayNameSuccess(){
		$this->mockUser->expects($this->once())
			->method('setDisplayName')
			->will($this->returnValue(true));
		
		$result = $this->controller->setDisplayName('John Doe');
		$data = $result->getData();
		$this->assertEquals('success', $data['status']);
		$this->assertTrue($result instanceof DataResponse);
	}
	
	public function testSetDisplayNameError(){
		$this->mockUser->expects($this->once())
			->method('setDisplayName')
			->will($this->returnValue(false));

		$result = $this->controller->setDisplayName('');
		$data = $result->getData();
		$this->assertEquals('error', $data['status']);
		$this->assertTrue($result instanceof DataResponse);
	}
	
	public function testSetEmailEmpty(){
		$result = $this->controller->setEmail('');
		$data = $result->getData();
		$this->assertEquals('success', $data['status']);
		$this->assertTrue($result instanceof DataResponse);
	}
	
	public function testSetEmailInvalidFormat(){
		$result = $this->controller->setEmail('John');
		$data = $result->getData();
		$this->assertEquals('error', $data['status']);
		$this->assertTrue($result instanceof DataResponse);
	}
	
	public function testSetEmail(){
		$result = $this->controller->setEmail('John.Doe@exemple.com');
		$data = $result->getData();
		$this->assertEquals('success', $data['status']);
		$this->assertTrue($result instanceof DataResponse);
	}

	public function testClose(){
		$result = $this->controller->close();
		$data = $result->getData();
		$isValidUrl = true;
		if (filter_var($data['defaultPageUrl'], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) === false){
			$isValidUrl = false;
		}
		$this->assertTrue($isValidUrl);
		$this->assertTrue($result instanceof DataResponse);
	}
}