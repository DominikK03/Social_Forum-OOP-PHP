<?php

namespace app\Controller;

use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Request\Request;
use app\Core\HTTP\Response\ResponseInterface;

class LoginController
{
    public function __construct()
    {
    }

    #[Route('/login', 'GET')]
    public function loginView(Request $request) : ResponseInterface
    {

    }

}