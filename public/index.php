<?php

require '../vendor/autoload.php';
const TEMPLATE_PATH = '../templates';
const STORAGE_IMAGES_PATH = '../public/storage/images';


use app\Controller\AccountController;
use app\Controller\AuthController;
use app\Controller\MainPageController;
use app\Controller\PostPageController;
use app\Core\DI\Container;
use app\Core\HTTP\Request\Request;
use app\Core\HTTP\Router;
use app\MysqlClient;
use app\Kernel;
use app\Repository\AccountRepository;
use app\Repository\AuthRepository;
use app\Repository\ImageRepository;
use app\Repository\PostRepository;
use app\Service\AccountService;
use app\Service\AuthService;
use app\Service\ImageService;
use app\Service\ImageValidator;
use app\Service\PostService;
use app\Service\RegistrationValidator;
use app\Util\TemplateRenderer;

$container = new Container();
$container->setConfig(MysqlClient::class,'config',[
    'driver'=>'mysql',
    'host'=>'db',
    'database'=>'rettiwt',
    'user' => 'root',
    'pass' => 'root'
]);
$container->register(
    Router::class,
    MysqlClient::class,
    TemplateRenderer::class,
    MainPageController::class,
    AccountController::class,
    PostPageController::class,
    AccountService::class,
    AccountRepository::class,
    AuthController::class,
    AuthService::class,
    AuthRepository::class,
    RegistrationValidator::class,
    ImageRepository::class,
    ImageService::class,
    PostService::class,
    PostRepository::class,
    ImageValidator::class
)->build();


$request = new Request($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], $_POST, $_GET, $_FILES);

$container->get(Router::class)->registerControllers(
        [
            MainPageController::class,
            AuthController::class,
            AccountController::class,
            PostPageController::class
        ]
);

$kernel = new Kernel($container);
$response = $kernel->handle($request);
echo $response->getContent();
