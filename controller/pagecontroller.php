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

namespace OCA\FirstRunWizard\Controller;

use \OCP\IRequest;
use \OCP\IUserSession;
use \OCP\IConfig;
use \OCP\IL10N;
use \OCP\AppFramework\Http\TemplateResponse;
use \OCP\AppFramework\Http\DataResponse;
use \OCP\AppFramework\Controller;

class PageController extends Controller {

	private $userId;
	private $user;
	private $config;
	private $l10n;

	public function __construct($AppName,
								IRequest $request,
								IUserSession $userSession,
								IConfig $config,
								IL10N $l10n,
								$UserId){
		parent::__construct($AppName, $request);
		
		$this->userId = $UserId;
		$this->user = $userSession->getUser();
		$this->config = $config;
		$this->l10n = $l10n;
	}

	/**
	 * CAUTION: the @Stuff turns off security checks; for this page no admin is
	 *          required and no CSRF check. If you don't know what CSRF is, read
	 *          it up in the docs or you might create a security hole. This is
	 *          basically the only required method to add this exemption, don't
	 *          add it to any other method if you don't exactly know what it does
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index() {
		$defaults = new \OCP\Defaults();
		$clients = array(
			'desktop' => $this->config->getSystemValue('customclient_desktop',
										$defaults->getSyncClientUrl()),
			'android' => $this->config->getSystemValue('customclient_android', 
										$defaults->getAndroidClientUrl()),
			'ios'     => $this->config->getSystemValue('customclient_ios', 
										$defaults->getiOSClientUrl())
		);
		
		if ($this->user->canChangeDisplayName()){
			$displayName = $this->user->getDisplayName();
			// this is the only permission a backend provides and is also used
			// for the permission of setting a email address
			$email = $this->config->getUserValue($this->userId, 'settings',
					'email');
		}
		
		if ($this->config->getSystemValue('enable_avatars', true) === true) {
			$enableAvatars = true;
			$avatarChangeSupported = $this->user->canChangeAvatar();
		}
		
		$params = [	'clients' => $clients,
					'displayName' => $displayName,
					'email' => $email,
					'enableAvatars' => $enableAvatars,
					'avatarChangeSupported' => $avatarChangeSupported,
					];
		
		return new TemplateResponse('firstrunwizard', 'main', $params);
	}

	public function setDisplayName($newValue) {
		if ($this->user->setDisplayName($newValue)) {
			return new DataResponse(
				["data" => ["message" => $this->l10n->t('Your full name has been changed')],
				'status' => 'success']);
		}else{
			return new DataResponse(
				["data" => ["message" => $this->l10n->t('Unable to change full name')],
				'status' => 'error']);
		}
	}
	
	public function setEmail($newValue) {
		if ($newValue !== '' && !filter_var($newValue, FILTER_VALIDATE_EMAIL)) {
			return new DataResponse(
				["data" => ["message" => $this->l10n->t('Invalid mail address')],
				'status' => 'error']);
		}else{
			$this->config->setUserValue($this->userId, 'settings', 'email', $newValue);
			return new DataResponse(
				["data" => ["message" => $this->l10n->t('Email saved')],
				'status' => 'success']);
		}
	}
	
	public function close() {
		$this->config->setUserValue($this->userId, 'firstrunwizard', 'show', 0);
		$redirect = \OC_Util::getDefaultPageUrl();
		return new DataResponse(['defaultPageUrl' => $redirect]);
	}
}