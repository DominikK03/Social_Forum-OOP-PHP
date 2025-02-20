<?php

require '../vendor/autoload.php';
const TEMPLATE_PATH = '../templates';
const STORAGE_IMAGES_PATH = '../public/storage/images';
const STORAGE_AVATARS_PATH = '../public/storage/images/avatars/';
const DEFAULT_AVATAR = 'defaultImage.png';
use app\Controller\AccountController;
use app\Controller\AdminPanelController;
use app\Controller\AuthController;
use app\Controller\MainPageController;
use app\Controller\PostPageController;
use app\Core\DI\Container;
use app\Core\HTTP\Request\RequestFactory;
use app\Core\HTTP\Request\RequestValidator;
use app\Core\HTTP\Router;
use app\Kernel;
use app\PDO\MysqlClientInterface;
use app\PDO\PDOMysqlClient;
use app\Repository\Account\MysqlMysqlAccountRepository;
use app\Repository\Account\MysqlAccountRepositoryInterface;
use app\Repository\Admin\AdminRepository;
use app\Repository\Admin\AdminRepositoryInterface;
use app\Repository\Auth\AuthRepository;
use app\Repository\Auth\AuthRepositoryInterface;
use app\Repository\Comment\CommentRepository;
use app\Repository\Comment\CommentRepositoryInterface;
use app\Repository\Image\FileSystemImageRepository;
use app\Repository\Image\FileSystemImageRepositoryInterface;
use app\Repository\Post\PostRepository;
use app\Repository\Post\PostRepositoryInterface;
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
$container->bindInterface(MysqlClientInterface::class, PDOMysqlClient::class);
$container->bindInterface(AuthRepositoryInterface::class, AuthRepository::class);
$container->bindInterface(MysqlAccountRepositoryInterface::class, MysqlMysqlAccountRepository::class);
$container->bindInterface(PostRepositoryInterface::class, PostRepository::class);
$container->bindInterface(FileSystemImageRepositoryInterface::class, FileSystemImageRepository::class);
$container->bindInterface(CommentRepositoryInterface::class, CommentRepository::class);
$container->bindInterface(AdminRepositoryInterface::class, AdminRepository::class);
$container->register(
    Router::class,
    PDOMysqlClient::class,
    TemplateRenderer::class,
    MainPageController::class,
    AccountController::class,
    PostPageController::class,
    AdminPanelController::class,
    AccountService::class,
    MysqlMysqlAccountRepository::class,
    AuthController::class,
    AuthService::class,
    AuthRepository::class,
    RegistrationValidator::class,
    FileSystemImageRepository::class,
    ImageService::class,
    PostService::class,
    PostRepository::class,
    ImageValidator::class,
    CommentValidator::class,
    CommentService::class,
    CommentRepository::class
)->build();

$request = RequestFactory::createFromGlobals();

$container->get(Router::class)->registerControllers(
        [
            MainPageController::class,
            AuthController::class,
            AccountController::class,
            AdminPanelController::class,
            PostPageController::class
        ]
);

$kernel = new Kernel($container);
$response = $kernel->handle($request);
$kernel->sendResponse($response);