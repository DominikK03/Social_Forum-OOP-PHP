<?php

namespace app\Controller;

use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Request\Request;
use app\Core\HTTP\Response\ResponseInterface;

class MainPageController
{

    #[Route('/', 'GET')]
    public function MainPage(Request $request) :  ResponseInterface
    {
        phpinfo();

    }

}