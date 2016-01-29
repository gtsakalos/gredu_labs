<?php
/**
 * gredu_labs
 * 
 * @link https://github.com/eellak/gredu_labs for the canonical source repository
 * @copyright Copyright (c) 2008-2015 Greek Free/Open Source Software Society (https://gfoss.ellak.gr/)
 * @license GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0-standalone.html
 */


$container = $app->getContainer();

// Twig

$container['view'] = function ($c) {
    $settings = $c->get('settings');
    $view     = new \Slim\Views\Twig(
        $settings['view']['template_path'],
        $settings['view']['twig']
    );
    $view->addExtension(new Slim\Views\TwigExtension(
        $c->get('router'),
        $c->get('request')->getUri()
    ));
    $view->addExtension(new Twig_Extension_Debug());
    $view->addExtension(new Knlv\Slim\Views\TwigMessages(
        $c->get('flash')
    ));
    if (isset($settings['navigation']) && is_array($settings['navigation'])) {
        $view->addExtension(new GrEduLabs\Twig\Extension\Navigation(
            $settings['navigation'],
            $c->get('router'),
            $c->get('request')
        ));
    }

    return $view;
};

// Flash messages

$container['flash'] = function ($c) {
    return new \Slim\Flash\Messages;
};

// Monolog

$container['logger'] = function ($c) {
    $settings = $c->get('settings');
    $logger   = new \Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler(
        $settings['logger']['path'],
        \Monolog\Logger::DEBUG
    ));

    return $logger;
};

// Event manager

$container['events'] = function ($c) {
    return new \Zend\EventManager\EventManager(
        new \Zend\EventManager\SharedEventManager(),
        ['events']
    );
};

// Csrf guard

$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
};

// Database

$container['db'] = function ($c) {
    $settings = $c->get('settings');
    try {
        $pdo = new \PDO(
            $settings['db']['dsn'],
            $settings['db']['user'],
            $settings['db']['pass'],
            $settings['db']['options']
        );

        return $pdo;
    } catch (\PDOException $e) {
        $c->get('logger')->error($e->getMessage());

        return;
    }
};

// Authentication service

$container['authentication_db_adapter'] = function ($c) {
    return new \GrEduLabs\Authentication\Adapter\Pdo($c->get('db'));
};

$container['authentication_cas_adapter'] = function ($c) {
    $settings = $c->get('settings');

    return new GrEduLabs\Authentication\Adapter\Cas($settings['phpcas']);
};

$container['authentication_storage'] = function ($c) {
    return new \GrEduLabs\Authentication\Storage\PhpSession();
};

$container['authentication_service'] = function ($c) {
    return new \Zend\Authentication\AuthenticationService(
        $c->get('authentication_storage')
    );
};

$container['authentication_cas_logout_middleware'] = function ($c) {
    return new GrEduLabs\Middleware\CasLogout(
        $c->get('authentication_cas_adapter')
    );
};

$container['set_identity_in_request'] = function ($c) {
    return new GrEduLabs\Middleware\SetIdentityInRequest(
        $c->get('authentication_service')
    );
};

// Inventory service

$container['inventory_service'] = function ($c) {
    $settings = $c->get('settings');

    return new GrEduLabs\Inventory\GuzzleHttpService(
        new GuzzleHttp\Client($settings['inventory'])
    );
};

// Actions

$container['GrEduLabs\\Action\\Index'] = function ($c) {
    return new GrEduLabs\Action\Index($c->get('view'));
};

$container['GrEduLabs\\Action\\Form\\Form'] = function ($c) {
    return new GrEduLabs\Action\Form\Form(
        $c->get('view'), 
        $c->get('school_service'),
        $c->get('teacher_service'),
        $c->get('lab_service'),
        $c->get('equipment_service')
    );
};

$container['GrEduLabs\\Action\\User\\Login'] = function ($c) {
    $service = $service = $c->get('authentication_service');
    $adapter = $c->get('authentication_db_adapter');
    $service->setAdapter($adapter);

    return new GrEduLabs\Action\User\Login(
        $c->get('view'),
        $service,
        $adapter,
        $c->get('flash'),
        $c->get('csrf'),
        $c->get('router')->pathFor('index')
    );
};

$container['GrEduLabs\\Action\\User\\LoginSso'] = function ($c) {
    $service = $c->get('authentication_service');
    $adapter = $c->get('authentication_cas_adapter');
    $service->setAdapter($adapter);

    return new GrEduLabs\Action\User\LoginSso(
        $service,
        $c->get('flash'),
        $c->get('router')->pathFor('index'),
        $c->get('router')->pathFor('user.login')
    );
};

$container['GrEduLabs\\Action\\User\\Logout'] = function ($c) {
    return new GrEduLabs\Action\User\Logout(
        $c->get('authentication_service'),
        $c->get('router')->pathFor('index')
    );
};

// DB Services
$container['school_service'] = function ($c){
    return new GrEduLabs\DBService\SchoolService();
};

$container['teacher_service'] = function ($c){
    return new GrEduLabs\DBService\TeacherService(
        $c->get('school_service')   
    );
};

$container['lab_service'] = function ($c){
    return new GrEduLabs\DBService\LabService(
        $c->get('school_service'),  
        $c->get('teacher_service')
    );
};

$container['equipment_service'] = function ($c){
    return new GrEduLabs\DBService\EquipmentService(
        $c->get('school_service')
    );
};
