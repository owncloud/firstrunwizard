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

use \OCA\FirstRunWizard\Lib\Util;
use \OCP\IRequest;
use \OCP\IUserSession;
use \OCP\IConfig;
use \OCP\IL10N;
use \OCP\Defaults;
use \OCP\IURLGenerator;
use \OCP\App\IAppManager;
use \OCP\AppFramework\Http\TemplateResponse;
use \OCP\AppFramework\Http\DataResponse;
use \OCP\AppFramework\Controller;

class PageController extends Controller {

	private $userId;
	private $user;
	private $config;
	private $l10n;
	private $appManager;
	private $urlGenerator;

	public function __construct($AppName,
								IRequest $request,
								IUserSession $userSession,
								IConfig $config,
								IL10N $l10n,
								IAppManager $appManager,
								IURLGenerator $urlGenerator,
								$UserId){
		parent::__construct($AppName, $request);
		
		$this->userId = $UserId;
		$this->user = $userSession->getUser();
		$this->config = $config;
		$this->l10n = $l10n;
		$this->appManager = $appManager;
		$this->urlGenerator = $urlGenerator;
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
		$defaults = new Defaults();
		$util = new Util($this->appManager, $this->config, $defaults);
		
		if ($this->user->canChangeDisplayName()){
			$displayName = $this->user->getDisplayName();
			// this is the only permission a backend provides and is also used
			// for the permission of setting a email address
			$email = $this->config->getUserValue($this->userId, 'settings',
					'email');
		}
		
		if ($this->config->getSystemValue('enable_avatars', true) === true) {
			$enableAvatars = true;
			if ($this->user->canChangeAvatar()) {
				$avatarChangeSupported = true;
				$avatarController = $this->urlGenerator->linkToRoute('core.avatar.postAvatar');
			} else {
				$avatarChangeSupported = false;
			}
			
		}
		
		$clients = $util->getSyncClientUrls();
		$edition = $util->getEdition();
		
		$params = [	'clients' => $clients,
					'edition' => $edition,
					'displayName' => $displayName,
					'email' => $email,
					'enableAvatars' => $enableAvatars,
					'avatarChangeSupported' => $avatarChangeSupported,
					'avatarController' => $avatarController,
					];
		
		return new TemplateResponse('firstrunwizard', 'main', $params);
	}
	
	/**
	 * @NoAdminRequired
	 */
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

	/**
	 * @NoAdminRequired
	 */
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
	
	/**
	 * @NoAdminRequired
	 */
	public function close() {
		$this->config->setUserValue($this->userId, 'firstrunwizard', 'show', 0);
		$redirect = $this->urlGenerator->getAbsoluteURL('/');
		return new DataResponse(['defaultPageUrl' => $redirect]);
	}
}