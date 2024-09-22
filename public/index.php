<?php

require '../vendor/autoload.php';

const STORAGE_PATH = '../public/storage';
const TEMPLATE_PATH = '../templates';

use app\Core\DI\Container;
use app\Core\HTTP\Request\Request;
use app\Core\HTTP\Router;
use app\Kernel;
use app\Util\TemplateRenderer;

$container = new Container();
$container->register(Router::class, TemplateRenderer::class)->build();


$request = new Request($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], $_POST, $_GET, $_FILES);

$container->get(Router::class)->registerControllers(
        [

        ]
);


$kernel = new Kernel($container);
$response = $kernel->handle($request);
echo $response->getContent();
