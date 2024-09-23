<?php

require '../vendor/autoload.php';
const TEMPLATE_PATH = '../templates';

use app\Controller\AccountController;
use app\Controller\LoginController;
use app\Controller\MainPageController;
use app\Controller\RegisterController;
use app\Core\DI\Container;
use app\Core\HTTP\Request\Request;
use app\Core\HTTP\Router;
use app\DB;
use app\Kernel;
use app\Util\TemplateRenderer;

$container = new Container();
$container->setConfig(DB::class,'config',[
    'driver'=>'mysql',
    'host'=>'db',
    'database'=>'rettiwt',
    'user' => 'root',
    'pass' => 'root'
]);
$container->register(Router::class, DB::class, TemplateRenderer::class,
    MainPageController::class, AccountController::class, LoginController::class,
    RegisterController::class)->build();


$request = new Request($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], $_POST, $_GET, $_FILES);

$container->get(Router::class)->registerControllers(
        [
            MainPageController::class,
            LoginController::class,
            RegisterController::class,
            AccountController::class

        ]
);

var_dump($container->get(DB::class));
$kernel = new Kernel($container);
$response = $kernel->handle($request);
echo $response->getContent();
