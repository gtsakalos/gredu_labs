<?php
/**
 * gredu_labs
 * 
 * @link https://github.com/eellak/gredu_labs for the canonical source repository
 * @copyright Copyright (c) 2008-2015 Greek Free/Open Source Software Society (https://gfoss.ellak.gr/)
 * @license GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

namespace GrEduLabs\Authentication\Action\User;

use Slim\Csrf\Guard;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Adapter\ValidatableAdapterInterface;

class Login
{
    /**
     * @var Twig
     */
    protected $view;

    /**
     * @var AuthenticationService
     */
    protected $authService;

    /**
     * @var Messages
     */
    protected $flash;

    /**
     * @Var Guard
     */
    protected $csrf;

    /**
     * @var string
     */
    protected $successUrl;

    /**
     * Constructor
     * @param Twig $view
     * @param AuthenticationService $authService
     * @param AdapterInterface $authAdapter
     * @param Messages $flash
     */
    public function __construct(
        Twig $view,
        AuthenticationService $authService,
        Messages $flash,
        Guard $csrf,
        $successUrl
    ) {
        $this->view        = $view;
        $this->authService = $authService;
        $this->flash       = $flash;
        $this->csrf        = $csrf;
        $this->successUrl  = $successUrl;
    }

    public function __invoke(Request $req, Response $res)
    {        
        
        if ($req->isPost()) {
            $adapter = $this->authService->getAdapter();
            if ($adapter instanceof ValidatableAdapterInterface) {
                $adapter->setIdentity($req->getParam('identity'));
                $adapter->setCredential($req->getParam('credential'));
            }
            
            $result = $this->authService->authenticate($adapter);
            if (!$result->isValid()) {
                $this->flash->addMessage('danger', reset($result->getMessages()));

                return $res->withRedirect($req->getUri());
            }

            return $res->withRedirect($this->successUrl);
        } 

        return $this->view->render($res, 'user/login.twig', $this->getCsrfData($req));
    }

    private function getCsrfData(Request $req)
    {
        $nameKey  = $this->csrf->getTokenNameKey();
        $valueKey = $this->csrf->getTokenValueKey();
        $name     = $req->getAttribute($nameKey);
        $value    = $req->getAttribute($valueKey);

        return [
            'csrf_name_key'  => $nameKey,
            'csrf_value_key' => $valueKey,
            'csrf_name'      => $name,
            'csrf_value'     => $value,
        ];
    }
}
