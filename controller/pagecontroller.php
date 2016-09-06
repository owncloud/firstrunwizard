<?php

namespace OCA\FirstRunWizard\Controller;

use \OCA\FirstRunWizard\Util;
use \OCP\IRequest;
use \OCP\IConfig;
use \OCP\Defaults;
use \OCP\App\IAppManager;
use \OCP\Template;
use \OCP\AppFramework\Controller;

class PageController extends Controller {

	private $userId;
	private $config;
	private $appManager;

	public function __construct($AppName,
								IRequest $request,
								IConfig $config,
								IAppManager $appManager,
								$UserId){
		parent::__construct($AppName, $request);
		
		$this->userId = $UserId;
		$this->config = $config;
		$this->appManager = $appManager;
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

		$tmpl = new Template('firstrunwizard', 'wizard', '');
		$tmpl->assign('clients', $util->getSyncClientUrls());
		$tmpl->assign('edition', $util->getEdition());
		return $tmpl->fetchPage();
	}
}