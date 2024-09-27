<?php

require '../vendor/autoload.php';
const TEMPLATE_PATH = '../templates';

use app\Controller\AccountController;
use app\Controller\LoginController;
use app\Controller\MainPageController;
use app\Controller\RegistrationController;
use app\Core\DI\Container;
use app\Core\HTTP\Request\Request;
use app\Core\HTTP\Router;
use app\mysqlClient;
use app\Kernel;
use app\Repository\RegistrationRepository;
use app\Service\RegistrationService;
use app\Service\RegistrationValidator;
use app\Util\TemplateRenderer;

$container = new Container();
$container->setConfig(mysqlClient::class,'config',[
    'driver'=>'mysql',
    'host'=>'db',
    'database'=>'rettiwt',
    'user' => 'root',
    'pass' => 'root'
]);
$container->register(Router::class, mysqlClient::class, TemplateRenderer::class,
    MainPageController::class, AccountController::class, LoginController::class,
    RegistrationController::class, RegistrationRepository::class, RegistrationService::class,
    RegistrationValidator::class)->build();


$request = new Request($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], $_POST, $_GET, $_FILES);

$container->get(Router::class)->registerControllers(
        [
            MainPageController::class,
            LoginController::class,
            RegistrationController::class,
            AccountController::class

        ]
);

$kernel = new Kernel($container);
$response = $kernel->handle($request);
echo $response->getContent();
