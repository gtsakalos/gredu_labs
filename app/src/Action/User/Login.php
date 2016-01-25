<?php
/**
 * gredu_labs
 * 
 * @link https://github.com/eellak/gredu_labs for the canonical source repository
 * @copyright Copyright (c) 2008-2015 Greek Free/Open Source Software Society (https://gfoss.ellak.gr/)
 * @license GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

namespace GrEduLabs\Action\User;

use Slim\Csrf\Guard;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Adapter\ValidatableAdapterInterface;
use Zend\Authentication\AuthenticationServiceInterface;

class Login
{
    /**
     * @var Twig
     */
    protected $view;

    /**
     * @var AuthenticationServiceInterface
     */
    protected $authService;

    /**
     * @var AdapterInterface
     */
    protected $authAdapter;

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
     * @param AuthenticationServiceInterface $authService
     * @param AdapterInterface $authAdapter
     * @param Messages $flash
     */
    public function __construct(
        Twig $view,
        AuthenticationServiceInterface $authService,
        AdapterInterface $authAdapter,
        Messages $flash,
        Guard $csrf,
        $successUrl
    ) {
        $this->view        = $view;
        $this->authService = $authService;
        $this->authAdapter = $authAdapter;
        $this->flash       = $flash;
        $this->csrf        = $csrf;
        $this->successUrl  = $successUrl;

        if (method_exists($this->authService, 'setAdapter')) {
            $this->authService->setAdapter($this->authAdapter);
        }
    }

    public function __invoke(Request $req, Response $res)
    {
        if ($req->isPost()) {
            if ($this->authAdapter instanceof ValidatableAdapterInterface) {
                $this->authAdapter->setIdentity($req->getParam('identity'));
                $this->authAdapter->setCredential($req->getParam('credential'));
            }

            $result = $this->authService->authenticate($this->authAdapter);
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
