<?php

require '../vendor/autoload.php';
const TEMPLATE_PATH = '../templates';
const STORAGE_IMAGES_PATH = '../public/storage/images';


use app\Controller\AccountController;
use app\Controller\AdminPanelController;
use app\Controller\AuthController;
use app\Controller\MainPageController;
use app\Controller\PostPageController;
use app\Core\DI\Container;
use app\Core\HTTP\Request\Request;
use app\Core\HTTP\Router;
use app\Kernel;
use app\MysqlClient;
use app\MysqlClientInterface;
use app\Repository\Account\AccountRepository;
use app\Repository\Account\AccountRepositoryInterface;
use app\Repository\Admin\AdminRepository;
use app\Repository\Admin\AdminRepositoryInterface;
use app\Repository\Auth\AuthRepository;
use app\Repository\Auth\AuthRepositoryInterface;
use app\Repository\Comment\CommentRepository;
use app\Repository\Comment\CommentRepositoryInterface;
use app\Repository\Image\ImageRepository;
use app\Repository\Image\ImageRepositoryInterface;
use app\Repository\Post\PostRepository;
use app\Repository\Post\PostRepositoryInterface;
use app\RequestValidator;
use app\Service\Account\AccountService;
use app\Service\Auth\AuthService;
use app\Service\Comment\CommentService;
use app\Service\Image\ImageService;
use app\Service\Post\PostService;
use app\Service\Validator\CommentValidator;
use app\Service\Validator\ImageValidator;
use app\Service\Validator\RegistrationValidator;
use app\Util\TemplateRenderer;

$container = new Container();
$container->setConfig(MysqlClient::class,'config',[
    'driver'=>'mysql',
    'host'=>'db',
    'database'=>'rettiwt',
    'user' => 'root',
    'pass' => 'root'
]);
$container->bindInterface(MysqlClientInterface::class, MysqlClient::class);
$container->bindInterface(AuthRepositoryInterface::class, AuthRepository::class);
$container->bindInterface(AccountRepositoryInterface::class, AccountRepository::class);
$container->bindInterface(PostRepositoryInterface::class, PostRepository::class);
$container->bindInterface(ImageRepositoryInterface::class, ImageRepository::class);
$container->bindInterface(CommentRepositoryInterface::class, CommentRepository::class);
$container->bindInterface(AdminRepositoryInterface::class, AdminRepository::class);
$container->register(
    Router::class,
    MysqlClient::class,
    TemplateRenderer::class,
    MainPageController::class,
    AccountController::class,
    PostPageController::class,
    AdminPanelController::class,
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
    ImageValidator::class,
    CommentValidator::class,
    CommentService::class,
    CommentRepository::class
)->build();


$request = new Request($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], $_POST, $_GET, $_FILES, $_SESSION);
$requestValidator = new RequestValidator($request);

$container->get(Router::class)->registerControllers(
        [
            MainPageController::class,
            AuthController::class,
            AccountController::class,
            AdminPanelController::class,
            PostPageController::class
        ]
);

$kernel = new Kernel($container, $requestValidator);
$response = $kernel->handle($request);
echo $response->getContent();
